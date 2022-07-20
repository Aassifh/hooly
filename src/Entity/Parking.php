<?php

namespace App\Entity;

use App\Repository\ParkingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParkingRepository::class)]
class Parking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $entreprise_name = null;

    #[ORM\OneToMany(mappedBy: 'foodtruck_id', targetEntity: Hooly::class)]
    private Collection $entreprise_id;

    // #[ORM\OneToOne(targetEntity: self::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private int $foodtruck_id;

    public function __construct()
    {
        $this->entreprise_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEntrepriseName(): ?string
    {
        return $this->entreprise_name;
    }

    public function setEntrepriseName(string $entreprise_name): self
    {
        $this->entreprise_name = $entreprise_name;

        return $this;
    }

    /**
     * @return Collection<int, Hooly>
     */
    public function getEntrepriseId(): Collection
    {
        return $this->entreprise_id;
    }

    public function addEntrepriseId(Hooly $entrepriseId): self
    {
        if (!$this->entreprise_id->contains($entrepriseId)) {
            $this->entreprise_id[] = $entrepriseId;
        }

        return $this;
    }

    public function removeEntrepriseId(Hooly $entrepriseId): self
    {
        $this->entreprise_id->removeElement($entrepriseId);

        return $this;
    }

    public function getFoodtruckId(): int
    {
        return $this->foodtruck_id;
    }

    public function setFoodtruckId(int $foodtruck_id): self
    {
        $this->foodtruck_id = $foodtruck_id;

        return $this;
    }
}
