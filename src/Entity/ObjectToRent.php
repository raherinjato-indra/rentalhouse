<?php

namespace App\Entity;

use App\Repository\ObjectToRentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ObjectToRentRepository::class)]
class ObjectToRent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descriptionText = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\ManyToOne(inversedBy: 'objectToRents')]
    private ?Coordonnees $Coordonnee = null;

    #[ORM\ManyToOne(inversedBy: 'objectToRents')]
    private ?User $User = null;

    #[ORM\ManyToOne(inversedBy: 'ObjectsToRent')]
    private ?TypeObjectToRent $typeObjectToRent = null;

    #[ORM\Column(nullable: true)]
    private ?float $Surface = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $NbrPieces = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $NbrSalleDeBain = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $NbrSalleDeau = null;

    #[ORM\Column(nullable: true)]
    private ?bool $CuisineEquipe = null;

    #[ORM\Column(nullable: true)]
    private ?bool $Terasse = null;

    #[ORM\Column(nullable: true)]
    private ?bool $Balcon = null;

    #[ORM\Column(nullable: true)]
    private ?bool $Jardin = null;

    #[ORM\Column(nullable: true)]
    private ?bool $Piscine = null;

    #[ORM\Column(nullable: true)]
    private ?bool $AccessibleFauteuilsRoulants = null;

    #[ORM\Column(nullable: true)]
    private ?bool $Garage = null;

    #[ORM\Column(nullable: true)]
    private ?bool $SousSol = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $NbrTerasse = null;

    #[ORM\Column(nullable: true)]
    private ?float $SurfaceBalcon = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $NbrChambres = null;

    #[ORM\Column(nullable: true)]
    private ?int $AnneeConstruction = null;

    #[ORM\Column(nullable: true)]
    private ?float $SurfaceTerrain = null;

    #[ORM\ManyToOne(inversedBy: 'ObjectsToRent')]
    private ?EtatObjectToRent $etatObjectToRent = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $photo = null;

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;
        return $this;
    }

    #[ORM\Column]
    private ?bool $activated = null;
    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $imageFilename = null;

    public function getImageFilename(): ?string
    {
        return $this->imageFilename;
    }

    public function setImageFilename(?string $imageFilename): self
    {
        $this->imageFilename = $imageFilename;

        return $this;
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

    public function getDescriptionText(): ?string
    {
        return $this->descriptionText;
    }

    public function setDescriptionText(?string $descriptionText): static
    {
        $this->descriptionText = $descriptionText;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getCoordonnee(): ?Coordonnees
    {
        return $this->Coordonnee;
    }

    public function setCoordonnee(?Coordonnees $Coordonnee): static
    {
        $this->Coordonnee = $Coordonnee;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): static
    {
        $this->User = $User;

        return $this;
    }

    public function getTypeObjectToRent(): ?TypeObjectToRent
    {
        return $this->typeObjectToRent;
    }

    public function setTypeObjectToRent(?TypeObjectToRent $typeObjectToRent): static
    {
        $this->typeObjectToRent = $typeObjectToRent;

        return $this;
    }

    public function getSurface(): ?float
    {
        return $this->Surface;
    }

    public function setSurface(?float $Surface): static
    {
        $this->Surface = $Surface;

        return $this;
    }

    public function getNbrPieces(): ?int
    {
        return $this->NbrPieces;
    }

    public function setNbrPieces(?int $NbrPieces): static
    {
        $this->NbrPieces = $NbrPieces;

        return $this;
    }

    public function getNbrSalleDeBain(): ?int
    {
        return $this->NbrSalleDeBain;
    }

    public function setNbrSalleDeBain(?int $NbrSalleDeBain): static
    {
        $this->NbrSalleDeBain = $NbrSalleDeBain;

        return $this;
    }

    public function getNbrSalleDeau(): ?int
    {
        return $this->NbrSalleDeau;
    }

    public function setNbrSalleDeau(?int $NbrSalleDeau): static
    {
        $this->NbrSalleDeau = $NbrSalleDeau;

        return $this;
    }

    public function isCuisineEquipe(): ?bool
    {
        return $this->CuisineEquipe;
    }

    public function setCuisineEquipe(?bool $CuisineEquipe): static
    {
        $this->CuisineEquipe = $CuisineEquipe;

        return $this;
    }

    public function isTerasse(): ?bool
    {
        return $this->Terasse;
    }

    public function setTerasse(?bool $Terasse): static
    {
        $this->Terasse = $Terasse;

        return $this;
    }

    public function isBalcon(): ?bool
    {
        return $this->Balcon;
    }

    public function setBalcon(?bool $Balcon): static
    {
        $this->Balcon = $Balcon;

        return $this;
    }

    public function isJardin(): ?bool
    {
        return $this->Jardin;
    }

    public function setJardin(?bool $Jardin): static
    {
        $this->Jardin = $Jardin;

        return $this;
    }

    public function isPiscine(): ?bool
    {
        return $this->Piscine;
    }

    public function setPiscine(?bool $Piscine): static
    {
        $this->Piscine = $Piscine;

        return $this;
    }

    public function isAccessibleFauteuilsRoulants(): ?bool
    {
        return $this->AccessibleFauteuilsRoulants;
    }

    public function setAccessibleFauteuilsRoulants(?bool $AccessibleFauteuilsRoulants): static
    {
        $this->AccessibleFauteuilsRoulants = $AccessibleFauteuilsRoulants;

        return $this;
    }

    public function isGarage(): ?bool
    {
        return $this->Garage;
    }

    public function setGarage(?bool $Garage): static
    {
        $this->Garage = $Garage;

        return $this;
    }

    public function isSousSol(): ?bool
    {
        return $this->SousSol;
    }

    public function setSousSol(?bool $SousSol): static
    {
        $this->SousSol = $SousSol;

        return $this;
    }

    public function getNbrTerasse(): ?int
    {
        return $this->NbrTerasse;
    }

    public function setNbrTerasse(?int $NbrTerasse): static
    {
        $this->NbrTerasse = $NbrTerasse;

        return $this;
    }

    public function getSurfaceBalcon(): ?float
    {
        return $this->SurfaceBalcon;
    }

    public function setSurfaceBalcon(?float $SurfaceBalcon): static
    {
        $this->SurfaceBalcon = $SurfaceBalcon;

        return $this;
    }

    public function getNbrChambres(): ?int
    {
        return $this->NbrChambres;
    }

    public function setNbrChambres(?int $NbrChambres): static
    {
        $this->NbrChambres = $NbrChambres;

        return $this;
    }

    public function getAnneeConstruction(): ?int
    {
        return $this->AnneeConstruction;
    }

    public function setAnneeConstruction(?int $AnneeConstruction): static
    {
        $this->AnneeConstruction = $AnneeConstruction;

        return $this;
    }

    public function getSurfaceTerrain(): ?float
    {
        return $this->SurfaceTerrain;
    }

    public function setSurfaceTerrain(?float $SurfaceTerrain): static
    {
        $this->SurfaceTerrain = $SurfaceTerrain;

        return $this;
    }

    public function getEtatObjectToRent(): ?EtatObjectToRent
    {
        return $this->etatObjectToRent;
    }

    public function setEtatObjectToRent(?EtatObjectToRent $etatObjectToRent): static
    {
        $this->etatObjectToRent = $etatObjectToRent;

        return $this;
    }

    public function isActivated(): ?bool
    {
        return $this->activated;
    }

    public function setActivated(bool $activated): static
    {
        $this->activated = $activated;

        return $this;
    }
}
