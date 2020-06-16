<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CSLRepository")
 */
class CSL
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $entretien_chaudiere;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $entretien_chauffe_eau;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEntretienChaudiere(): ?\DateTimeInterface
    {
        return $this->entretien_chaudiere;
    }

    public function setEntretienChaudiere(?\DateTimeInterface $entretien_chaudiere): self
    {
        $this->entretien_chaudiere = $entretien_chaudiere;

        return $this;
    }

    public function getEntretienChauffeEau(): ?\DateTimeInterface
    {
        return $this->entretien_chauffe_eau;
    }

    public function setEntretienChauffeEau(?\DateTimeInterface $entretien_chauffe_eau): self
    {
        $this->entretien_chauffe_eau = $entretien_chauffe_eau;

        return $this;
    }
}
