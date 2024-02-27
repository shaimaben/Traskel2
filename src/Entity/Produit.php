<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomProd = null;

    #[ORM\Column(length: 10000, nullable: true)]
    private ?string $descrpProd = null;

    #[ORM\Column(length: 255)]
    private ?string $photoProd = null;

    #[ORM\Column]
    private ?string $typeProd = null;

    #[ORM\Column]
    private ?float $prixProd = null;

    #[ORM\ManyToOne(inversedBy: 'produits')]
    private ?User $idUser = null;

    #[ORM\ManyToOne(inversedBy: 'produits')]
    private ?CategorieProd $idCat = null;

    #[ORM\ManyToOne(inversedBy: 'idprod')]
    private ?Panier $panier = null;
    private $produits;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomProd(): ?string
    {
        return $this->nomProd;
    }

    public function setNomProd(string $nomProd): static
    {
        $this->nomProd = $nomProd;

        return $this;
    }

    public function getDescrpProd(): ?string
    {
        return $this->descrpProd;
    }

    public function setDescrpProd(?string $descrpProd): static
    {
        $this->descrpProd = $descrpProd;

        return $this;
    }

    public function getPhotoProd(): ?string
    {
        return $this->photoProd;
    }

    public function setPhotoProd(string $photoProd): static
    {
        $this->photoProd = $photoProd;

        return $this;
    }

    public function getTypeProd(): ?string
    {
        return $this->typeProd;
    }

    public function setTypeProd(string $typeProd): static
    {
        $this->typeProd = $typeProd;

        return $this;
    }

    public function getPrixProd(): ?float
    {
        return $this->prixProd;
    }

    public function setPrixProd(float $prixProd): static
    {
        $this->prixProd = $prixProd;

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

    public function getIdCat(): ?CategorieProd
    {
        return $this->idCat;
    }

    public function setIdCat(?CategorieProd $idCat): static
    {
        $this->idCat = $idCat;

        return $this;
    }

    public function getPanier(): ?Panier
    {
        return $this->panier;
    }

    public function setPanier(?Panier $panier): static
    {
        $this->panier = $panier;

        return $this;
    }
}
