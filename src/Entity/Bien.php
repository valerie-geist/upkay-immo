<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BienRepository")
 */
class Bien
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
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $etage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ascenceur;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Length(
     *      min=1, 
     *      minMessage = "La surface du logement doit être supérieure à {{ limit }} m²"
     *      )
     */
    private $surface;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Agence", inversedBy="biens", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $agence;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ville", inversedBy="biens", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $ville;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Locataire", cascade={"persist", "remove"})
     *
     * @Assert\Valid()
     */
    private $locataire;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeBien", inversedBy="biens", cascade={"persist"})
     */
    private $type_bien;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\CSL", cascade={"persist", "remove"})
     */
    private $csl;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Chauffage", inversedBy="biens", cascade={"persist"})
     *
     * @Assert\Valid()
     *
     */
    private $chauffage;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ChauffeEau", inversedBy="biens", cascade={"persist"})
     *
     * @Assert\Valid()
     *
     */
    private $chauffe_eau;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Prestation", mappedBy="bien")
     */
    private $prestations;

    /**
     * @ORM\Column(type="text", nullable=true)
     * 
     * @Assert\File(
     *     maxSize = "2000k",
     *     maxSizeMessage = "Le poids de la photo doit être de moins de 2M"
     * )
     * 
     */
    private $photo;


    public function __construct()
    {
        $this->prestations = new ArrayCollection();
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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getEtage(): ?int
    {
        return $this->etage;
    }

    public function setEtage(?int $etage): self
    {
        $this->etage = $etage;

        return $this;
    }

    public function getAscenceur(): ?string
    {
        return $this->ascenceur;
    }

    public function setAscenceur(?string $ascenceur): self
    {
        $this->ascenceur = $ascenceur;

        return $this;
    }

    public function getSurface(): ?int
    {
        return $this->surface;
    }

    public function setSurface(int $surface): self
    {
        $this->surface = $surface;

        return $this;
    }

    public function getAgence(): ?Agence
    {
        return $this->agence;
    }

    public function setAgence(?Agence $agence): self
    {
        $this->agence = $agence;

        return $this;
    }

    public function getVille(): ?Ville
    {
        return $this->ville;
    }

    public function setVille(?Ville $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getLocataire(): ?Locataire
    {
        return $this->locataire;
    }

    public function setLocataire(?Locataire $locataire): self
    {
        $this->locataire = $locataire;

        return $this;
    }

    public function getTypeBien(): ?TypeBien
    {
        return $this->type_bien;
    }

    public function setTypeBien(?TypeBien $type_bien): self
    {
        $this->type_bien = $type_bien;

        return $this;
    }

    public function getCsl(): ?CSL
    {
        return $this->csl;
    }

    public function setCsl(?CSL $csl): self
    {
        $this->csl = $csl;

        return $this;
    }

    public function getChauffage(): ?Chauffage
    {
        return $this->chauffage;
    }

    public function setChauffage(?Chauffage $chauffage): self
    {
        $this->chauffage = $chauffage;

        return $this;
    }

    public function getChauffeEau(): ?ChauffeEau
    {
        return $this->chauffe_eau;
    }

    public function setChauffeEau(?ChauffeEau $chauffe_eau): self
    {
        $this->chauffe_eau = $chauffe_eau;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }


    /**
     * @return Collection|Prestation[]
     */
    public function getPrestations(): Collection
    {
        return $this->prestations;
    }

    public function addPrestation(Prestation $prestation): self
    {
        if (!$this->prestations->contains($prestation)) {
            $this->prestations[] = $prestation;
            $prestation->setBien($this);
        }

        return $this;
    }

    public function removePrestation(Prestation $prestation): self
    {
        if ($this->prestations->contains($prestation)) {
            $this->prestations->removeElement($prestation);
            // set the owning side to null (unless already changed)
            if ($prestation->getBien() === $this) {
                $prestation->setBien(null);
            }
        }

        return $this;
    }

}
