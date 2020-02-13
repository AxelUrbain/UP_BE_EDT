<?php

namespace App\Form;

use App\Entity\Professeur;
use App\Entity\RFID;
use App\Entity\Specialite;
use App\Entity\Statut;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfesseurType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('statut', EntityType::class, [
                'class' => Statut::class,
                'label' => 'Statut',
                'multiple' => false
            ])
            ->add('RFID', EntityType::class, [
                'class' =>  RFID::class,
                'label' => 'RFID',
                'multiple' => false,
                'disabled' => true
            ])
            ->add('specialite', EntityType::class, [
                'class' => Specialite::class,
                'label' => 'Specialité',
                'multiple' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Professeur::class,
        ]);
    }
}
