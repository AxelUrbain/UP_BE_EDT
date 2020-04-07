<?php

namespace App\Repository;

use App\Entity\RFID;
use App\Entity\Etudiant;
use App\Entity\Promotion;
use App\Entity\Formation;
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

    public function findFormations($rfid)
    {
        $qb = $this->createQueryBuilder('u')
            ->where('u.id = :rfid')
            ->setParameter('rfid', $rfid)
            ->join('App:Etudiant', 'e')
            ->join('e.promotion', 'p')
            ->join('p.formation', 'f')
            ->select('f.id')
        ;

        return $qb->getQuery()->getResult();
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
