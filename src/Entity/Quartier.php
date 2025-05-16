<?php

namespace App\Entity;

use App\Repository\QuartierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Coordonnees;

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

        public function __construct()
        {
            $this->coordonnees = new ArrayCollection();
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
                // set the owning side to null (unless already changed)
                if ($coordonnee->getQuartier() === $this) {
                    $coordonnee->setQuartier(null);
                }
            }

            return $this;
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
}
