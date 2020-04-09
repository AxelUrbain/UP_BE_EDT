<?php

namespace App\Form;

use App\Entity\Etudiant;
use App\Entity\Promotion;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EtudiantPromotionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('etudiants', EntityType::class, [
                'class' => Etudiant::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('etudiants')
                        ->leftJoin('etudiants.RFID', 'rfid')
                        ->orderBy('rfid.nom', 'ASC');
                },
                'multiple' => true,
                'expanded' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Promotion::class,
        ]);
    }
}
