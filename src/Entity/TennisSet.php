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
    private $nbJeuxDuGagnant;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(
     *      min = 0,
     *      max = 7,
     *      minMessage = "Le nombre de jeux doit être plus grand que {{ limit }}",
     *      maxMessage = "Le nombre de jeux doit être plus petit que {{ limit }}"
     * )
     */
    private $nbJeuxDuPerdant;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TennisMatch", inversedBy="tennisSets")
     */
    private $tennisMatch;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TennisUtilisateur", inversedBy="tennisSetsGagn�es")
     */
    private $tennisUtilisateurGagnant;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TennisUtilisateur", inversedBy="tennisSetsPerdus")
     */
    private $tennisUtilisateurPerdant;

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

    public function getTennisUtilisateurGagnant(): ?TennisUtilisateur
    {
        return $this->tennisUtilisateurGagnant;
    }

    public function setTennisUtilisateurGagnant(?TennisUtilisateur $tennisUtilisateurGagnant): self
    {
        $this->tennisUtilisateurGagnant = $tennisUtilisateurGagnant;

        return $this;
    }

    public function getTennisUtilisateurPerdant(): ?TennisUtilisateur
    {
        return $this->tennisUtilisateurPerdant;
    }

    public function setTennisUtilisateurPerdant(?TennisUtilisateur $tennisUtilisateurPerdant): self
    {
        $this->tennisUtilisateurPerdant = $tennisUtilisateurPerdant;

        return $this;
    }
}
