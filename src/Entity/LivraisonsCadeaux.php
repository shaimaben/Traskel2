<?php

namespace App\Entity;

use App\Repository\LivraisonsCadeauxRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: LivraisonsCadeauxRepository::class)]
class LivraisonsCadeaux
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message:'membre est obligatoire!')]
    private ?User $membre = null;

    #[ORM\ManyToMany(targetEntity: Cadeaux::class)]
    #[Assert\NotBlank(message:'liste cadeaux est obligatoire!')]
    private Collection $listeCadeaux;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message:'livreur est obligatoire!')]
    private ?User $livreur = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?bool $isConfirmed = false;

    
    public function __construct()
    {
        $this->listeCadeaux = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMembre(): ?User
    {
        return $this->membre;
    }

    public function setMembre(?User $membre): static
    {
        $this->membre = $membre;

        return $this;
    }

    /**
     * @return Collection<int, Cadeaux>
     */
    public function getListeCadeaux(): Collection
    {
        return $this->listeCadeaux;
    }

    public function addListeCadeaux(Cadeaux $listeCadeaux): static
    {
        if (!$this->listeCadeaux->contains($listeCadeaux)) {
            $this->listeCadeaux->add($listeCadeaux);
        }

        return $this;
    }

    public function removeListeCadeaux(Cadeaux $listeCadeaux): static
    {
        $this->listeCadeaux->removeElement($listeCadeaux);

        return $this;
    }

    public function getLivreur(): ?User
    {
        return $this->livreur;
    }

    public function setLivreur(?User $livreur): static
    {
        $this->livreur = $livreur;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function isIsConfirmed(): ?bool
    {
        return $this->isConfirmed;
    }

    public function setIsConfirmed(bool $isConfirmed): static
    {
        $this->isConfirmed = $isConfirmed;

        return $this;
    }
}
