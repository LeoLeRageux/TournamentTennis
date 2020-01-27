<?php

namespace App\Form;

use App\Entity\TennisTour;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TennisTourType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type')
            ->add('dateFinTour')
            ->add('statut')
            ->add('numero')
            ->add('tennisTournoi')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TennisTour::class,
        ]);
    }
}
