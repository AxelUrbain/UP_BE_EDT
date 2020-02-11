<?php

namespace App\Repository;

use App\Entity\HeuresSup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method HeuresSup|null find($id, $lockMode = null, $lockVersion = null)
 * @method HeuresSup|null findOneBy(array $criteria, array $orderBy = null)
 * @method HeuresSup[]    findAll()
 * @method HeuresSup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HeuresSupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HeuresSup::class);
    }

    // /**
    //  * @return HeuresSup[] Returns an array of HeuresSup objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?HeuresSup
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
