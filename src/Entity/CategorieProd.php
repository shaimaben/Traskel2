<?php

namespace App\Entity;

use App\Repository\CategorieProdRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieProdRepository::class)]
class CategorieProd
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $categorie_prod = null;

    #[ORM\OneToMany(targetEntity: Produit::class, mappedBy: 'idCat')]
    private Collection $produits;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategorieProd(): ?string
    {
        return $this->categorie_prod;
    }

    public function setCategorieProd(string $categorie_prod): static
    {
        $this->categorie_prod = $categorie_prod;

        return $this;
    }

    /**
     * @return Collection<int, Produit>
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Produit $produit): static
    {
        if (!$this->produits->contains($produit)) {
            $this->produits->add($produit);
            $produit->setIdCat($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): static
    {
        if ($this->produits->removeElement($produit)) {
            // set the owning side to null (unless already changed)
            if ($produit->getIdCat() === $this) {
                $produit->setIdCat(null);
            }
        }

        return $this;
    }
}
