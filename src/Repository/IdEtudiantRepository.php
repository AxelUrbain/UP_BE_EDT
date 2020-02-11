<?php

namespace App\Repository;

use App\Entity\IdEtudiant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method IdEtudiant|null find($id, $lockMode = null, $lockVersion = null)
 * @method IdEtudiant|null findOneBy(array $criteria, array $orderBy = null)
 * @method IdEtudiant[]    findAll()
 * @method IdEtudiant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IdEtudiantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IdEtudiant::class);
    }

    // /**
    //  * @return IdEtudiant[] Returns an array of IdEtudiant objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?IdEtudiant
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
