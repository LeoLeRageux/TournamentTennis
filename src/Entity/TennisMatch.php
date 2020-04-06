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
     * @ORM\OneToMany(targetEntity="App\Entity\TennisSet", mappedBy="tennisMatch", cascade={"persist", "remove"})
     */
    private $tennisSets;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\TennisUtilisateur", mappedBy="tennisMatchs")
     */
    private $tennisUtilisateurs;

    public function __construct()
    {
        $this->tennisSets = new ArrayCollection();
        $this->tennisUtilisateurs = new ArrayCollection();
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

    public function notifierJoueurs(){
        $utilisateurs = $this->getTennisUtilisateurs();
        for($i = 0; $i < 2; $i++){
          $joueurAdverse = $utilisateurs[1-$i];
          $joueur = $utilisateurs[$i];
          $corpsMessage = "Boujour ".$joueur->getNomComplet()."\n
          Vous avez un match contre ".$joueurAdverse->getNomComplet()." !\n
          Vous avez jusqu'au ".$this->getTennisTour()->getDateFinTour()->format("d/m/Y")." pour jouer votre match et entrer les résultats.\n
          Pour le contacter :
          son email : ".$joueurAdverse->getEmail()."\n";
          $telephone = ($joueurAdverse->getTelephone() != null ? "          son téléphone : ".$joueurAdverse->getTelephone() : "");

          $corpsMessage = $corpsMessage.$telephone;

          $joueur->sendEmail("C'est l'heure de jouer !", $corpsMessage);
        }
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

    /**
     * @return Collection|TennisUtilisateur[]
     */
    public function getTennisUtilisateurs(): Collection
    {
        return $this->tennisUtilisateurs;
    }

    public function addTennisUtilisateur(TennisUtilisateur $tennisUtilisateur): self
    {
        if (!$this->tennisUtilisateurs->contains($tennisUtilisateur)) {
            $this->tennisUtilisateurs[] = $tennisUtilisateur;
            $tennisUtilisateur->addTennisMatch($this);
        }

        return $this;
    }

    public function removeTennisUtilisateur(TennisUtilisateur $tennisUtilisateur): self
    {
        if ($this->tennisUtilisateurs->contains($tennisUtilisateur)) {
            $this->tennisUtilisateurs->removeElement($tennisUtilisateur);
            $tennisUtilisateur->removeTennisMatch($this);
        }

        return $this;
    }

    public function getWinner(): TennisUtilisateur {
       if($this->getEtat() == "Terminé") {
          $participants = $this->getTennisUtilisateurs();
          $nb1 = 0; $nb2 = 0;
          foreach($this->getTennisSets() as $set){
            if($set->getTennisUtilisateurGagnant() == $participants[0]){
              $nb1++;
            } else {
              $nb2++;
            }
          }
          if($nb1 > $nb2){
            return $participants[0];
          } else {
            return $participants[1];
          }
       }
    }

    public function __toString(){

        return $this->getEtat();
    }
}
