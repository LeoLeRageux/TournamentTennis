<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TennisSetRepository")
 */
class TennisSet
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(
     *      min = 0,
     *      max = 7,
     *      minMessage = "Le nombre de jeux doit être plus grand que {{ limit }}",
     *      maxMessage = "Le nombre de jeux doit être plus petit que {{ limit }}"
     * )
     */
    private $nbJeuxDuJoueurUn;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(
     *      min = 0,
     *      max = 7,
     *      minMessage = "Le nombre de jeux doit être plus grand que {{ limit }}",
     *      maxMessage = "Le nombre de jeux doit être plus petit que {{ limit }}"
     * )
     */
    private $nbJeuxDuJoueurDeux;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TennisMatch", inversedBy="tennisSets")
     */
    private $tennisMatch;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TennisUtilisateur", inversedBy="tennisSetsJoueurUn")
     */
    private $tennisJoueurUn;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TennisUtilisateur", inversedBy="tennisSetsJoueurDeux")
     */
    private $tennisJoueurDeux;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbJeuxDuJoueurUn(): ?int
    {
        return $this->nbJeuxDuJoueurUn;
    }

    public function setNbJeuxDuJoueurUn(int $nbJeuxDuJoueurUn): self
    {
        $this->nbJeuxDuJoueurUn = $nbJeuxDuJoueurUn;

        return $this;
    }

    public function getNbJeuxDuJoueurDeux(): ?int
    {
        return $this->nbJeuxDuJoueurDeux;
    }

    public function setNbJeuxDuJoueurDeux(int $nbJeuxDuJoueurDeux): self
    {
        $this->nbJeuxDuJoueurDeux = $nbJeuxDuJoueurDeux;

        return $this;
    }

    public function getTennisMatch(): ?TennisMatch
    {
        return $this->tennisMatch;
    }

    public function setTennisMatch(?TennisMatch $tennisMatch): self
    {
        $this->tennisMatch = $tennisMatch;

        return $this;
    }

    public function getTennisJoueurUn(): ?TennisUtilisateur
    {
        return $this->tennisJoueurUn;
    }

    public function setTennisJoueurUn(?TennisUtilisateur $tennisJoueurUn): self
    {
        $this->tennisJoueurUn = $tennisJoueurUn;

        return $this;
    }

    public function getTennisJoueurDeux(): ?TennisUtilisateur
    {
        return $this->tennisJoueurDeux;
    }

    public function setTennisJoueurDeux(?TennisUtilisateur $tennisJoueurDeux): self
    {
        $this->tennisJoueurDeux = $tennisJoueurDeux;
        return $this;
    }
}
