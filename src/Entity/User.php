<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\Email(message:"Your email {{ value }}not valide")]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_user = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom_user = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse_user = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tel_user = null;

    #[ORM\Column(nullable: true)]
    private ?int $points_user = null;

    #[ORM\OneToMany(targetEntity: Produit::class, mappedBy: 'idUser')]
    private Collection $produits;

    #[ORM\OneToMany(targetEntity: Don::class, mappedBy: 'UserIdent')]
    private Collection $checkDon;

    #[ORM\OneToMany(targetEntity: Don::class, mappedBy: 'Userident')]
    private Collection $dons;

    #[ORM\OneToMany(targetEntity: Livraison::class, mappedBy: 'idMembre')]
    private Collection $livraisons;

    #[ORM\OneToMany(targetEntity: Cadeaux::class, mappedBy: 'idUser')]
    private Collection $cadeauxes;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    #[ORM\Column]
    private ?bool $isBanned = null;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
        $this->checkDon = new ArrayCollection();
        $this->dons = new ArrayCollection();
        $this->livraisons = new ArrayCollection();
        $this->cadeauxes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNomUser(): ?string
    {
        return $this->nom_user;
    }


    public function getUsername(): string
    {
        return (string) $this->email;
    }





    public function setNomUser(string $nom_user): static
    {
        $this->nom_user = $nom_user;

        return $this;
    }

    public function getPrenomUser(): ?string
    {
        return $this->prenom_user;
    }

    public function setPrenomUser(string $prenom_user): static
    {
        $this->prenom_user = $prenom_user;

        return $this;
    }

    public function getAdresseUser(): ?string
    {
        return $this->adresse_user;
    }

    public function setAdresseUser(?string $adresse_user): static
    {
        $this->adresse_user = $adresse_user;

        return $this;
    }

    public function getTelUser(): ?string
    {
        return $this->tel_user;
    }

    public function setTelUser(?string $tel_user): static
    {
        $this->tel_user = $tel_user;

        return $this;
    }

    public function getPointsUser(): ?int
    {
        return $this->points_user;
    }

    public function setPointsUser(?int $points_user): static
    {
        $this->points_user = $points_user;

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
            $produit->setIdUser($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): static
    {
        if ($this->produits->removeElement($produit)) {
            // set the owning side to null (unless already changed)
            if ($produit->getIdUser() === $this) {
                $produit->setIdUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Don>
     */
    public function getCheckDon(): Collection
    {
        return $this->checkDon;
    }

    public function addCheckDon(Don $checkDon): static
    {
        if (!$this->checkDon->contains($checkDon)) {
            $this->checkDon->add($checkDon);
            $checkDon->setUserIdent($this);
        }

        return $this;
    }

    public function removeCheckDon(Don $checkDon): static
    {
        if ($this->checkDon->removeElement($checkDon)) {
            // set the owning side to null (unless already changed)
            if ($checkDon->getUserIdent() === $this) {
                $checkDon->setUserIdent(null);
            }
        }

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
            $don->setUserident($this);
        }

        return $this;
    }

    public function removeDon(Don $don): static
    {
        if ($this->dons->removeElement($don)) {
            // set the owning side to null (unless already changed)
            if ($don->getUserident() === $this) {
                $don->setUserident(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Livraison>
     */
    public function getLivraisons(): Collection
    {
        return $this->livraisons;
    }

    public function addLivraison(Livraison $livraison): static
    {
        if (!$this->livraisons->contains($livraison)) {
            $this->livraisons->add($livraison);
            $livraison->setIdMembre($this);
        }

        return $this;
    }

    public function removeLivraison(Livraison $livraison): static
    {
        if ($this->livraisons->removeElement($livraison)) {
            // set the owning side to null (unless already changed)
            if ($livraison->getIdMembre() === $this) {
                $livraison->setIdMembre(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Cadeaux>
     */
    public function getCadeauxes(): Collection
    {
        return $this->cadeauxes;
    }

    public function addCadeaux(Cadeaux $cadeaux): static
    {
        if (!$this->cadeauxes->contains($cadeaux)) {
            $this->cadeauxes->add($cadeaux);
            $cadeaux->setIdUser($this);
        }

        return $this;
    }

    public function removeCadeaux(Cadeaux $cadeaux): static
    {
        if ($this->cadeauxes->removeElement($cadeaux)) {
            // set the owning side to null (unless already changed)
            if ($cadeaux->getIdUser() === $this) {
                $cadeaux->setIdUser(null);
            }
        }

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function isIsBanned(): ?bool
    {
        return $this->isBanned;
    }

    public function setIsBanned(bool $isBanned): static
    {
        $this->isBanned = $isBanned;

        return $this;
    }
}