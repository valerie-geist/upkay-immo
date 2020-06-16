<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ChauffeEauRepository")
 */
class ChauffeEau
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $marque;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $capacite;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $modele;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $annee_installation;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Bien", mappedBy="chauffe_eau")
     */
    private $biens;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeChauffeEau", inversedBy="chauffeEaus")
     */
    private $type;

    public function __construct()
    {
        $this->biens = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    public function getCapacite(): ?int
    {
        return $this->capacite;
    }

    public function setCapacite(int $capacite): self
    {
        $this->capacite = $capacite;

        return $this;
    }

    public function getModele(): ?string
    {
        return $this->modele;
    }

    public function setModele(?string $modele): self
    {
        $this->modele = $modele;

        return $this;
    }

    public function getAnneeInstallation(): ?\DateTimeInterface
    {
        return $this->annee_installation;
    }

    public function setAnneeInstallation(\DateTimeInterface $annee_installation): self
    {
        $this->annee_installation = $annee_installation;

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
            $bien->setChauffeEau($this);
        }

        return $this;
    }

    public function removeBien(Bien $bien): self
    {
        if ($this->biens->contains($bien)) {
            $this->biens->removeElement($bien);
            // set the owning side to null (unless already changed)
            if ($bien->getChauffeEau() === $this) {
                $bien->setChauffeEau(null);
            }
        }

        return $this;
    }

    public function getType(): ?TypeChauffeEau
    {
        return $this->type;
    }

    public function setType(?TypeChauffeEau $type): self
    {
        $this->type = $type;

        return $this;
    }
}
