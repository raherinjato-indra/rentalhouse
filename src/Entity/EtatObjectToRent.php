<?php

namespace App\Entity;

use App\Repository\EtatObjectToRentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\ObjectToRent;

#[ORM\Entity(repositoryClass: EtatObjectToRentRepository::class)]
class EtatObjectToRent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Libelle = null;

    /**
     * @var Collection<int, ObjectToRent>
     */
    #[ORM\OneToMany(mappedBy: 'etatObjectToRent', targetEntity: ObjectToRent::class)]
    private Collection $objectsToRent;

    public function __construct()
    {
        $this->objectsToRent = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->Libelle;
    }

    public function setLibelle(string $Libelle): static
    {
        $this->Libelle = $Libelle;
        return $this;
    }

    /**
     * @return Collection<int, ObjectToRent>
     */
    public function getObjectsToRent(): Collection
    {
        return $this->objectsToRent;
    }

    public function addObjectToRent(ObjectToRent $objectToRent): static
    {
        if (!$this->objectsToRent->contains($objectToRent)) {
            $this->objectsToRent->add($objectToRent);
            $objectToRent->setEtatObjectToRent($this);
        }

        return $this;
    }

    public function removeObjectToRent(ObjectToRent $objectToRent): static
    {
        if ($this->objectsToRent->removeElement($objectToRent)) {
            if ($objectToRent->getEtatObjectToRent() === $this) {
                $objectToRent->setEtatObjectToRent(null);
            }
        }

        return $this;
    }
}
