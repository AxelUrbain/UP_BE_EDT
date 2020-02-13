<?php

namespace App\Form;

use App\Entity\Formation;
use App\Entity\UE;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('diplome')
            ->add('nbAnnee')
            ->add('professeurResponsable')
            ->add('UE', EntityType::class, [
                'class' => UE::class,
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false,
                'label' => 'form.UE'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Formation::class,
        ]);
    }
}
