<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\TennisMatch;
use App\Entity\TennisSet;
use App\Entity\TennisTour;
use App\Entity\TennisTournoi;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR'); // create a French faker

        // On crée un Tournoi <dateTimeBetween('1980-10-10', '1980-10-10')>
		for($t=1; $t<=5; $t++){
        $tournoi = new TennisTournoi();
        $tournoi->setNom($faker->realText($maxNbChars = 10, $indexSize = 2));
        $tournoi->setAdresse($faker->realText($maxNbChars = 10, $indexSize = 2));
        $tournoi->setDateDebuttournoi($faker->dateTimeBetween($startDate = '-1 year', $endDate = '-1 month', $timezone = null));
        $tournoi->setDateFintournoi($faker->dateTimeBetween($startDate = '-1 month', $endDate = 'now', $timezone = null));
        $tournoi->setEstVisible($faker->boolean($chanceOfGettingTrue = 50));
        $tournoi->setSurface($faker->realText($maxNbChars = 10, $indexSize = 2));
		$age=$faker->regexify('[1-5][0-9]');
		$ageplusdeux=$age+2;
        $tournoi->setCategorieAge("".$age."/".$ageplusdeux."");
        $tournoi->setGenreHomme($faker->boolean($chanceOfGettingTrue = 50));
        $tournoi->setDescription($faker->realText($maxNbChars = 50, $indexSize = 2));
        $tournoi->setDateDebutInscriptions($faker->dateTimeBetween($startDate = '-1 year', $endDate = '-1 month', $timezone = null));
        $tournoi->setDateFinInscriptions($faker->dateTimeBetween($startDate = '-1 month', $endDate = 'now', $timezone = null));
        $tournoi->setInscriptionsManuelles($faker->boolean($chanceOfGettingTrue = 50));
        $tournoi->setNbPlaces($faker->numberBetween(10,20));
        $tournoi->setMotDePasse($faker->realText($maxNbChars = 10, $indexSize = 2));
        $tournoi->setValidationInscriptions($faker->boolean($chanceOfGettingTrue = 50));
		$nbSetsGagnants=$faker->numberBetween(2,3);
        $tournoi->setNbSetsGagnants($nbSetsGagnants);
        $tournoi->setStatut($faker->randomElement(["Non Commencé", "Phase d'incriptions", "Commencé", "Terminé"]));
        $manager->persist($tournoi);
        // Ajout de tours dans ce Tournoi
            for($i=1; $i<=3; $i++){
                $tour = new TennisTour();
                $tour->setType("Intermédiaire");
                $tour->setDateFinTour($faker->dateTimeBetween($startDate = '-5 days', $endDate = 'now', $timezone = null));
                $tour->setStatut($faker->randomElement(["Non Commencé", "Organisation", "Terminé"]));
                $tour->setNumero($i);
                $tour->setTennistournoi($tournoi);
                $tournoi->addTennisTour($tour);
                // Ajout de matchs dans chaque tour
                for($j=1; $j<=3; $j++){
                    $match = new TennisMatch();
                    $match->setEtat($faker->randomElement(["Pas encore joué", "Terminé"]));
                    $match->setTennisTour($tour);
                    $tour->addTennisMatch($match);
                    $manager->persist($tour);
                    $manager->persist($match);
                    for($k=1; $k<=$nbSetsGagnants+2; $k++){
                        $set = new TennisSet();
                        $set->setNbJeuxDuGagnant(6);
                        $set->setNbJeuxDuPerdant($faker->numberBetween(0,4));
                        $set->setTennisMatch($match);
                        $match->addTennisSet($set);
                        $manager->persist($set);

                    }
                }
            }
        $manager->flush();
		}
    }
}
