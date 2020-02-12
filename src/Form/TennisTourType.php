<?php

namespace App\Form;

use App\Entity\TennisTour;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;


class TennisTourType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', ChoiceType::class, array(
                'choices'  => array(
                    'Tour intermédiaire' => "Intermediaire",
                    'Quart de finale' => "Quart",
                    'Demi finale' => "Demi",
                    'Finale' => "Finale",
                )))
            ->add('dateFinTour', DateType::class, array(
                'help' => "La date saisie est la date limite à laquelle tous les matchs du tour doivent être jouer",
                )
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TennisTour::class,
        ]);
    }
}
