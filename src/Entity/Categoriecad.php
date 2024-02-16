<?php

namespace App\Entity;

use App\Repository\CategoriecadRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoriecadRepository::class)]
class Categoriecad
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $categorie_Cad = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategorieCad(): ?string
    {
        return $this->categorie_Cad;
    }

    public function setCategorieCad(string $categorie_Cad): static
    {
        $this->categorie_Cad = $categorie_Cad;

        return $this;
    }
}
