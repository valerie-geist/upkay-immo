<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AgenceRepository")
 */
class Agence implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom_entreprise;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom_representant;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom_representant;

    /**
     * @ORM\Column(type="date")
     */
    private $date_naissance_representant;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nationalite_representant;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pays_residence_representant;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telephone;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Bien", mappedBy="agence")
     */
    private $biens;

    public function __construct()
    {
        $this->biens = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
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

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNomEntreprise(): ?string
    {
        return $this->nom_entreprise;
    }

    public function setNomEntreprise(string $nom_entreprise): self
    {
        $this->nom_entreprise = $nom_entreprise;

        return $this;
    }

    public function getNomRepresentant(): ?string
    {
        return $this->nom_representant;
    }

    public function setNomRepresentant(string $nom_representant): self
    {
        $this->nom_representant = $nom_representant;

        return $this;
    }

    public function getPrenomRepresentant(): ?string
    {
        return $this->prenom_representant;
    }

    public function setPrenomRepresentant(string $prenom_representant): self
    {
        $this->prenom_representant = $prenom_representant;

        return $this;
    }

    public function getDateNaissanceRepresentant(): ?\DateTimeInterface
    {
        return $this->date_naissance_representant;
    }

    public function setDateNaissanceRepresentant(\DateTimeInterface $date_naissance_representant): self
    {
        $this->date_naissance_representant = $date_naissance_representant;

        return $this;
    }

    public function getNationaliteRepresentant(): ?string
    {
        return $this->nationalite_representant;
    }

    public function setNationaliteRepresentant(string $nationalite_representant): self
    {
        $this->nationalite_representant = $nationalite_representant;

        return $this;
    }

    public function getPaysResidenceRepresentant(): ?string
    {
        return $this->pays_residence_representant;
    }

    public function setPaysResidenceRepresentant(string $pays_residence_representant): self
    {
        $this->pays_residence_representant = $pays_residence_representant;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * @return Collection|Bien[]
     */
    public function getBiens(): Collection
    {
        return $this->biens;
    }

    public function addBien(Bien $bien): self
    {
        if (!$this->biens->contains($bien)) {
            $this->biens[] = $bien;
            $bien->setAgence($this);
        }

        return $this;
    }

    public function removeBien(Bien $bien): self
    {
        if ($this->biens->contains($bien)) {
            $this->biens->removeElement($bien);
            // set the owning side to null (unless already changed)
            if ($bien->getAgence() === $this) {
                $bien->setAgence(null);
            }
        }

        return $this;
    }

}
