<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TennisMatchRepository")
 */
class TennisMatch
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
    private $etat;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TennisTour", inversedBy="tennisMatchs")
     */
    private $tennisTour;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TennisSet", mappedBy="tennisMatch")
     */
    private $tennisSets;

    public function __construct()
    {
        $this->tennisSets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getTennisTour(): ?TennisTour
    {
        return $this->tennisTour;
    }

    public function setTennisTour(?TennisTour $tennisTour): self
    {
        $this->tennisTour = $tennisTour;

        return $this;
    }

    /**
     * @return Collection|TennisSet[]
     */
    public function getTennisSets(): Collection
    {
        return $this->tennisSets;
    }

    public function addTennisSet(TennisSet $tennisSet): self
    {
        if (!$this->tennisSets->contains($tennisSet)) {
            $this->tennisSets[] = $tennisSet;
            $tennisSet->setTennisMatch($this);
        }

        return $this;
    }

    public function removeTennisSet(TennisSet $tennisSet): self
    {
        if ($this->tennisSets->contains($tennisSet)) {
            $this->tennisSets->removeElement($tennisSet);
            // set the owning side to null (unless already changed)
            if ($tennisSet->getTennisMatch() === $this) {
                $tennisSet->setTennisMatch(null);
            }
        }

        return $this;
    }
}
