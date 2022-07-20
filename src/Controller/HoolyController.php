<?php

namespace App\Controller;

use App\Entity\BookingLog;
use App\Entity\Foodtruck;
use App\Entity\Hooly;
use App\Entity\Parking;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class HoolyController extends AbstractController
{

	#[Route('/hooly', name: 'app_hooly')]
	function index(): JsonResponse
	{
		return $this->json([
			'message' => 'Welcome to your new controller!',
			'path' => 'src/Controller/HoolyController.php',
		]);
	}


	#[Route('/hooly/info', name: 'app_hooly')]
	function info(ManagerRegistry $doctrine): JsonResponse
	{
		$info = $doctrine
			->getRepository(Hooly::class)
			->find(1);
		$data = [
			'id' => $info->getId(),
			'info' => $info->getDescription(),
		];
		return $this->json($data);
	}
	#[Route('/hooly/parking', name: 'app_hooly')]
	function availablePlaces(ManagerRegistry $doctrine): JsonResponse
	{
		$places = $doctrine
			->getRepository(Hooly::class)
			->find(1);
		$parked = $doctrine
			->getRepository(Parking::class)
			->findAll();
		$occupied = [
			'id' => $places->getId(),
			'available_places' => $places->getAvailablePlaces(),
			'foodtrucks_parked' => count($parked),
			'foodtrucks_ids' => array_map(function ($element) {
				return $element->getId();
			}, $parked)
		];
		return $this->json($occupied);
	}
	#[Route('/hooly/register/truck', name: 'app_hooly')]
	function registerTruck(ManagerRegistry $doctrine, string $description = null): JsonResponse
	{

		$entityManager = $doctrine->getManager();
		$foodtruck = new Foodtruck();
		$foodtruck->setDescription($description);
		$entityManager->persist($foodtruck);
		$entityManager->flush();

		return $this->json('truck registred successfully with id ' . $foodtruck->getId());
	}
	#[Route('/hooly/book', name: 'app_hooly')]
	function bookParking(ManagerRegistry $doctrine, Request $request): JsonResponse
	{

		//check if the foodtuck already booked this week 
		$check = $doctrine
			->getRepository(BookingLog::class)->checkBooking($request->request->get('id'), $request->request->get('date'));


		if (count($check) > 0) {
			return $this->json('You already booked a parking place this week');
		}
		//check if there is place available
		$entreprise = $doctrine
			->getRepository(Hooly::class)
			->find(1);
		$foodtruck = $doctrine
			->getRepository(Foodtruck::class)
			->find($request->request->get('id'));
		if (empty($foodtruck)) {
			return $this->json('register your truck first to make a reservation');
		}


		if ($entreprise->getAvailablePlaces() == 0) {
			return $this->json('No place left in the parking');
		} else if (date('D') == 'Fri' && $entreprise->getAvailablePlaces() == 1) {
			//check the day of the booking 
			return $this->json('No place left in the parking');
		}
		//check if the day of the booking already passed 
		if (new DateTime($request->request->get('date')) < new DateTime()) {
			return $this->json('The day of reservation is past the current day');
		}
		// all conditions satisfied :) 
		$entityManager = $doctrine->getManager();

		$parking = new Parking();
		$parking->addEntrepriseId($entreprise);
		$parking->setFoodtruckId($request->request->get('id'));
		$parking->setEntrepriseName($entreprise->getName());

		$entityManager->persist($parking);
		$entityManager->flush();

		$bookinLog = new BookingLog();
		$bookinLog->setEntrepriseId($entreprise->getId());
		$bookinLog->setFoodtruckId($foodtruck->getId());
		$bookinLog->setDate(new DateTime($request->request->get('date')));
		$bookinLog->setParkingId($parking->getId());
		$entityManager->persist($bookinLog);

		$entreprise->setAvailablePlaces($entreprise->getAvailablePlaces() - 1);
		$entityManager->flush();

		return $this->json('Parking place at Hooly Booked for ' . $request->request->get('date') . ' For truck' . $request->request->get('id'));
	}
}
