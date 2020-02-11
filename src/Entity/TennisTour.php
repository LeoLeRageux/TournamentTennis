<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TennisTourRepository")
 */
class TennisTour
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $type;

    /**
     * @ORM\Column(type="date")
     */
    private $dateFinTour;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $statut;

    /**
     * @ORM\Column(type="integer")
     */
    private $numero;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TennisTournoi", inversedBy="tennisTours")
     */
    private $tennisTournoi;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TennisMatch", mappedBy="tennisTour", cascade={"persist", "remove"})
     */
    private $tennisMatchs;

    public function __construct()
    {
        $this->tennisMatchs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDateFinTour(): ?\DateTimeInterface
    {
        return $this->dateFinTour;
    }

    public function setDateFinTour(\DateTimeInterface $dateFinTour): self
    {
        $this->dateFinTour = $dateFinTour;

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

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getTennisTournoi(): ?TennisTournoi
    {
        return $this->tennisTournoi;
    }

    public function setTennisTournoi(?TennisTournoi $tennisTournoi): self
    {
        $this->tennisTournoi = $tennisTournoi;

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
            $tennisMatch->setTennisTour($this);
        }

        return $this;
    }

    public function removeTennisMatch(TennisMatch $tennisMatch): self
    {
        if ($this->tennisMatchs->contains($tennisMatch)) {
            $this->tennisMatchs->removeElement($tennisMatch);
            // set the owning side to null (unless already changed)
            if ($tennisMatch->getTennisTour() === $this) {
                $tennisMatch->setTennisTour(null);
            }
        }

        return $this;
    }
}
