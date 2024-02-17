<?php

namespace App\Entity;

use App\Repository\CheckdonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CheckdonRepository::class)]
class Checkdon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $checkDon = null;

    #[ORM\OneToMany(targetEntity: Don::class, mappedBy: 'checkDon')]
    private Collection $dons;

    public function __construct()
    {
        $this->dons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isCheckDon(): ?bool
    {
        return $this->checkDon;
    }

    public function setCheckDon(bool $checkDon): static
    {
        $this->checkDon = $checkDon;

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
            $don->setCheckDon($this);
        }

        return $this;
    }

    public function removeDon(Don $don): static
    {
        if ($this->dons->removeElement($don)) {
            // set the owning side to null (unless already changed)
            if ($don->getCheckDon() === $this) {
                $don->setCheckDon(null);
            }
        }

        return $this;
    }
}
