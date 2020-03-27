<?php

namespace App\Form;

use App\Entity\TennisTournoi;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class TennisTournoiDateDebut extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateDebutTournoi', DateType::class,[
              'widget' => 'choice',
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
