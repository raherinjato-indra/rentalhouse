<?php

namespace App\Entity;

use App\Repository\QuartierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Coordonnees;
use App\Entity\City;
use App\Entity\ObjectToRent;

#[ORM\Entity(repositoryClass: QuartierRepository::class)]
class Quartier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $nom = null;

    #[ORM\ManyToOne(targetEntity: City::class, inversedBy: 'quartiers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?City $city = null;

    #[ORM\OneToMany(mappedBy: 'quartier', targetEntity: Coordonnees::class)]
    private Collection $coordonnees;

    #[ORM\OneToMany(mappedBy: 'quartier', targetEntity: ObjectToRent::class)]
    private Collection $objectsToRent;

    public function __construct()
    {
        $this->coordonnees = new ArrayCollection();
        $this->objectsToRent = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): self
    {
        $this->city = $city;
        return $this;
    }

    public function getCoordonnees(): Collection
    {
        return $this->coordonnees;
    }

    public function addCoordonnee(Coordonnees $coordonnee): self
    {
        if (!$this->coordonnees->contains($coordonnee)) {
            $this->coordonnees[] = $coordonnee;
            $coordonnee->setQuartier($this);
        }

        return $this;
    }

    public function removeCoordonnee(Coordonnees $coordonnee): self
    {
        if ($this->coordonnees->removeElement($coordonnee)) {
            if ($coordonnee->getQuartier() === $this) {
                $coordonnee->setQuartier(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ObjectToRent>
     */
    public function getObjectsToRent(): Collection
    {
        return $this->objectsToRent;
    }

    public function addObjectToRent(ObjectToRent $objectToRent): self
    {
        if (!$this->objectsToRent->contains($objectToRent)) {
            $this->objectsToRent[] = $objectToRent;
            $objectToRent->setQuartier($this);
        }

        return $this;
    }

    public function removeObjectToRent(ObjectToRent $objectToRent): self
    {
        if ($this->objectsToRent->removeElement($objectToRent)) {
            if ($objectToRent->getQuartier() === $this) {
                $objectToRent->setQuartier(null);
            }
        }

        return $this;
    }
}
