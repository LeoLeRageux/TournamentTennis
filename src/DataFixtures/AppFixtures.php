<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\TennisMatch;
use App\Entity\TennisSet;
use App\Entity\TennisTour;
use App\Entity\TennisTournoi;
use App\Entity\TennisUtilisateur;
use \Datetime;
class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR'); // create a French faker

        // On crée un Tournoi
    		$tableauStatutTournoi = array("Non Commencé", "Phase d'inscriptions", "Commencé", "Terminé");
    		$listeSurfaces = array("Dur", "Gazon", "Terre Battue", "Indoor");

    		$leo = new TennisUtilisateur();
    		$leo->setEmail("leo@lecourt.com");
    		$leo->setRoles(["ROLE_USER"]);
    		$leo->setPassword('$2y$10$Ng0spKpKFXu8shdHYjbLXuQOmSLHOnVCFpDHHKDpKY6Er1UZ7hASm');
    		$leo->setNom("Lecourt");
    		$leo->setPrenom("Leo");
    		$leo->setDateNaissance(new DateTime('12/07/1998'));
    		$leo->setTelephone("0685754899");
    		$leo->setNiveau("30/1");
        $leo->setGenreHomme(true);
    		$manager->persist($leo);

    		$thomas = new TennisUtilisateur();
    		$thomas->setEmail("thomas@bouchet.com");
    		$thomas->setRoles(["ROLE_ADMIN"]);
    		$thomas->setPassword('$2y$10$rc.L3oyLR26e4P/9GjPvo.rf5znoCs9JMLcftI0035ijKgVBEN8iS');
    		$thomas->setPrenom("Thomas");
    		$thomas->setNom("Bouchet");
        $thomas->setDateNaissance(new DateTime('12/07/1998'));
    		$thomas->setTelephone("0658421541");
    		$thomas->setNiveau("30/1");
        $thomas->setGenreHomme(true);
    		$manager->persist($thomas);

    		$hugo = new TennisUtilisateur();
    		$hugo->setEmail("hugo@labastie.com");
    		$hugo->setRoles(["ROLE_USER"]);
    		$hugo->setPassword('$2y$10$hpqU2WqUmKDAj706S3zumu35PfcHo50ifDSUDDPsGIwys63rPelHC');
    		$hugo->setPrenom("Hugo");
    		$hugo->setNom("Labastie");
        $hugo->setDateNaissance(new DateTime('12/07/1998'));
    		$hugo->setTelephone("0657002148");
    		$hugo->setNiveau("30/1");
        $hugo->setGenreHomme(true);
    		$manager->persist($hugo);

    		$matthieu = new TennisUtilisateur();
    		$matthieu->setEmail("matthieu@manke.com");
    		$matthieu->setRoles(["ROLE_USER"]);
    		$matthieu->setPassword('$2y$10$BANAkiaHJSDAqV7tqyyJMOXtzIXX2YLdyM0751ZcQQgISGkCN20ru');
    		$matthieu->setNom("Manke");
    		$matthieu->setPrenom("Matthieu");
        $matthieu->setDateNaissance(new DateTime('05/31/1999'));
    		$matthieu->setTelephone("0610024120");
    		$matthieu->setNiveau("30/1");
        $matthieu->setGenreHomme(true);
    		$manager->persist($matthieu);

        $utilisateurs = [$leo, $thomas, $hugo, $matthieu];

        $luc = new TennisUtilisateur();
    		$luc->setEmail("luc.dupont@gmail.com");
    		$luc->setRoles(["ROLE_USER"]);
    		$luc->setPassword('$2y$10$cS5zsnLxiy76YtHU.nUIzO8Jt24StkwHxU6.r1jKenUczDtSoA0YS');
        $luc->setPrenom("Luc");
        $luc->setNom("Dupont");
        $luc->setDateNaissance(new DateTime('02/08/2009'));
    		$luc->setTelephone("0610024120");
    		$luc->setNiveau("30/1");
        $luc->setGenreHomme(true);
    		$manager->persist($luc);

        $bastien = new TennisUtilisateur();
    		$bastien->setEmail("bastien.delaville@gmail.com");
    		$bastien->setRoles(["ROLE_USER"]);
    		$bastien->setPassword('$2y$10$febeRapB25laBcik6XAs/eXe5qeDiRiie.H3FBce1VDjzQGFd2rSy');
        $bastien->setPrenom("Bastien");
        $bastien->setNom("Delaville");
        $bastien->setDateNaissance(new DateTime('02/05/2010'));
    		$bastien->setTelephone("0710245841");
    		$bastien->setNiveau("30/1");
        $bastien->setGenreHomme(true);
    		$manager->persist($bastien);

        $killian = new TennisUtilisateur();
    		$killian->setEmail("killian.mouche@gmail.com");
    		$killian->setRoles(["ROLE_USER"]);
    		$killian->setPassword('$2y$10$Jmt0Pzu0o.MaDIbGbSAAH.HMKUASbM5tPsVAMnOh6i4a.fzCfpzR2');
        $killian->setPrenom("Killian");
        $killian->setNom("Mouche");
        $killian->setDateNaissance(new DateTime('09/01/2010'));
    		$killian->setTelephone("0692147582");
    		$killian->setNiveau("30/1");
        $killian->setGenreHomme(true);
    		$manager->persist($killian);

        $gabriel = new TennisUtilisateur();
    		$gabriel->setEmail("gabriel.durand@gmail.com");
    		$gabriel->setRoles(["ROLE_USER"]);
    		$gabriel->setPassword('$2y$10$zK6RI4Ha8yvbT2ZCFXe2eOcujZlVwWLMXU.Y61oXQ.QmcDAoKRn9y');
        $gabriel->setPrenom("Gabriel");
        $gabriel->setNom("Durand");
        $gabriel->setDateNaissance(new DateTime('03/08/2009'));
    		$gabriel->setTelephone("0610024120");
    		$gabriel->setNiveau("30/1");
        $gabriel->setGenreHomme(true);
    		$manager->persist($gabriel);

        $enfants = [$luc, $gabriel, $killian, $bastien];

        $tournoi = new TennisTournoi();
        $tournoi->setTennisUtilisateur($matthieu);
        $tournoi->setNom("Tournoi test 11/12");
        $tournoi->setAdresse($faker->realText($maxNbChars = 10, $indexSize = 2));
        $tournoi->setEstVisible(true);
        $tournoi->setSurface($faker->randomElement($listeSurfaces));
        $tournoi->setCategorieAge("11/12");
        $tournoi->setGenreHomme(true);
        $tournoi->setInscriptionsManuelles(false);
        $tournoi->setNbPlaces(10);
        $tournoi->setValidationInscriptions(false);
        $tournoi->setNbSetsGagnants(2);
        $tournoi->setStatut("Non Commencé");
        $tournoi->setDateDebutInscriptions(new DateTime("04/04/2020"));
        $tournoi->setDateFinInscriptions(new DateTime("05/04/2020"));
        $tournoi->setDateDebuttournoi(new DateTime("05/04/2020"));
        $tournoi->setDateFintournoi(new DateTime("06/04/2020"));
        $manager->persist($tournoi);

        $yon = new TennisUtilisateur();
    		$yon->setEmail("yon.dourisboure@gmail.com");
    		$yon->setRoles(["ROLE_USER"]);
    		$yon->setPassword('$2y$10$rKaFqZlhQN/nKo0kXMQgmeQ8sLXKnx7By/hEe.vvrX3.uMGPRx2Xi');
        $yon->setPrenom("Yon");
        $yon->setNom("Dourisboure");
        $yon->setDateNaissance(new DateTime('05/07/1980'));
    		$yon->setTelephone("0559574336");
    		$yon->setNiveau("30/1");
        $yon->setGenreHomme(true);
    		$manager->persist($yon);

        $chakib = new TennisUtilisateur();
    		$chakib->setEmail("chakib.alami@gmail.com");
    		$chakib->setRoles(["ROLE_USER"]);
    		$chakib->setPassword('$2y$10$6lK0dMvqC5Qs4.FD3PVKiOM./9JQd9/6f2VvrOOoDvhDYN.gEWq96');
        $chakib->setPrenom("Chakib");
        $chakib->setNom("Alami");
        $chakib->setDateNaissance(new DateTime('12/09/1985'));
    		$chakib->setTelephone("0559574336");
    		$chakib->setNiveau("18/1");
        $chakib->setGenreHomme(true);
    		$manager->persist($chakib);

        $patrick = new TennisUtilisateur();
    		$patrick->setEmail("patrick.etchevery@gmail.com");
    		$patrick->setRoles(["ROLE_USER"]);
    		$patrick->setPassword('$2y$10$hsJQODjP.tda9PTihM.M1.temKmF/J48fSkzfmNTyulbAvCnJeHSO');
        $patrick->setPrenom("Patrick");
        $patrick->setNom("Etchevery");
        $patrick->setDateNaissance(new DateTime('08/21/1980'));
    		$patrick->setTelephone("0559574336");
    		$patrick->setNiveau("18/1");
        $patrick->setGenreHomme(true);
    		$manager->persist($patrick);

        $pantxika = new TennisUtilisateur();
    		$pantxika->setEmail("pantxika.dagorret@gmail.com");
    		$pantxika->setRoles(["ROLE_USER"]);
    		$pantxika->setPassword('$2y$10$ductc7pczUxkkUTq1SSo2Otrk9W9ssll1FsDH2NscjGaxteNqd2yG');
        $pantxika->setPrenom("Pantxika");
        $pantxika->setNom("Dagorret");
        $pantxika->setDateNaissance(new DateTime('08/21/1980'));
    		$pantxika->setTelephone("0559574336");
    		$pantxika->setNiveau("18/1");
        $pantxika->setGenreHomme(false);
    		$manager->persist($pantxika);

        $roose = new TennisUtilisateur();
    		$roose->setEmail("philippe.roose@gmail.com");
    		$roose->setRoles(["ROLE_USER"]);
    		$roose->setPassword('$2y$10$FWw7QIcJoYkf7G1rXeLLGOfcU03adMmWWoEJ1tqAkRxyEqc6Bz/Tu');
        $roose->setPrenom("Philippe");
        $roose->setNom("Roose");
        $roose->setDateNaissance(new DateTime('08/21/1980'));
    		$roose->setTelephone("0559574336");
    		$roose->setNiveau("18/1");
        $roose->setGenreHomme(true);
    		$manager->persist($roose);

        $yann = new TennisUtilisateur();
    		$yann->setEmail("yann.carpentier@gmail.com");
    		$yann->setRoles(["ROLE_USER"]);
    		$yann->setPassword('$2y$10$sZWYwAV.mpvqPyFEpEEr.uRi3SvyY3XvT9U3yL.OhzPB8yc9LBrIW');
        $yann->setPrenom("Yann");
        $yann->setNom("Carpentier");
        $yann->setDateNaissance(new DateTime('08/21/1980'));
    		$yann->setTelephone("0559574336");
    		$yann->setNiveau("18/1");
        $yann->setGenreHomme(true);
    		$manager->persist($yann);

        $profs = [$chakib, $yon, $patrick, $yann, $roose];
        $joueurs = array_merge($utilisateurs, $profs);

        $villes = ["Mont de Marsan", "Bayonne", "Anglet", "Pau", "Biarritz", "Bidart", "St Jean de luz", "Orthez", "Perpignan", "Toulouse", "Marseille"];
        $saison = ["Printemps", "Eté", "Automne", "Hiver"];
        $categoriesDage = ["11/12", "13/14", "15/16", "17/18", "35", "40", "45", "50", "55", "60", "65", "70", "75", "seniors"];

        for($t=1; $t<=12; $t++){
            $tournoi = new TennisTournoi();
            $tournoi->setTennisUtilisateur($faker->randomElement($utilisateurs));
            $temp_joueurs = array_diff($joueurs, [$tournoi->getTennisUtilisateur()]);
            $tournoi->setNom("Tournoi ".$faker->randomElement($villes)." ".$faker->randomElement($saison)." 2020");
            $tournoi->setAdresse($faker->address);
            $tournoi->setEstVisible($faker->boolean($chanceOfGettingTrue = 50));
            $tournoi->setSurface($faker->randomElement($listeSurfaces));
            $tournoi->setGenreHomme($faker->boolean($chanceOfGettingTrue = 50));
            $tournoi->setDescription($faker->realText($maxNbChars = 50, $indexSize = 2));
            $tournoi->setInscriptionsManuelles($faker->boolean($chanceOfGettingTrue = 50));
            $tournoi->setNbPlaces($faker->numberBetween(10,20));
            $tournoi->setMotDePasse($faker->realText($maxNbChars = 10, $indexSize = 2));
            $tournoi->setValidationInscriptions($faker->boolean($chanceOfGettingTrue = 50));
    		    $nbSetsGagnants=$faker->numberBetween(2,3);
            $tournoi->setNbSetsGagnants($nbSetsGagnants);
            $tournoi->setStatut($tableauStatutTournoi[($t-1)%4]);
            $tournoi->setCategorieAge($faker->randomElement($categoriesDage));
            foreach($temp_joueurs as $participant) {
              $tournoi->addTennisUtilisateursParticipant($participant);
            }
        		if($tournoi->getStatut() == "Non Commencé"){
        			$tournoi->setDateDebutInscriptions($faker->dateTimeBetween($startDate = 'now', $endDate = '+1 month', $timezone = null));
        			$tournoi->setDateFinInscriptions($faker->dateTimeBetween($startDate = '+1 month', $endDate = '+2 month', $timezone = null));
        			$tournoi->setDateDebuttournoi($faker->dateTimeBetween($startDate = '+2 month', $endDate = '+3 month', $timezone = null));
        			$tournoi->setDateFintournoi($faker->dateTimeBetween($startDate = '+3 month', $endDate = '+4 month', $timezone = null));
        	  }
            else if($tournoi->getStatut() == "Phase d'inscriptions"){
        			$tournoi->setDateDebutInscriptions($faker->dateTimeBetween($startDate = '-1 month', $endDate = 'now', $timezone = null));
        			$tournoi->setDateFinInscriptions($faker->dateTimeBetween($startDate = 'now', $endDate = '+1 month', $timezone = null));
        			$tournoi->setDateDebuttournoi($faker->dateTimeBetween($startDate = '+1 month', $endDate = '+2 month', $timezone = null));
        			$tournoi->setDateFintournoi($faker->dateTimeBetween($startDate = '+2 month', $endDate = '+3 month', $timezone = null));
        		}
        		else if($tournoi->getStatut() == "Commencé"){
        			$tournoi->setDateDebutInscriptions($faker->dateTimeBetween($startDate = '-2 month', $endDate = '-1 month', $timezone = null));
        			$tournoi->setDateFinInscriptions($faker->dateTimeBetween($startDate = '-1 month', $endDate = 'now', $timezone = null));
        			$tournoi->setDateDebuttournoi($faker->dateTimeBetween($startDate = '-1 month', $endDate = '+1 month', $timezone = null));
        			$tournoi->setDateFintournoi($faker->dateTimeBetween($startDate = '+1 month', $endDate = '+2 month', $timezone = null));
            }
        		else /* Terminé */ {
        			$tournoi->setDateDebutInscriptions($faker->dateTimeBetween($startDate = '-4 month', $endDate = '-3 month', $timezone = null));
        			$tournoi->setDateFinInscriptions($faker->dateTimeBetween($startDate = '-3 month', $endDate = '-2 month', $timezone = null));
        			$tournoi->setDateDebuttournoi($faker->dateTimeBetween($startDate = '-2 month', $endDate = '-1 month', $timezone = null));
        			$tournoi->setDateFintournoi($faker->dateTimeBetween($startDate = '-1 month', $endDate = 'now', $timezone = null));
        		}

            // Ajout de tours dans ce Tournoi (sauf s tournoi non commencé ou en phase d'inscriptions (pas possible de creer de tour & matchs)
		        if($tournoi->getStatut() != "Non Commencé" && $tournoi->getStatut() != "Phase d'inscriptions"){
			           $tableauStatutTour = array("Terminé", "Commencé", "Organisation");

                  // TRAITER LE CAS D'UN TOURNOI DEJA FINI
                  if($tournoi->getStatut() == "Terminé"){
                    $tabTypeTours = ["Quart de finale", "Demi finale", "Finale"];
                    for($i=0; $i<3; $i++){
                      $tour = new TennisTour();
                      $tour->setStatut("Terminé");
                      $tour->setNumero($i+1);
                      $tour->setType($tabTypeTours[$i]);
                      $tour->setDateFinTour($faker->dateTimeBetween($startDate = '-5 months', $endDate = 'now', $timezone = null));

                      $participants = $tournoi->getTennisUtilisateursParticipant()->toArray();

                      $nbMatchs = intdiv(count($participants), 2);

                      for($j=0; $j<$nbMatchs; $j++){
                        $match = new TennisMatch();
                        $match->setEtat("Terminé");
                        $j1 = $faker->randomElement($participants);
                        array_diff($participants, [$j1]);
                        $j2 = $faker->randomElement($participants);
                        array_diff($participants, [$j2]);
                        $match->addTennisUtilisateur($j1);
                        $match->addTennisUtilisateur($j2);

                        for($k=1; $k<=$nbSetsGagnants; $k++){
                            $set = new TennisSet();
                            $set->setNbJeuxDuGagnant(6);
                            $temp_match_participants = [$j1, $j2];
                            $numeroGagnant = $faker->numberBetween(0,1);
                            $set->setTennisUtilisateurGagnant($temp_match_participants[$numeroGagnant]);
                            array_diff($temp_match_participants, [$temp_match_participants[$numeroGagnant]]);
                            $set->setNbJeuxDuPerdant($faker->numberBetween(0,4));
                            $set->setTennisUtilisateurPerdant($participantsMatch[0]);
                            $set->setTennisMatch($match);
                            $match->addTennisSet($set);
                            $manager->persist($set);
                        }

                        $nbSetJoueur1 = 0;
                        $nbSetJoueur2 = 0;

                        foreach($match->getTennisSets() as $matchSet){
                           if($matchSet->getTennisUtilisateurGagnant() == $participantsMatch[0]){
                             $nbSetJoueur1++;
                           } else {
                             $nbSetJoueur2++;
                           }
                        }

                        if($nbSetJoueur1 > $nbSetJoueur2){
                          // JOUEUR 1 GAGNANT
                          array_diff($participants, [$participantsMatch[1]]);
                          $tournoi->removeTennisUtilisateursParticipant($participantsMatch[1]);
                        } else {
                          // JOUEUR 2 GAGNANT
                          array_diff($participants, [$participantsMatch[0]]);
                          $tournoi->removeTennisUtilisateursParticipant($participantsMatch[0]);
                        }

                        $match->setTennisTour($tour);
                        $tour->addTennisMatch($match);
                        $manager->persist($match);
                      }
                      $tournoi->addTennisTour($tour);
                      $manager->persist($tour);
                    }
                  } else {

                    // Tour n°1 déjà terminé
                    $tour1 = new TennisTour();
                    $tour1->setType("Quart de finale");
                    $tour1->setStatut("Terminé");
                    $tour1->setNumero(1);
                    $tour1->setDateFinTour($faker->dateTimeBetween($startDate = '-1 months', $endDate = '-1 days', $timezone = null));

                    $joueurs_tour1 = $tournoi->getTennisUtilisateursParticipant()->toArray();

                    for($i=0; $i<intdiv(count($joueurs_tour1), 2); $i++){
                      $match = new TennisMatch();
                      $participantsMatch = array($joueurs_tour1[$i*2], $joueurs_tour1[($i*2)+1]);
                      $match->setEtat("Terminé");
                      $match->addTennisUtilisateur($participantsMatch[0]);
                      $match->addTennisUtilisateur($participantsMatch[1]);

                      for($k=1; $k<=$nbSetsGagnants; $k++){
                          $set = new TennisSet();
                          $set->setNbJeuxDuGagnant(6);
                          $temp_match_participants = $participantsMatch;
                          $numeroGagnant = $faker->numberBetween(0,1);
                          $set->setTennisUtilisateurGagnant($temp_match_participants[$numeroGagnant]);
                          array_diff($temp_match_participants, [$temp_match_participants[$numeroGagnant]]);
                          $set->setNbJeuxDuPerdant($faker->numberBetween(0,4));
                          $set->setTennisUtilisateurPerdant($temp_match_participants[0]);
                          $set->setTennisMatch($match);
                          $match->addTennisSet($set);
                          $manager->persist($set);
                      }

                      $nbSetJoueur1 = 0;
                      $nbSetJoueur2 = 0;

                      foreach($match->getTennisSets() as $matchSet){
                         if($matchSet->getTennisUtilisateurGagnant() == $participantsMatch[0]){
                           $nbSetJoueur1++;
                         } else {
                           $nbSetJoueur2++;
                         }
                      }

                      if($nbSetJoueur1 > $nbSetJoueur2){
                        // JOUEUR 1 GAGNANT
                        array_diff($joueurs_tour1, [$participantsMatch[1]]);
                        $tournoi->removeTennisUtilisateursParticipant($participantsMatch[1]);
                      } else {
                        // JOUEUR 2 GAGNANT
                        array_diff($joueurs_tour1, [$participantsMatch[0]]);
                        $tournoi->removeTennisUtilisateursParticipant($participantsMatch[0]);
                      }

                      $match->setTennisTour($tour1);
                      $tour1->addTennisMatch($match);
                      $manager->persist($match);
                    }

                    $tour1->setTennistournoi($tournoi);
                    $tournoi->addTennisTour($tour1);
                    $manager->persist($tour1);

                    // Tour n°2 Commencé

                    $tour2 = new TennisTour();
                    $tour2->setType("Demi finale");
                    $tour2->setStatut("Commencé");
                    $tour2->setNumero(2);
                    $tour2->setDateFinTour($faker->dateTimeBetween($startDate = 'now', $endDate = '+1 month', $timezone = null));

                    $joueurs_tour2 = $tournoi->getTennisUtilisateursParticipant()->toArray();

                    $nbMatchs = intdiv(count($joueurs_tour2), 2);

                    for($p=0; $p<$nbMatchs; $p++){
                      $match = new TennisMatch();
                      $j1 = $faker->randomElement($joueurs_tour2);
                      array_diff($joueurs_tour2, [$j1]);
                      $j2 = $faker->randomElement($joueurs_tour2);
                      array_diff($joueurs_tour2, [$j2]);
                      $match->addTennisUtilisateur($j1);
                      $match->addTennisUtilisateur($j2);
                      if($i == 0){
                        $match->setEtat("Terminé");
                        for($k=1; $k<=$nbSetsGagnants; $k++){
                            $set = new TennisSet();
                            $set->setNbJeuxDuGagnant(6);
                            $temp_match_participants = $participantsMatchTour2;
                            $numeroGagnant = $faker->numberBetween(0,1);
                            $set->setTennisUtilisateurGagnant($temp_match_participants[$numeroGagnant]);
                            array_diff($temp_match_participants, [$temp_match_participants[$numeroGagnant]]);
                            $set->setNbJeuxDuPerdant($faker->numberBetween(0,4));
                            $set->setTennisUtilisateurPerdant($temp_match_participants[0]);
                            $set->setTennisMatch($match);
                            $match->addTennisSet($set);
                            $manager->persist($set);
                        }
                      } else {
                        $match->setEtat("Pas encore joué");
                      }
                      $tour2->addTennisMatch($match);
                      $match->setTennisTour($tour2);
                      $manager->persist($match);
                    }
                    $tour2->setTennisTournoi($tournoi);
                    $tournoi->addTennisTour($tour2);
                    $manager->persist($tour2);

                    // Dernier tour Organisation

                    $tour3 = new TennisTour();
                    $tour3->setType("Finale");
                    $tour3->setStatut("Organisation");
                    $tour3->setNumero(3);
                    $tour3->setDateFinTour($faker->dateTimeBetween($startDate = '+1 month', $endDate = '+2 month', $timezone = null));

                    $tour3->setTennisTournoi($tournoi);
                    $tournoi->addTennisTour($tour3);
                    $manager->persist($tour3);
            }
          }
          $manager->persist($tournoi);
		}
		$manager->flush();
	}
}
