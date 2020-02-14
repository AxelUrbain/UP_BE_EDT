<?php

namespace App\Form;

use App\Entity\HeuresSup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HeuresSupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('anneePaye', DateType::class, [
                'html5' => false,
                'widget' => 'single_text',
                'format' => 'yyyy',
                'data' => new \DateTime(),
                'disabled' => true
            ])
            ->add('tauxHoraire')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => HeuresSup::class,
        ]);
    }
}
