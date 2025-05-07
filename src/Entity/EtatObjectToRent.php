<?php

namespace App\Entity;

use App\Repository\EtatObjectToRentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

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
    #[ORM\OneToMany(targetEntity: ObjectToRent::class, mappedBy: 'etatObjectToRent')]
    private Collection $ObjectsToRent;

    public function __construct()
    {
        $this->ObjectsToRent = new ArrayCollection();
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
        return $this->ObjectsToRent;
    }

    public function addObjectsToRent(ObjectToRent $objectsToRent): static
    {
        if (!$this->ObjectsToRent->contains($objectsToRent)) {
            $this->ObjectsToRent->add($objectsToRent);
            $objectsToRent->setEtatObjectToRent($this);
        }

        return $this;
    }

    public function removeObjectsToRent(ObjectToRent $objectsToRent): static
    {
        if ($this->ObjectsToRent->removeElement($objectsToRent)) {
            // set the owning side to null (unless already changed)
            if ($objectsToRent->getEtatObjectToRent() === $this) {
                $objectsToRent->setEtatObjectToRent(null);
            }
        }

        return $this;
    }
}
