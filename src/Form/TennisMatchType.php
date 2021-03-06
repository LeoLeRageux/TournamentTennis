<?php

namespace App\Form;

use App\Entity\TennisMatch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\TennisUtilisateur;

class TennisMatchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tennisUtilisateurs', EntityType::class, array(
                'class' => TennisUtilisateur::class,
                'choice_label' => 'NomComplet',
                'multiple' => false,
                'expanded' => false
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TennisMatch::class,
        ]);
    }
}
