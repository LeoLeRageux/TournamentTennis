<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

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
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $prenom;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateNaissance;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=25, nullable=true)
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
     * @ORM\OneToMany(targetEntity="App\Entity\TennisSet", mappedBy="tennisUtilisateurGagnant")
     */
    private $tennisSetsGagnÃes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TennisSet", mappedBy="tennisUtilisateurPerdant")
     */
    private $tennisSetsPerdus;

    public function __construct()
    {
        $this->tennisTournoi = new ArrayCollection();
        $this->tennisMatchs = new ArrayCollection();
        $this->tennisSetsGagnÃes = new ArrayCollection();
        $this->tennisSetsPerdus = new ArrayCollection();
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
    public function getTennisSetsGagnÃes(): Collection
    {
        return $this->tennisSetsGagnÃes;
    }

    public function addTennisSetsGagnE(TennisSet $tennisSetsGagnE): self
    {
        if (!$this->tennisSetsGagnÃes->contains($tennisSetsGagnE)) {
            $this->tennisSetsGagnÃes[] = $tennisSetsGagnE;
            $tennisSetsGagnE->setTennisUtilisateurGagnant($this);
        }

        return $this;
    }

    public function removeTennisSetsGagnE(TennisSet $tennisSetsGagnE): self
    {
        if ($this->tennisSetsGagnÃes->contains($tennisSetsGagnE)) {
            $this->tennisSetsGagnÃes->removeElement($tennisSetsGagnE);
            // set the owning side to null (unless already changed)
            if ($tennisSetsGagnE->getTennisUtilisateurGagnant() === $this) {
                $tennisSetsGagnE->setTennisUtilisateurGagnant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|TennisSet[]
     */
    public function getTennisSetsPerdus(): Collection
    {
        return $this->tennisSetsPerdus;
    }

    public function addTennisSetsPerdus(TennisSet $tennisSetsPerdus): self
    {
        if (!$this->tennisSetsPerdus->contains($tennisSetsPerdus)) {
            $this->tennisSetsPerdus[] = $tennisSetsPerdus;
            $tennisSetsPerdus->setTennisUtilisateurPerdant($this);
        }

        return $this;
    }

    public function removeTennisSetsPerdus(TennisSet $tennisSetsPerdus): self
    {
        if ($this->tennisSetsPerdus->contains($tennisSetsPerdus)) {
            $this->tennisSetsPerdus->removeElement($tennisSetsPerdus);
            // set the owning side to null (unless already changed)
            if ($tennisSetsPerdus->getTennisUtilisateurPerdant() === $this) {
                $tennisSetsPerdus->setTennisUtilisateurPerdant(null);
            }
        }

        return $this;
    }
}
