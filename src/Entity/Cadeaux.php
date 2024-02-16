<?php

namespace App\Entity;

use App\Repository\CadeauxRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CadeauxRepository::class)]
class Cadeaux
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_cad = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $descrp_Cad = null;

    #[ORM\Column(length: 255)]
    private ?string $photo_cad = null;

    #[ORM\Column]
    private ?int $point_cad = null;

    #[ORM\ManyToOne(inversedBy: 'cadeauxes')]
    private ?User $idUser = null;

    #[ORM\ManyToMany(targetEntity: Don::class, mappedBy: 'idCadeaux')]
    private Collection $dons;

    public function __construct()
    {
        $this->dons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCad(): ?string
    {
        return $this->nom_cad;
    }

    public function setNomCad(string $nom_cad): static
    {
        $this->nom_cad = $nom_cad;

        return $this;
    }

    public function getDescrpCad(): ?string
    {
        return $this->descrp_Cad;
    }

    public function setDescrpCad(?string $descrp_Cad): static
    {
        $this->descrp_Cad = $descrp_Cad;

        return $this;
    }

    public function getPhotoCad(): ?string
    {
        return $this->photo_cad;
    }

    public function setPhotoCad(string $photo_cad): static
    {
        $this->photo_cad = $photo_cad;

        return $this;
    }

    public function getPointCad(): ?int
    {
        return $this->point_cad;
    }

    public function setPointCad(int $point_cad): static
    {
        $this->point_cad = $point_cad;

        return $this;
    }

    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    public function setIdUser(?User $idUser): static
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * @return Collection<int, Don>
     */
    public function getDons(): Collection
    {
        return $this->dons;
    }

    public function addDon(Don $don): static
    {
        if (!$this->dons->contains($don)) {
            $this->dons->add($don);
            $don->addIdCadeaux($this);
        }

        return $this;
    }

    public function removeDon(Don $don): static
    {
        if ($this->dons->removeElement($don)) {
            $don->removeIdCadeaux($this);
        }

        return $this;
    }
}
