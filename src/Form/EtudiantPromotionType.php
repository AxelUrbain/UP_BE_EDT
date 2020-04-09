<?php

namespace App\Form;

use App\Entity\Etudiant;
use App\Entity\Promotion;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EtudiantPromotionType extends AbstractType
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $a = $this->entityManager->getRepository(Etudiant::class)->findAllOrderedByName();

        $builder->add('etudiants', EntityType::class, [
            'class' => Etudiant::class,
            'placeholder' => '- choose --',
            'choices' => $a,
            'multiple' => true,
            'expanded' => true,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Promotion::class,
        ]);
    }
}
