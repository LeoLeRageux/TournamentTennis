<?php

namespace App\Form;

use App\Entity\TennisSet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TennisSetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nbjeuxDuJoueurUn')
            ->add('nbjeuxDuJoueurDeux')
            ->add('tennisMatch')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TennisSet::class,
        ]);
    }
}
