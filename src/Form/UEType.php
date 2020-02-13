<?php

namespace App\Form;

use App\Entity\Formation;
use App\Entity\UE;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UEType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomUE', TextType::class, ['label' => 'Nom de l\'UE'])
            ->add('specialite')
            ->add('couleur', ColorType::class)
            ->add('volumeHoraire')
            ->add('formations', EntityType::class, [
                'class' => Formation::class,
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false,
                'label' => 'Formations concernées'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UE::class,
        ]);
    }
}
