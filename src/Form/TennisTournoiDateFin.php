<?php

namespace App\Form;

use App\Entity\TennisTournoi;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;




class TennisTournoiDateFin extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
            ->add('dateFinTournoi', DateType::class,[
                'widget' => 'choice',
                'years' => range(date('Y'), date('Y')+10),
                'format' => 'dd-MM-yyyy',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TennisTournoi::class,
        ]);
    }
}
