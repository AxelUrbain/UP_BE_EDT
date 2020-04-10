<?php

namespace App\Form;

use App\Entity\Etudiant;
use App\Entity\Promotion;
use App\Entity\RFID;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EtudiantType extends AbstractType
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $a = $this->entityManager->getRepository(RFID::class)->findAllOrderedByName();

        $builder
            ->add('promotion', EntityType::class, [
                'class' => Promotion::class,
            ])
           ->add('RFID', EntityType::class, [
               'class' => RFID::class,
               'choices' => $a,
           ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Etudiant::class,
        ]);
    }
}
