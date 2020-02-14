<?php

namespace App\Form;

use App\Entity\FormationUE;
use App\Entity\UE;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormationUEType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ue', EntityType::class, [
                'class' => UE::class,
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false,
                'label' => 'UEs de la formation'
            ])
            ->add('anneeFormation')
            ->add('formation')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FormationUE::class,
        ]);
    }
}
