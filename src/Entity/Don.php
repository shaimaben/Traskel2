<?php

namespace App\Entity;

use App\Repository\DonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DonRepository::class)]
class Don
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $image_Don = null;

    #[ORM\Column]
    private ?float $quantite_Don = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $descrp_Don = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse_Don = null;

    #[ORM\Column(nullable: true)]
    private ?int $point_Don = null;

    #[ORM\ManyToOne(inversedBy: 'checkDon')]
    private ?User $UserIdent = null;

    #[ORM\ManyToOne(inversedBy: 'dons')]
    private ?User $Userident = null;

    #[ORM\ManyToOne(inversedBy: 'dons')]
    private ?Checkdon $checkDon = null;

    #[ORM\ManyToMany(targetEntity: Cadeaux::class, inversedBy: 'dons')]
    private Collection $idCadeaux;

    public function __construct()
    {
        $this->idCadeaux = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImageDon(): ?string
    {
        return $this->image_Don;
    }

    public function setImageDon(string $image_Don): static
    {
        $this->image_Don = $image_Don;

        return $this;
    }

    public function getQuantiteDon(): ?float
    {
        return $this->quantite_Don;
    }

    public function setQuantiteDon(float $quantite_Don): static
    {
        $this->quantite_Don = $quantite_Don;

        return $this;
    }

    public function getDescrpDon(): ?string
    {
        return $this->descrp_Don;
    }

    public function setDescrpDon(?string $descrp_Don): static
    {
        $this->descrp_Don = $descrp_Don;

        return $this;
    }

    public function getAdresseDon(): ?string
    {
        return $this->adresse_Don;
    }

    public function setAdresseDon(string $adresse_Don): static
    {
        $this->adresse_Don = $adresse_Don;

        return $this;
    }

    public function getPointDon(): ?int
    {
        return $this->point_Don;
    }

    public function setPointDon(?int $point_Don): static
    {
        $this->point_Don = $point_Don;

        return $this;
    }

    public function getUserIdent(): ?User
    {
        return $this->UserIdent;
    }

    public function setUserIdent(?User $UserIdent): static
    {
        $this->UserIdent = $UserIdent;

        return $this;
    }

    public function getCheckDon(): ?Checkdon
    {
        return $this->checkDon;
    }

    public function setCheckDon(?Checkdon $checkDon): static
    {
        $this->checkDon = $checkDon;

        return $this;
    }

    /**
     * @return Collection<int, Cadeaux>
     */
    public function getIdCadeaux(): Collection
    {
        return $this->idCadeaux;
    }

    public function addIdCadeaux(Cadeaux $idCadeaux): static
    {
        if (!$this->idCadeaux->contains($idCadeaux)) {
            $this->idCadeaux->add($idCadeaux);
        }

        return $this;
    }

    public function removeIdCadeaux(Cadeaux $idCadeaux): static
    {
        $this->idCadeaux->removeElement($idCadeaux);

        return $this;
    }
}
