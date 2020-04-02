<?php

namespace App\Form;

use App\Entity\TennisUtilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class TennisUtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            //->add('password')  -> affiche le mdp crypté
            ->add('nom')
            ->add('prenom')
            ->add('genreHomme', ChoiceType::class, array(
                'label' => 'Genre',
                'choices'  => array(
                    'Homme' => true,
                    'Femme' => false,),
                ))
            ->add('dateNaissance',DateType::class,[
                'widget' => 'choice',
                'years' => range(date('Y'), date('Y')-100),
                'format' => 'dd-MM-yyyy',
            ])
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
