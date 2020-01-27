<?php

namespace App\Form;

use App\Entity\TennisTournoi;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TennisTournoiType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('adresse')
            ->add('dateDebutTournoi')
            ->add('dateFinTournoi')
            ->add('estVisible')
            ->add('surface')
            ->add('categorieAge')
            ->add('genreHomme')
            ->add('description')
            ->add('dateDebutInscriptions')
            ->add('dateFinInscriptions')
            ->add('inscriptionsManuelles')
            ->add('nbPlaces')
            ->add('motDePasse')
            ->add('validationInscriptions')
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
