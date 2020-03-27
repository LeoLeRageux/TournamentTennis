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
		$tableauStatutTournoi = array("Non Commencé", "Phase d'incriptions", "Commencé", "Terminé");
		$listeSurfaces = array("Dur", "Gazon", "Terre Battue", "Indoor");
		for($t=1; $t<=12; $t++){
        $tournoi = new TennisTournoi();
        $tournoi->setNom($faker->realText($maxNbChars = 10, $indexSize = 2));
        $tournoi->setAdresse($faker->realText($maxNbChars = 10, $indexSize = 2));
        $tournoi->setEstVisible($faker->boolean($chanceOfGettingTrue = 50));
        $tournoi->setSurface($faker->randomElement($listeSurfaces));
		$age=$faker->regexify('[1-5][0-9]');
		$ageplusdeux=$age+2;
        $tournoi->setCategorieAge("".$age."/".$ageplusdeux."");
        $tournoi->setGenreHomme($faker->boolean($chanceOfGettingTrue = 50));
        $tournoi->setDescription($faker->realText($maxNbChars = 50, $indexSize = 2));
        $tournoi->setInscriptionsManuelles($faker->boolean($chanceOfGettingTrue = 50));
        $tournoi->setNbPlaces($faker->numberBetween(10,20));
        $tournoi->setMotDePasse($faker->realText($maxNbChars = 10, $indexSize = 2));
        $tournoi->setValidationInscriptions($faker->boolean($chanceOfGettingTrue = 50));
		$nbSetsGagnants=$faker->numberBetween(2,3);
        $tournoi->setNbSetsGagnants($nbSetsGagnants);
        $tournoi->setStatut($tableauStatutTournoi[($t-1)%4]);
		if($tournoi->getStatut() == "Non Commencé"){
			$tournoi->setDateDebutInscriptions($faker->dateTimeBetween($startDate = 'now', $endDate = '+1 month', $timezone = null));
			$tournoi->setDateFinInscriptions($faker->dateTimeBetween($startDate = '+1 month', $endDate = '+2 month', $timezone = null));
			$tournoi->setDateDebuttournoi($faker->dateTimeBetween($startDate = '+2 month', $endDate = '+3 month', $timezone = null));
			$tournoi->setDateFintournoi($faker->dateTimeBetween($startDate = '+3 month', $endDate = '+4 month', $timezone = null));
		}
		else if($tournoi->getStatut() == "Phase d'incriptions"){
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

        $manager->persist($tournoi);
        // Ajout de tours dans ce Tournoi (sauf s tournoi non commencé ou en phase d'inscriptions (pas possible de creer de tour & matchs)
		if($tournoi->getStatut() != "Non Commencé" && $tournoi->getStatut() != "Phase d'incriptions"){
			$tableauStatutTour = array("Terminé", "Commencé", "Organisation");
            for($i=1; $i<=3; $i++){
                $tour = new TennisTour();
                $tour->setType("Intermédiaire");
				if($tournoi->getStatut() == "Terminé")
				{
					$tour->setStatut("Terminé");
					$tour->setDateFinTour($faker->dateTimeBetween($startDate = '-5 days', $endDate = 'now', $timezone = null));
				}
				else // Commencé
				{
					$tour->setStatut($tableauStatutTour[$i-1]);
					if($tour->getStatut() == "Terminé"){
						$tour->setDateFinTour($faker->dateTimeBetween($startDate = '-5 days', $endDate = 'now', $timezone = null));
					} else if ($tour->getStatut() == "Commencé"){
						$tour->setDateFinTour($faker->dateTimeBetween($startDate = 'now', $endDate = '+1 month', $timezone = null));
					} else /* Organisation */ {
						$tour->setDateFinTour($faker->dateTimeBetween($startDate = '+1 month', $endDate = '+2 month', $timezone = null));
					}
				}
                $tour->setNumero($i);
                $tour->setTennistournoi($tournoi);
                $tournoi->addTennisTour($tour);
                // Ajout de matchs dans chaque tour
				$tableauEtatMatch = array("Pas encore joué", "Terminé");
                for($j=1; $j<=2; $j++){
                    $match = new TennisMatch();
					if($tour->getStatut() == "Terminé")
					{
						$match->setEtat("Terminé");
					}
					else if($tour->getStatut() == "Commencé")
					{
						$match->setEtat($tableauEtatMatch[$j-1]);
					}
					else //Organisation (crétion des matchs, aucun joués)
					{
						$match->setEtat("Pas encore joué");
					}
                    $match->setTennisTour($tour);
                    $tour->addTennisMatch($match);
                    $manager->persist($tour);
                    $manager->persist($match);
                    // Ajout de sets dans chaque match
                    for($k=1; $k<=$nbSetsGagnants; $k++){
                        $set = new TennisSet();
                        $set->setNbJeuxDuGagnant(6);
                        $set->setNbJeuxDuPerdant($faker->numberBetween(0,4));
                        $set->setTennisMatch($match);
                        $match->addTennisSet($set);
                        $manager->persist($set);

                    }
                }
            }
		}
		}
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
		$thomas->setNom("Thomas");
		$thomas->setPrenom("Bouchet");
    $thomas->setDateNaissance(new DateTime('12/07/1998'));
		$thomas->setTelephone("0658421541");
		$thomas->setNiveau("30/1");
		$manager->persist($thomas);

		$hugo = new TennisUtilisateur();
		$hugo->setEmail("hugo@labastie.com");
		$hugo->setRoles(["ROLE_USER"]);
		$hugo->setPassword('$2y$10$hpqU2WqUmKDAj706S3zumu35PfcHo50ifDSUDDPsGIwys63rPelHC');
		$hugo->setNom("Hugo");
		$hugo->setPrenom("Labastie");
    $hugo->setDateNaissance(new DateTime('12/07/1998'));
		$hugo->setTelephone("0657002148");
		$hugo->setNiveau("30/1");
		$manager->persist($hugo);

		$matthieu = new TennisUtilisateur();
		$matthieu->setEmail("matthieu@manke.com");
		$matthieu->setRoles(["ROLE_USER"]);
		$matthieu->setPassword('$2y$10$BANAkiaHJSDAqV7tqyyJMOXtzIXX2YLdyM0751ZcQQgISGkCN20ru');
		$matthieu->setNom("Matthieu");
		$matthieu->setPrenom("Manke");
    $matthieu->setDateNaissance(new DateTime('05/31/1999'));
		$matthieu->setTelephone("0610024120");
		$matthieu->setNiveau("30/1");
		$manager->persist($matthieu);

		$manager->flush();
	}
}
