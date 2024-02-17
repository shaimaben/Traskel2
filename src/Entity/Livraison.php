<?php

namespace App\Entity;

use App\Repository\LivraisonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LivraisonRepository::class)]
class Livraison
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'livraisons')]
    private ?User $idMembre = null;

    #[ORM\OneToMany(targetEntity: Panier::class, mappedBy: 'livraison')]
    private Collection $idPanier;

    public function __construct()
    {
        $this->idPanier = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdMembre(): ?User
    {
        return $this->idMembre;
    }

    public function setIdMembre(?User $idMembre): static
    {
        $this->idMembre = $idMembre;

        return $this;
    }

    /**
     * @return Collection<int, Panier>
     */
    public function getIdPanier(): Collection
    {
        return $this->idPanier;
    }

    public function addIdPanier(Panier $idPanier): static
    {
        if (!$this->idPanier->contains($idPanier)) {
            $this->idPanier->add($idPanier);
            $idPanier->setLivraison($this);
        }

        return $this;
    }

    public function removeIdPanier(Panier $idPanier): static
    {
        if ($this->idPanier->removeElement($idPanier)) {
            // set the owning side to null (unless already changed)
            if ($idPanier->getLivraison() === $this) {
                $idPanier->setLivraison(null);
            }
        }

        return $this;
    }
}
