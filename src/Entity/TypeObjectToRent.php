<?php

namespace App\Entity;

use App\Repository\TypeObjectToRentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeObjectToRentRepository::class)]
class TypeObjectToRent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    /**
     * @var Collection<int, ObjectToRent>
     */
    #[ORM\OneToMany(targetEntity: ObjectToRent::class, mappedBy: 'typeObjectToRent')]
    private Collection $ObjectsToRent;

    public function __construct()
    {
        $this->ObjectsToRent = new ArrayCollection();
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
            $objectsToRent->setTypeObjectToRent($this);
        }

        return $this;
    }

    public function removeObjectsToRent(ObjectToRent $objectsToRent): static
    {
        if ($this->ObjectsToRent->removeElement($objectsToRent)) {
            // set the owning side to null (unless already changed)
            if ($objectsToRent->getTypeObjectToRent() === $this) {
                $objectsToRent->setTypeObjectToRent(null);
            }
        }

        return $this;
    }
}
