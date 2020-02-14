<?php

namespace App\Repository;

use App\Entity\FormationUE;
use App\Entity\UE;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method FormationUE|null find($id, $lockMode = null, $lockVersion = null)
 * @method FormationUE|null findOneBy(array $criteria, array $orderBy = null)
 * @method FormationUE[]    findAll()
 * @method FormationUE[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormationUERepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FormationUE::class);
    }

    /**
     * @return FormationUE[] Returns an array of FormationUE objects
     */
    public function findUEsByYear($year)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.anneeFormation = :val')
            ->setParameter('val', $year)
            ->orderBy('f.id', 'ASC')
            ->join('f.ue', 'u')
            ->addSelect('u.nomUE')
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?FormationUE
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
