<?php

namespace App\Form;

use App\Entity\TennisUtilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TennisUtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            //->add('password')  -> affiche le mdp crypté
            ->add('nom')
            ->add('prenom')
            ->add('genreHomme')
            ->add('dateNaissance')
            ->add('telephone')
            ->add('niveau')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TennisUtilisateur::class,
        ]);
    }
}
