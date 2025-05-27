<?php

namespace App\Entity;

use App\Repository\CoordonneesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CoordonneesRepository::class)]
class Coordonnees
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    #[ORM\Column(nullable: true)]
    private ?float $longitude = null;

    #[ORM\Column(nullable: true)]
    private ?float $latitude = null;

    #[ORM\Column(length: 8)]
    private ?string $CodePostal = null;


   #[ORM\ManyToOne(inversedBy: 'coordonnees')]
   #[ORM\JoinColumn(nullable: false)]
   private ?Quartier $quartier = null;

    /**
     * @var Collection<int, ObjectToRent>
     */
    #[ORM\OneToMany(targetEntity: ObjectToRent::class, mappedBy: 'Coordonnee')]
    private Collection $objectToRents;

    public function __construct()
    {
        $this->objectToRents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->CodePostal;
    }

    public function setCodePostal(string $CodePostal): static
    {
        $this->CodePostal = $CodePostal;

        return $this;
    }

    public function getQuartier(): ?Quartier
{
    return $this->quartier;
}

public function setQuartier(?Quartier $quartier): static
{
    $this->quartier = $quartier;
    return $this;
}



    /**
     * @return Collection<int, ObjectToRent>
     */
    public function getObjectToRents(): Collection
    {
        return $this->objectToRents;
    }

    public function addObjectToRent(ObjectToRent $objectToRent): static
    {
        if (!$this->objectToRents->contains($objectToRent)) {
            $this->objectToRents->add($objectToRent);
            $objectToRent->setCoordonnee($this);
        }

        return $this;
    }

    public function removeObjectToRent(ObjectToRent $objectToRent): static
    {
        if ($this->objectToRents->removeElement($objectToRent)) {
            // set the owning side to null (unless already changed)
            if ($objectToRent->getCoordonnee() === $this) {
                $objectToRent->setCoordonnee(null);
            }
        }

        return $this;
    }
}
