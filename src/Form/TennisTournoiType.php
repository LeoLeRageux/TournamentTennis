<?php

namespace App\Form;

use App\Entity\TennisTournoi;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;


class TennisTournoiType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('nom')
            ->add('adresse')
            ->add('dateDebutTournoi', DateType::class,[
                'widget' => 'choice',
                'years' => range(date('Y'), date('Y')+10),
                'format' => 'dd-MM-yyyy',
                ])
            ->add('dateFinTournoi', DateType::class,[
                'widget' => 'choice',
                'years' => range(date('Y'), date('Y')+10),
                'format' => 'dd-MM-yyyy',
                ])
            ->add('estVisible', ChoiceType::class, array(
                'choices'  => array(
                    'Oui' => true,
                    'Non' => false,),
                    'help' => 'un tournoi non visible n\'apparaît pas dans le moteur de recherche de tournois de l\'application',
                ))

            ->add('surface', ChoiceType::class, array(
                'choices'  => array(
                    'Dur' => "dur",
                    'Terre Battue' => "terre",
                    'Gazon' => "gazon",
                    'Indoor' => "indoor",
                )))
            ->add('categorieAge', ChoiceType::class, array(
                'choices'  => array(
                    '11/12 ans' => "11/12",
                    '13/14 ans' => "13/14",
                    '15/16 ans' => "15/16",
                    '17/18 ans' => "17/18",
                    'Seniors' => "seniors",
                    '35+' => "35",
                    '40+' => "40",
                    '45+' => "45",
                    '50+' => "50",
                    '55+' => "55",
                    '60+' => "60",
                    '65+' => "65",
                    '70+' => "70",
                    '75+' => "75",
                )))
            ->add('genreHomme',ChoiceType::class, array(
                'choices'  => array(
                    'Tournoi Homme' => true,
                    'Tournoi Femme' => false,))
                    )
            ->add('description',TextareaType::class, array(
                'required' => false
                ))
            ->add('dateDebutInscriptions', DateType::class,[
                'widget' => 'choice',
                'years' => range(date('Y'), date('Y')+10),
                'format' => 'dd-MM-yyyy',
                ])
            ->add('dateFinInscriptions', DateType::class,[
                'widget' => 'choice',
                'years' => range(date('Y'), date('Y')+10),
                'format' => 'dd-MM-yyyy',
                ])
            ->add('inscriptionsManuelles', ChoiceType::class, array(
                'choices'  => array(
                    'Oui' => true,
                    'Non' => false,),
                'help' => "Si oui, les joueurs peuvent s'inscrire d'eux même",
            ))
            ->add('nbPlaces')
            ->add('motDePasse', PasswordType::class , [
                'required' => false, // Règle de gestion : mot de passe pas nécessaire, (vide si pas de mdp)
                'help' => 'Laisser vide si vous ne souhaitez pas de mot de passe.',
            ])


            ->add('validationInscriptions', ChoiceType::class, array(
                'choices'  => array(
                    'Oui' => true,
                    'Non' => false,),
                'help' => "Si non, l'organisateur peut tout de même désincrire des joueurs",
            ))
            ->add('nbSetsGagnants', ChoiceType::class, array(
                'choices'  => array(
                    '2' => 2,
                    '3' => 3,
                )))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TennisTournoi::class,
        ]);
    }
}
