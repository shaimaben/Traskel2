<?php

namespace App\Entity;

use App\Repository\PanierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PanierRepository::class)]
class Panier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $nbr_Prods = null;

    #[ORM\Column]
    private ?float $total_prix = null;

    #[ORM\OneToMany(targetEntity: Produit::class, mappedBy: 'panier')]
    private Collection $idprod;

    #[ORM\ManyToOne(inversedBy: 'idPanier')]
    private ?Livraison $livraison = null;

    #[ORM\Column(type: Types::SIMPLE_ARRAY, nullable: true)]
    private ?array $produits_id = null;
    private $produits;
    public function __construct()
    {
        $this->produits = new ArrayCollection();
        $this->idprod = new ArrayCollection();
    }
        /**
     * @return Collection|Produit[]
     */
    public function getProduits(): Collection
    {
        return $this->produits ?? new ArrayCollection();
    }
/**
 * @param Produit $produit
 * @return $this
 */
public function addProduit(Produit $produit): self
{
    if ($this->produits === null) {
        $this->produits = new ArrayCollection();
    }

    if (!$this->produits->contains($produit)) {
        $this->produits[] = $produit;
    }

    return $this;
}
    /**
     * @param ArrayCollection $produits
     */
    public function setProduits(ArrayCollection $produits): void
    {
        $this->produits = $produits;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbrProds(): ?int
    {
        return $this->nbr_Prods;
    }

    public function setNbrProds(?int $nbr_Prods): static
    {
        $this->nbr_Prods = $nbr_Prods;

        return $this;
    }

    public function getTotalPrix(): ?float
    {
        return $this->total_prix;
    }
    public function setTotalPrix(?float $total_prix): static
    {
        $this->total_prix = $total_prix;
    
        return $this;
    }
    

    /**
     * @return Collection<int, Produit>
     */
    public function getIdprod(): Collection
    {
        return $this->idprod;
    }

    public function addIdprod(Produit $idprod): static
    {
        if (!$this->idprod->contains($idprod)) {
            $this->idprod->add($idprod);
            $idprod->setPanier($this);
        }

        return $this;
    }

    public function removeIdprod(Produit $idprod): static
    {
        if ($this->idprod->removeElement($idprod)) {
            // set the owning side to null (unless already changed)
            if ($idprod->getPanier() === $this) {
                $idprod->setPanier(null);
            }
        }

        return $this;
    }

    public function getLivraison(): ?Livraison
    {
        return $this->livraison;
    }

    public function setLivraison(?Livraison $livraison): static
    {
        $this->livraison = $livraison;

        return $this;
    }

    public function getProduitsId(): ?array
    {
        return $this->produits_id;
    }

    public function setProduitsId(?array $ProduitsId): static
    {
        $this->produits_id = $ProduitsId;

        return $this;
    }
    public function deleteProduitFromPanier(Produit $produit): void
    {
        if ($this->produits !== null && $this->produits->contains($produit)) {
            $this->produits->removeElement($produit);
        }
    }
}
