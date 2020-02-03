<?php

namespace App\Form;

use App\Entity\TennisTournoi;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;



class TennisTournoiType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
            ->add('nom')
            ->add('adresse')
            ->add('dateDebutTournoi')
            ->add('dateFinTournoi')
            ->add('estVisible', ChoiceType::class, array(
                'choices'  => array(
                    'Oui' => true,
                    'Non' => false,),
                'help' => 'Les non-inscrits au tournoi ne pourront pas voir les détails du tournoi (inscrits, gagnant, résultats des matchs ...).',
                ))
                
            ->add('surface', ChoiceType::class, array(
                'choices'  => array(
                    'Dur' => null,
                    'Terre Battue' => false,
                    'Gazon' => true,
                    'Indoor' => false,
                )))
            ->add('categorieAge', ChoiceType::class, array(
                'choices'  => array(
                    '11/12 ans' => null,
                    '13/14 ans' => false,
                    '15/16 ans' => true,
                    '17/18 ans' => false,
                    'Seniors' => null,
                    '35+' => false,
                    '40+' => true,
                    '45+' => false,
                    '50+' => false,
                    '55+' => true,
                    '60+' => false,
                    '65+' => false,
                    '70+' => true,
                    '75+' => false,
                )))
            ->add('genreHomme',ChoiceType::class, array(
                'choices'  => array(
                    'Tournoi Homme' => true,
                    'Tournoi Femme' => false,)))

            ->add('description',TextareaType::class)
            ->add('dateDebutInscriptions')
            ->add('dateFinInscriptions')
            ->add('inscriptionsManuelles', ChoiceType::class, array(
                'choices'  => array(
                    'Oui' => true,
                    'Non' => false,),
                'help' => "L'inscription des joueurs sera faîte manuellement par le créateur du tournoi.",
            ))
            ->add('nbPlaces')
            ->add('motDePasse', PasswordType::class , [
                'help' => 'Laisser vide si vous ne souhaitez pas de mot de passe.',
            ])
            

            ->add('validationInscriptions', ChoiceType::class, array(
                'choices'  => array(
                    'Oui' => true,
                    'Non' => false,),
                'help' => "L'organisateur pourra accepter/refuser les demandes d'inscriptions" ,
            ))
            ->add('nbSetsGagnants', ChoiceType::class, array(
                'choices'  => array(
                    '2' => true,
                    '3' => false,
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
