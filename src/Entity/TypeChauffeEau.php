<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TypeChauffeEauRepository")
 */
class TypeChauffeEau
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
     * @ORM\OneToMany(targetEntity="App\Entity\ChauffeEau", mappedBy="type")
     */
    private $chauffeEaus;

    public function __construct()
    {
        $this->chauffeEaus = new ArrayCollection();
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
     * @return Collection|ChauffeEau[]
     */
    public function getChauffeEaus(): Collection
    {
        return $this->chauffeEaus;
    }

    public function addChauffeEau(ChauffeEau $chauffeEau): self
    {
        if (!$this->chauffeEaus->contains($chauffeEau)) {
            $this->chauffeEaus[] = $chauffeEau;
            $chauffeEau->setType($this);
        }

        return $this;
    }

    public function removeChauffeEau(ChauffeEau $chauffeEau): self
    {
        if ($this->chauffeEaus->contains($chauffeEau)) {
            $this->chauffeEaus->removeElement($chauffeEau);
            // set the owning side to null (unless already changed)
            if ($chauffeEau->getType() === $this) {
                $chauffeEau->setType(null);
            }
        }

        return $this;
    }
}
