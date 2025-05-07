<?php

namespace App\Entity;

use App\Repository\QuartierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuartierRepository::class)]
class Quartier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\ManyToOne(inversedBy: 'quartiers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?City $city = null;

    /**
     * @var Collection<int, Coordonnees>
     */
    #[ORM\OneToMany(targetEntity: Coordonnees::class, mappedBy: 'coordonnees')]
    private Collection $coordonnees;

    public function __construct()
    {
        $this->coordonnees = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): static
    {
        $this->Name = $Name;

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): static
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return Collection<int, Coordonnees>
     */
    public function getCoordonnees(): Collection
    {
        return $this->coordonnees;
    }

    public function addCoordonnee(Coordonnees $coordonnee): static
    {
        if (!$this->coordonnees->contains($coordonnee)) {
            $this->coordonnees->add($coordonnee);
            $coordonnee->setCoordonnees($this);
        }

        return $this;
    }

    public function removeCoordonnee(Coordonnees $coordonnee): static
    {
        if ($this->coordonnees->removeElement($coordonnee)) {
            // set the owning side to null (unless already changed)
            if ($coordonnee->getCoordonnees() === $this) {
                $coordonnee->setCoordonnees(null);
            }
        }

        return $this;
    }
}
