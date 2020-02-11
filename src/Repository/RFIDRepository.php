<?php

namespace App\Repository;

use App\Entity\RFID;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method RFID|null find($id, $lockMode = null, $lockVersion = null)
 * @method RFID|null findOneBy(array $criteria, array $orderBy = null)
 * @method RFID[]    findAll()
 * @method RFID[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RFIDRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RFID::class);
    }

    // /**
    //  * @return RFID[] Returns an array of RFID objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RFID
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
