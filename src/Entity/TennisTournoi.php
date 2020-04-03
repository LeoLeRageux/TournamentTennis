<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TennisTournoiRepository")
 */
class TennisTournoi
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
     * @ORM\Column(type="date")
     */
    private $dateDebutTournoi;

    /**
     * @ORM\Column(type="date")
     */
    private $dateFinTournoi;

    /**
     * @ORM\Column(type="boolean")
     */
    private $estVisible;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $surface;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $categorieAge;

    /**
     * @ORM\Column(type="boolean")
     */
    private $genreHomme;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="date")
     */
    private $dateDebutInscriptions;

    /**
     * @ORM\Column(type="date")
     */
    private $dateFinInscriptions;

    /**
     * @ORM\Column(type="boolean")
     */
    private $inscriptionsManuelles;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbPlaces;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $motDePasse;

    /**
     * @ORM\Column(type="boolean")
     */
    private $validationInscriptions;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbSetsGagnants;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $statut;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TennisTour", mappedBy="tennisTournoi", cascade={"persist", "remove"})
     */
    private $tennisTours;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TennisUtilisateur", inversedBy="tennisTournoi")
     */
    private $tennisUtilisateur;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\TennisUtilisateur", mappedBy="tennisTournoisParticiper")
     */
    private $tennisUtilisateursParticipant;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\TennisUtilisateur", inversedBy="tennisTournoisDemandes")
     */
    private $tennisUtilisateursDemandeInscription;

    public function __construct()
    {
        $this->tennisTours = new ArrayCollection();
        $this->tennisUtilisateursParticipant = new ArrayCollection();
        $this->tennisUtilisateursDemandeInscription = new ArrayCollection();

        $this->dateDebutTournoi = new \DateTime('now');
        $this->dateFinTournoi = new \DateTime('now');
        $this->dateDebutInscriptions = new \DateTime('now');
        $this->dateFinInscriptions = new \DateTime('now');

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

    public function getDateDebutTournoi(): ?\DateTimeInterface
    {
        return $this->dateDebutTournoi;
    }

    public function setDateDebutTournoi(\DateTimeInterface $dateDebutTournoi): self
    {
        $this->dateDebutTournoi = $dateDebutTournoi;

        return $this;
    }

    public function getDateFinTournoi(): ?\DateTimeInterface
    {
        return $this->dateFinTournoi;
    }

    public function setDateFinTournoi(\DateTimeInterface $dateFinTournoi): self
    {
        $this->dateFinTournoi = $dateFinTournoi;

        return $this;
    }

    public function getEstVisible(): ?bool
    {
        return $this->estVisible;
    }

    public function setEstVisible(bool $estVisible): self
    {
        $this->estVisible = $estVisible;

        return $this;
    }

    public function getSurface(): ?string
    {
        return $this->surface;
    }

    public function setSurface(string $surface): self
    {
        $this->surface = $surface;

        return $this;
    }

    public function getCategorieAge(): ?string
    {
        return $this->categorieAge;
    }

    public function setCategorieAge(string $categorieAge): self
    {
        $this->categorieAge = $categorieAge;

        return $this;
    }

    public function getGenreHomme(): ?bool
    {
        return $this->genreHomme;
    }

    public function setGenreHomme(bool $genreHomme): self
    {
        $this->genreHomme = $genreHomme;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDateDebutInscriptions(): ?\DateTimeInterface
    {
        return $this->dateDebutInscriptions;
    }

    public function setDateDebutInscriptions(\DateTimeInterface $dateDebutInscriptions): self
    {
        $this->dateDebutInscriptions = $dateDebutInscriptions;

        return $this;
    }

    public function getDateFinInscriptions(): ?\DateTimeInterface
    {
        return $this->dateFinInscriptions;
    }

    public function setDateFinInscriptions(\DateTimeInterface $dateFinInscriptions): self
    {
        $this->dateFinInscriptions = $dateFinInscriptions;

        return $this;
    }

    public function getInscriptionsManuelles(): ?bool
    {
        return $this->inscriptionsManuelles;
    }

    public function setInscriptionsManuelles(bool $inscriptionsManuelles): self
    {
        $this->inscriptionsManuelles = $inscriptionsManuelles;

        return $this;
    }

    public function getNbPlaces(): ?int
    {
        return $this->nbPlaces;
    }

    public function setNbPlaces(int $nbPlaces): self
    {
        $this->nbPlaces = $nbPlaces;

        return $this;
    }

    public function getMotDePasse(): ?string
    {
        return $this->motDePasse;
    }

    public function setMotDePasse(?string $motDePasse): self
    {
        $this->motDePasse = $motDePasse;

        return $this;
    }

    public function getValidationInscriptions(): ?bool
    {
        return $this->validationInscriptions;
    }

    public function setValidationInscriptions(bool $validationInscriptions): self
    {
        $this->validationInscriptions = $validationInscriptions;

        return $this;
    }

    public function getNbSetsGagnants(): ?int
    {
        return $this->nbSetsGagnants;
    }

    public function setNbSetsGagnants(int $nbSetsGagnants): self
    {
        $this->nbSetsGagnants = $nbSetsGagnants;

        return $this;
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

    /**
     * @return Collection|TennisTour[]
     */
    public function getTennisTours(): Collection
    {
        return $this->tennisTours;
    }

    public function addTennisTour(TennisTour $tennisTour): self
    {
        if (!$this->tennisTours->contains($tennisTour)) {
            $this->tennisTours[] = $tennisTour;
            $tennisTour->setTennisTournoi($this);
        }

        return $this;
    }

    public function removeTennisTour(TennisTour $tennisTour): self
    {
        if ($this->tennisTours->contains($tennisTour)) {
            $this->tennisTours->removeElement($tennisTour);
            // set the owning side to null (unless already changed)
            if ($tennisTour->getTennisTournoi() === $this) {
                $tennisTour->setTennisTournoi(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getNom();
    }

    public function getTennisUtilisateur(): ?TennisUtilisateur
    {
        return $this->tennisUtilisateur;
    }

    public function setTennisUtilisateur(?TennisUtilisateur $tennisUtilisateur): self
    {
        $this->tennisUtilisateur = $tennisUtilisateur;

        return $this;
    }

    /**
     * @return Collection|TennisUtilisateur[]
     */
    public function getTennisUtilisateursParticipant(): Collection
    {
        return $this->tennisUtilisateursParticipant;
    }

    public function addTennisUtilisateursParticipant(TennisUtilisateur $tennisUtilisateursParticipant): self
    {
        if (!$this->tennisUtilisateursParticipant->contains($tennisUtilisateursParticipant)) {
            $this->tennisUtilisateursParticipant[] = $tennisUtilisateursParticipant;
            $tennisUtilisateursParticipant->addTennisTournoisParticiper($this);
        }

        return $this;
    }

    public function removeTennisUtilisateursParticipant(TennisUtilisateur $tennisUtilisateursParticipant): self
    {
        if ($this->tennisUtilisateursParticipant->contains($tennisUtilisateursParticipant)) {
            $this->tennisUtilisateursParticipant->removeElement($tennisUtilisateursParticipant);
            $tennisUtilisateursParticipant->removeTennisTournoisParticiper($this);
        }

        return $this;
    }

    /**
     * @return Collection|TennisUtilisateur[]
     */
    public function getTennisUtilisateursDemandeInscription(): Collection
    {
        return $this->tennisUtilisateursDemandeInscription;
    }

    public function addTennisUtilisateursDemandeInscription(TennisUtilisateur $tennisUtilisateursDemandeInscription): self
    {
        if (!$this->tennisUtilisateursDemandeInscription->contains($tennisUtilisateursDemandeInscription)) {
            $this->tennisUtilisateursDemandeInscription[] = $tennisUtilisateursDemandeInscription;
        }

        return $this;
    }

    public function removeTennisUtilisateursDemandeInscription(TennisUtilisateur $tennisUtilisateursDemandeInscription): self
    {
        if ($this->tennisUtilisateursDemandeInscription->contains($tennisUtilisateursDemandeInscription)) {
            $this->tennisUtilisateursDemandeInscription->removeElement($tennisUtilisateursDemandeInscription);
        }

        return $this;
    }

    /**
     * @return Collection|TennisUtilisateur[]
     */
    public function getTennisUtilisateursElimines(): Collection
    {
        return $this->tennisUtilisateursElimines;
    }

    public function addTennisUtilisateursElimine(TennisUtilisateur $tennisUtilisateursElimine): self
    {
        if (!$this->tennisUtilisateursElimines->contains($tennisUtilisateursElimine)) {
            $this->tennisUtilisateursElimines[] = $tennisUtilisateursElimine;
        }

        return $this;
    }

    public function removeTennisUtilisateursElimine(TennisUtilisateur $tennisUtilisateursElimine): self
    {
        if ($this->tennisUtilisateursElimines->contains($tennisUtilisateursElimine)) {
            $this->tennisUtilisateursElimines->removeElement($tennisUtilisateursElimine);
        }

        return $this;
    }

}
