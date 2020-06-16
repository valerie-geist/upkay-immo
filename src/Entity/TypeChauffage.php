<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TypeChauffageRepository")
 */
class TypeChauffage
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
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Chauffage", mappedBy="type")
     */
    private $chauffages;

    public function __construct()
    {
        $this->chauffages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection|Chauffage[]
     */
    public function getChauffages(): Collection
    {
        return $this->chauffages;
    }

    public function addChauffage(Chauffage $chauffage): self
    {
        if (!$this->chauffages->contains($chauffage)) {
            $this->chauffages[] = $chauffage;
            $chauffage->setType($this);
        }

        return $this;
    }

    public function removeChauffage(Chauffage $chauffage): self
    {
        if ($this->chauffages->contains($chauffage)) {
            $this->chauffages->removeElement($chauffage);
            // set the owning side to null (unless already changed)
            if ($chauffage->getType() === $this) {
                $chauffage->setType(null);
            }
        }

        return $this;
    }
}
