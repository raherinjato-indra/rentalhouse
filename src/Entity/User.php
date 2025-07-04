<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $avatar = null;

    /**
     * @var Collection<int, ObjectToRent>
     */
    #[ORM\OneToMany(targetEntity: ObjectToRent::class, mappedBy: 'User')]
    private Collection $objectToRents;

    public function __construct()
    {
        $this->objectToRents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    public function eraseCredentials(): void
    {
        // Nettoyage si nécessaire
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): static
    {
        $this->avatar = $avatar;
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
            $objectToRent->setUser($this);
        }

        return $this;
    }

    public function removeObjectToRent(ObjectToRent $objectToRent): static
    {
        if ($this->objectToRents->removeElement($objectToRent)) {
            if ($objectToRent->getUser() === $this) {
                $objectToRent->setUser(null);
            }
        }

        return $this;
    }
}
