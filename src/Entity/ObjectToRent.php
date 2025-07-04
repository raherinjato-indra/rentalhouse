<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
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

    #[ORM\ManyToOne(inversedBy: 'objectToRents')]
    #[ORM\JoinColumn(nullable: true)]
    private ?User $user = null;


    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descriptionText = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\ManyToOne(inversedBy: 'objectToRents')]
    private ?Coordonnees $coordonnee = null;

    

    #[ORM\ManyToOne(inversedBy: 'objectsToRent')]
    private ?TypeObjectToRent $typeObjectToRent = null;

    #[ORM\Column(nullable: true)]
    private ?float $surface = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $nbrPieces = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $nbrSalleDeBain = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $nbrSalleDeau = null;

    #[ORM\Column(nullable: true)]
    private ?bool $cuisineEquipee = null;

    #[ORM\Column(nullable: true)]
    private ?bool $terasse = null;

    #[ORM\Column(nullable: true)]
    private ?bool $balcon = null;

    #[ORM\Column(nullable: true)]
    private ?bool $jardin = null;

    #[ORM\Column(nullable: true)]
    private ?bool $piscine = null;

    #[ORM\Column(nullable: true)]
    private ?bool $accessibleFauteuilsRoulants = null;

    #[ORM\Column(nullable: true)]
    private ?bool $garage = null;

    #[ORM\Column(nullable: true)]
    private ?bool $sousSol = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $nbrTerasse = null;

    #[ORM\Column(nullable: true)]
    private ?float $surfaceBalcon = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $nbrChambres = null;

    #[ORM\Column(nullable: true)]
    private ?int $anneeConstruction = null;

    #[ORM\Column(nullable: true)]
    private ?float $surfaceTerrain = null;

    #[ORM\ManyToOne(inversedBy: 'objectsToRent')]
    private ?EtatObjectToRent $etatObjectToRent = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $imageFilename = null;

    #[ORM\Column]
    private ?bool $activated = null;

    // Ajoute cette propriété avec sa relation ManyToOne
#[ORM\ManyToOne(inversedBy: 'objectsToRent')]
private ?Quartier $quartier = null;

public function getQuartier(): ?Quartier
{
    return $this->quartier;
}

public function setQuartier(?Quartier $quartier): self
{
    $this->quartier = $quartier;
    return $this;
}


    // --- Getters & Setters ---

    public function getId(): ?int { return $this->id; }

    public function getName(): ?string { return $this->name; }
    public function setName(string $name): self { $this->name = $name; return $this; }

    public function getDescriptionText(): ?string { return $this->descriptionText; }
    public function setDescriptionText(?string $descriptionText): self { $this->descriptionText = $descriptionText; return $this; }

    public function getPrice(): ?float { return $this->price; }
    public function setPrice(float $price): self { $this->price = $price; return $this; }

    public function getCoordonnee(): ?Coordonnees { return $this->coordonnee; }
    public function setCoordonnee(?Coordonnees $coordonnee): self { $this->coordonnee = $coordonnee; return $this; }

    public function getUser(): ?User { return $this->user; }
    public function setUser(?User $user): self { $this->user = $user; return $this; }

    public function getTypeObjectToRent(): ?TypeObjectToRent { return $this->typeObjectToRent; }
    public function setTypeObjectToRent(?TypeObjectToRent $typeObjectToRent): self { $this->typeObjectToRent = $typeObjectToRent; return $this; }

    public function getSurface(): ?float { return $this->surface; }
    public function setSurface(?float $surface): self { $this->surface = $surface; return $this; }

    public function getNbrPieces(): ?int { return $this->nbrPieces; }
    public function setNbrPieces(?int $nbrPieces): self { $this->nbrPieces = $nbrPieces; return $this; }

    public function getNbrSalleDeBain(): ?int { return $this->nbrSalleDeBain; }
    public function setNbrSalleDeBain(?int $nbrSalleDeBain): self { $this->nbrSalleDeBain = $nbrSalleDeBain; return $this; }

    public function getNbrSalleDeau(): ?int { return $this->nbrSalleDeau; }
    public function setNbrSalleDeau(?int $nbrSalleDeau): self { $this->nbrSalleDeau = $nbrSalleDeau; return $this; }

    public function isCuisineEquipee(): ?bool { return $this->cuisineEquipee; }
    public function setCuisineEquipee(?bool $cuisineEquipee): self { $this->cuisineEquipee = $cuisineEquipee; return $this; }

    public function isTerasse(): ?bool { return $this->terasse; }
    public function setTerasse(?bool $terasse): self { $this->terasse = $terasse; return $this; }

    public function isBalcon(): ?bool { return $this->balcon; }
    public function setBalcon(?bool $balcon): self { $this->balcon = $balcon; return $this; }

    public function isJardin(): ?bool { return $this->jardin; }
    public function setJardin(?bool $jardin): self { $this->jardin = $jardin; return $this; }

    public function isPiscine(): ?bool { return $this->piscine; }
    public function setPiscine(?bool $piscine): self { $this->piscine = $piscine; return $this; }

    public function isAccessibleFauteuilsRoulants(): ?bool { return $this->accessibleFauteuilsRoulants; }
    public function setAccessibleFauteuilsRoulants(?bool $accessible): self { $this->accessibleFauteuilsRoulants = $accessible; return $this; }

    public function isGarage(): ?bool { return $this->garage; }
    public function setGarage(?bool $garage): self { $this->garage = $garage; return $this; }

    public function isSousSol(): ?bool { return $this->sousSol; }
    public function setSousSol(?bool $sousSol): self { $this->sousSol = $sousSol; return $this; }

    public function getNbrTerasse(): ?int { return $this->nbrTerasse; }
    public function setNbrTerasse(?int $nbrTerasse): self { $this->nbrTerasse = $nbrTerasse; return $this; }

    public function getSurfaceBalcon(): ?float { return $this->surfaceBalcon; }
    public function setSurfaceBalcon(?float $surfaceBalcon): self { $this->surfaceBalcon = $surfaceBalcon; return $this; }

    public function getNbrChambres(): ?int { return $this->nbrChambres; }
    public function setNbrChambres(?int $nbrChambres): self { $this->nbrChambres = $nbrChambres; return $this; }

    public function getAnneeConstruction(): ?int { return $this->anneeConstruction; }
    public function setAnneeConstruction(?int $anneeConstruction): self { $this->anneeConstruction = $anneeConstruction; return $this; }

    public function getSurfaceTerrain(): ?float { return $this->surfaceTerrain; }
    public function setSurfaceTerrain(?float $surfaceTerrain): self { $this->surfaceTerrain = $surfaceTerrain; return $this; }

    public function getEtatObjectToRent(): ?EtatObjectToRent { return $this->etatObjectToRent; }
    public function setEtatObjectToRent(?EtatObjectToRent $etat): self { $this->etatObjectToRent = $etat; return $this; }

    public function getImageFilename(): ?string { return $this->imageFilename; }
    public function setImageFilename(?string $imageFilename): self { $this->imageFilename = $imageFilename; return $this; }

    public function isActivated(): ?bool { return $this->activated; }
    public function setActivated(bool $activated): self { $this->activated = $activated; return $this; }
}
