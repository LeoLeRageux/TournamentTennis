<?php

namespace App\Form;

use App\Entity\TennisTournoi;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class TennisTournoiType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
            ->add('nom')
            ->add('adresse')
            ->add('dateDebutTournoi')
            ->add('dateFinTournoi')
            ->add('estVisible', null, [
                'help' => 'Les non-inscrits au tournoi ne pourront pas voir les détails du tournoi (inscrits, gagnant, résultats des matchs ...).',
            ])
            ->add('surface')
            ->add('categorieAge')
            ->add('genreHomme')
            ->add('description')
            ->add('dateDebutInscriptions')
            ->add('dateFinInscriptions')
            ->add('inscriptionsManuelles', null, [
                'help' => 'L inscription des joueurs sera faîte manuellement par le créateur du tournoi.',
            ])
            ->add('nbPlaces')
            ->add('motDePasse', null, [
                'help' => 'Laisser vide si vous ne souhaitez pas de mot de passe.',
            ])
            ->add('validationInscriptions', null, [
                'help' => 'L organisateur pourra accepter/refuser les demandes d inscriptions' ,
            ])
            ->add('nbSetsGagnants')
            ->add('statut')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TennisTournoi::class,
        ]);
    }
}
