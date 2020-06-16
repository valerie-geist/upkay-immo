<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PrestationRepository")
 */
class Prestation
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
    private $statut;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categorie", inversedBy="prestation")
     * @Assert\NotBlank()
     */
    private $categorie;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $validation_artisan;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $artisan;

    /**
     * @ORM\Column(type="integer")
     */
    private $tarif;

    /**
     * @ORM\Column(type="date")
     */
    private $date_demande;

    /**
     * @ORM\Column(type="date")
     */
    private $date_intervention;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_cloture;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_validation;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_paiement;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Bien", inversedBy="prestations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $bien;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CommentaireLocataire", mappedBy="prestation")
     */
    private $commentaire_locataire;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CommentaireAgence", mappedBy="prestation")
     */
    private $commentaire_agence;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CommentaireArtisan", mappedBy="prestation")
     */
    private $commentaire_artisan;

    public function __construct()
    {
        $this->commentaire_locataire = new ArrayCollection();
        $this->commentaire_agence = new ArrayCollection();
        $this->commentaire_artisan = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getValidationArtisan(): ?string
    {
        return $this->validation_artisan;
    }

    public function setValidationArtisan(string $validation_artisan): self
    {
        $this->validation_artisan = $validation_artisan;

        return $this;
    }

    public function getArtisan(): ?string
    {
        return $this->artisan;
    }

    public function setArtisan(string $artisan): self
    {
        $this->artisan = $artisan;

        return $this;
    }

    public function getTarif(): ?int
    {
        return $this->tarif;
    }

    public function setTarif(int $tarif): self
    {
        $this->tarif = $tarif;

        return $this;
    }

    public function getDateDemande(): ?\DateTimeInterface
    {
        return $this->date_demande;
    }

    public function setDateDemande(\DateTimeInterface $date_demande): self
    {
        $this->date_demande = $date_demande;

        return $this;
    }

    public function getDateIntervention(): ?\DateTimeInterface
    {
        return $this->date_intervention;
    }

    public function setDateIntervention(\DateTimeInterface $date_intervention): self
    {
        $this->date_intervention = $date_intervention;

        return $this;
    }

    public function getDateCloture(): ?\DateTimeInterface
    {
        return $this->date_cloture;
    }

    public function setDateCloture(\DateTimeInterface $date_cloture): self
    {
        $this->date_cloture = $date_cloture;

        return $this;
    }

    public function getDateValidation(): ?\DateTimeInterface
    {
        return $this->date_validation;
    }

    public function setDateValidation(?\DateTimeInterface $date_validation): self
    {
        $this->date_validation = $date_validation;

        return $this;
    }

    public function getDatePaiement(): ?\DateTimeInterface
    {
        return $this->date_paiement;
    }

    public function setDatePaiement(?\DateTimeInterface $date_paiement): self
    {
        $this->date_paiement = $date_paiement;

        return $this;
    }

    public function getBien(): ?Bien
    {
        return $this->bien;
    }

    public function setBien(?Bien $bien): self
    {
        $this->bien = $bien;

        return $this;
    }

    /**
     * @return Collection|CommentaireLocataire[]
     */
    public function getCommentaireLocataire(): Collection
    {
        return $this->commentaire_locataire;
    }

    public function addCommentaireLocataire(CommentaireLocataire $commentaireLocataire): self
    {
        if (!$this->commentaire_locataire->contains($commentaireLocataire)) {
            $this->commentaire_locataire[] = $commentaireLocataire;
            $commentaireLocataire->setPrestation($this);
        }

        return $this;
    }

    public function removeCommentaireLocataire(CommentaireLocataire $commentaireLocataire): self
    {
        if ($this->commentaire_locataire->contains($commentaireLocataire)) {
            $this->commentaire_locataire->removeElement($commentaireLocataire);
            // set the owning side to null (unless already changed)
            if ($commentaireLocataire->getPrestation() === $this) {
                $commentaireLocataire->setPrestation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CommentaireAgence[]
     */
    public function getCommentaireAgence(): Collection
    {
        return $this->commentaire_agence;
    }

    public function addCommentaireAgence(CommentaireAgence $commentaireAgence): self
    {
        if (!$this->commentaire_agence->contains($commentaireAgence)) {
            $this->commentaire_agence[] = $commentaireAgence;
            $commentaireAgence->setPrestation($this);
        }

        return $this;
    }

    public function removeCommentaireAgence(CommentaireAgence $commentaireAgence): self
    {
        if ($this->commentaire_agence->contains($commentaireAgence)) {
            $this->commentaire_agence->removeElement($commentaireAgence);
            // set the owning side to null (unless already changed)
            if ($commentaireAgence->getPrestation() === $this) {
                $commentaireAgence->setPrestation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CommentaireArtisan[]
     */
    public function getCommentaireArtisan(): Collection
    {
        return $this->commentaire_artisan;
    }

    public function addCommentaireArtisan(CommentaireArtisan $commentaireArtisan): self
    {
        if (!$this->commentaire_artisan->contains($commentaireArtisan)) {
            $this->commentaire_artisan[] = $commentaireArtisan;
            $commentaireArtisan->setPrestation($this);
        }

        return $this;
    }

    public function removeCommentaireArtisan(CommentaireArtisan $commentaireArtisan): self
    {
        if ($this->commentaire_artisan->contains($commentaireArtisan)) {
            $this->commentaire_artisan->removeElement($commentaireArtisan);
            // set the owning side to null (unless already changed)
            if ($commentaireArtisan->getPrestation() === $this) {
                $commentaireArtisan->setPrestation(null);
            }
        }

        return $this;
    }
}
