<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     */
    private $nbJeuxDuGagnant;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbJeuxDuPerdant;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TennisMatch", inversedBy="tennisSets")
     */
    private $tennisMatch;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbJeuxDuGagnant(): ?int
    {
        return $this->nbJeuxDuGagnant;
    }

    public function setNbJeuxDuGagnant(int $nbJeuxDuGagnant): self
    {
        $this->nbJeuxDuGagnant = $nbJeuxDuGagnant;

        return $this;
    }

    public function getNbJeuxDuPerdant(): ?int
    {
        return $this->nbJeuxDuPerdant;
    }

    public function setNbJeuxDuPerdant(int $nbJeuxDuPerdant): self
    {
        $this->nbJeuxDuPerdant = $nbJeuxDuPerdant;

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
}
