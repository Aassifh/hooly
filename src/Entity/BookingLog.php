<?php

namespace App\Entity;

use App\Repository\BookingLogRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookingLogRepository::class)]
class BookingLog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $status = [];

    #[ORM\Column]
    private ?int $foodtruck_id;

    #[ORM\Column]
    private ?int $entreprise_id = null;

    #[ORM\Column]
    private ?int $parking_id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): array
    {
        return $this->status;
    }

    public function setStatus(array $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getFoodtruckId(): ?int
    {
        return $this->foodtruck_id;
    }

    public function setFoodtruckId(int $foodtruck_id): self
    {
        $this->foodtruck_id = $foodtruck_id;

        return $this;
    }

    public function getEntrepriseId(): ?int
    {
        return $this->entreprise_id;
    }

    public function setEntrepriseId(int $entreprise_id): self
    {
        $this->entreprise_id = $entreprise_id;

        return $this;
    }

    public function getParkingId(): ?int
    {
        return $this->parking_id;
    }

    public function setParkingId(int $parking_id): self
    {
        $this->parking_id = $parking_id;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
