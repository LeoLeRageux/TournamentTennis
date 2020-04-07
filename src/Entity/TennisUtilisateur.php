<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use \Swift_Mailer;


/**
 * @ORM\Entity(repositoryClass="App\Repository\TennisUtilisateurRepository")
 */
class TennisUtilisateur implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\Email(
     *     message = "L'adresse mail n'est pas valide"
     * )
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
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    private $prenom;

    /**
     * @ORM\Column(type="date", nullable=false)
     * @Assert\LessThan("today UTC")
     */
    private $dateNaissance;

    /**
     * @ORM\Column(type="string", length=15, nullable=false)
     *  @Assert\Length(min = 9, max = 10, minMessage = "Le numéro de téléphone est trop court", maxMessage = "Le numéro de téléphone est trop long")
     *  @Assert\Regex(pattern="/^(0[1-9])[- .]?([0-9]{2}[- .]?){4}$/", message="Le numéro de téléphone n'est pas valide")
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=25, nullable=false)
     * @Assert\Regex(pattern="/^40$|^30(\/[54321]{1})?$|^15(\/[54321]{1})?$|^[54321]\/6$|^0$/", message="Le classement est invalide")
     */
    private $niveau;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TennisTournoi", mappedBy="tennisUtilisateur")
     */
    private $tennisTournoi;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\TennisMatch", inversedBy="tennisUtilisateurs")
     */
    private $tennisMatchs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TennisSet", mappedBy="tennisjoueurUn")
     */
    private $tennisSetsJoueurUn;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TennisSet", mappedBy="tennisjoueurDeux")
     */
    private $tennisSetsJoueurDeux;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\tennisTournoi", inversedBy="tennisUtilisateursParticipant")
     */
    private $tennisTournoisParticiper;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $genreHomme;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\TennisTournoi", mappedBy="tennisUtilisateursDemandeInscription")
     */
    private $tennisTournoisDemandes;

    public function __construct()
    {
        $this->tennisTournoi = new ArrayCollection();
        $this->tennisMatchs = new ArrayCollection();
        $this->tennisSetsJoueurUn = new ArrayCollection();
        $this->tennisSetsJoueurDeux = new ArrayCollection();
        $this->tennisTournoisParticiper = new ArrayCollection();
        $this->tennisTournoisDemandes = new ArrayCollection();

        $this->dateNaissance = new \DateTime('now');
        $this->tennisTournoisElimines = new ArrayCollection();
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

    public function getNomComplet(): ?string {
        return $this->getPrenom() . " " . $this->getNom();
    }

    public function sendEmail($sujet, $corps){
        $transport = (new \Swift_SmtpTransport('smtp.gmail.com', 465))
            ->setHost('smtp.gmail.com')
            ->setPort('465')
            ->setEncryption('ssl')
            ->setAuthMode('login')
            ->setUsername($_ENV['MAILER_USER'])
            ->setPassword($_ENV['MAILER_PASSWORD']);
        $mailer = new \Swift_Mailer($transport);
        $message = (new \Swift_Message($sujet))
           ->setFrom('tournamenttenniswebapp@gmail.com')
           ->setTo($this->getEmail())
           ->setBody($corps);
        $mailer->send($message);
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

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(?\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

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

    public function getNiveau(): ?string
    {
        return $this->niveau;
    }

    public function setNiveau(?string $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }

    /**
     * @return Collection|TennisTournoi[]
     */
    public function getTennisTournoi(): Collection
    {
        return $this->tennisTournoi;
    }

    public function addTennisTournoi(TennisTournoi $tennisTournoi): self
    {
        if (!$this->tennisTournoi->contains($tennisTournoi)) {
            $this->tennisTournoi[] = $tennisTournoi;
            $tennisTournoi->setTennisUtilisateur($this);
        }

        return $this;
    }

    public function removeTennisTournoi(TennisTournoi $tennisTournoi): self
    {
        if ($this->tennisTournoi->contains($tennisTournoi)) {
            $this->tennisTournoi->removeElement($tennisTournoi);
            // set the owning side to null (unless already changed)
            if ($tennisTournoi->getTennisUtilisateur() === $this) {
                $tennisTournoi->setTennisUtilisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|TennisMatch[]
     */
    public function getTennisMatchs(): Collection
    {
        return $this->tennisMatchs;
    }

    public function addTennisMatch(TennisMatch $tennisMatch): self
    {
        if (!$this->tennisMatchs->contains($tennisMatch)) {
            $this->tennisMatchs[] = $tennisMatch;
        }

        return $this;
    }

    public function removeTennisMatch(TennisMatch $tennisMatch): self
    {
        if ($this->tennisMatchs->contains($tennisMatch)) {
            $this->tennisMatchs->removeElement($tennisMatch);
        }

        return $this;
    }

    /**
     * @return Collection|TennisSet[]
     */
    public function getTennisSetsJoueurUn(): Collection
    {
        return $this->tennisSetsJoueurUn;
    }

    public function addTennisSetsJoueurUn(TennisSet $tennisSetsJoueurUn): self
    {
        if (!$this->tennisSetsJoueurUn->contains($tennisSetsJoueurUn)) {
            $this->tennisSetsJoueurUn[] = $tennisSetsJoueurUn;
            $tennisSetsJoueurUn->setTennisjoueurUn($this);
        }

        return $this;
    }

    public function removeTennisSetsJoueurUn(TennisSet $tennisSetsJoueurUn): self
    {
        if ($this->tennisSetsJoueurUn->contains($tennisSetsJoueurUn)) {
            $this->tennisSetsJoueurUn->removeElement($tennisSetsJoueurUn);
            // set the owning side to null (unless already changed)
            if ($tennisSetsJoueurUn->getTennisjoueurUn() === $this) {
                $tennisSetsJoueurUn->setTennisjoueurUn(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|TennisSet[]
     */
    public function getTennisSetsJoueurDeux(): Collection
    {
        return $this->tennisSetsJoueurDeux;
    }

    public function addTennisSetsJoueurDeux(TennisSet $tennisSetsJoueurDeux): self
    {
        if (!$this->tennisSetsJoueurDeux->contains($tennisSetsJoueurDeux)) {
            $this->tennisSetsJoueurDeux[] = $tennisSetsJoueurDeux;
            $tennisSetsJoueurDeux->setTennisjoueurDeux($this);
        }

        return $this;
    }

    public function removeTennisSetsJoueurDeux(TennisSet $tennisSetsJoueurDeux): self
    {
        if ($this->tennisSetsJoueurDeux->contains($tennisSetsJoueurDeux)) {
            $this->tennisSetsJoueurDeux->removeElement($tennisSetsJoueurDeux);
            // set the owning side to null (unless already changed)
            if ($tennisSetsJoueurDeux->getTennisjoueurDeux() === $this) {
                $tennisSetsJoueurDeux->setTennisjoueurDeux(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|tennisTournoi[]
     */
    public function getTennisTournoisParticiper(): Collection
    {
        return $this->tennisTournoisParticiper;
    }

    public function addTennisTournoisParticiper(tennisTournoi $tennisTournoisParticiper): self
    {
        if (!$this->tennisTournoisParticiper->contains($tennisTournoisParticiper)) {
            $this->tennisTournoisParticiper[] = $tennisTournoisParticiper;
        }

        return $this;
    }

    public function removeTennisTournoisParticiper(tennisTournoi $tennisTournoisParticiper): self
    {
        if ($this->tennisTournoisParticiper->contains($tennisTournoisParticiper)) {
            $this->tennisTournoisParticiper->removeElement($tennisTournoisParticiper);
        }

        return $this;
    }


    public function getGenreHomme(): ?bool
    {
        return $this->genreHomme;
    }

    public function setGenreHomme(?bool $genreHomme): self
    {
        $this->genreHomme = $genreHomme;

        return $this;
    }

    /**
     * @return Collection|TennisTournoi[]
     */
    public function getTennisTournoisDemandes(): Collection
    {
        return $this->tennisTournoisDemandes;
    }

    public function addTennisTournoisDemande(TennisTournoi $tennisTournoisDemande): self
    {
        if (!$this->tennisTournoisDemandes->contains($tennisTournoisDemande)) {
            $this->tennisTournoisDemandes[] = $tennisTournoisDemande;
            $tennisTournoisDemande->addTennisUtilisateursDemandeInscription($this);
        }

        return $this;
    }

    public function removeTennisTournoisDemande(TennisTournoi $tennisTournoisDemande): self
    {
        if ($this->tennisTournoisDemandes->contains($tennisTournoisDemande)) {
            $this->tennisTournoisDemandes->removeElement($tennisTournoisDemande);
            $tennisTournoisDemande->removeTennisUtilisateursDemandeInscription($this);
        }

        return $this;
    }

    public function __toString()
    {

        $message = $this->getNom() . " " . $this->getPrenom();
        return $message;

    }

}
