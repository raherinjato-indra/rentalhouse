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
    private ?string $name = null;

    /**
     * @var Collection<int, ObjectToRent>
     */
    #[ORM\OneToMany(targetEntity: ObjectToRent::class, mappedBy: 'typeObjectToRent')]
    private Collection $objectsToRent;

    public function __construct()
    {
        $this->objectsToRent = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
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
            $objectToRent->setTypeObjectToRent($this);
        }

        return $this;
    }

    public function removeObjectToRent(ObjectToRent $objectToRent): static
    {
        if ($this->objectsToRent->removeElement($objectToRent)) {
            if ($objectToRent->getTypeObjectToRent() === $this) {
                $objectToRent->setTypeObjectToRent(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->name ?? '';
    }
}
