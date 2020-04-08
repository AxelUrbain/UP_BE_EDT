<?php

namespace App\Repository;

use App\Entity\Promotion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @method Promotion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Promotion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Promotion[]    findAll()
 * @method Promotion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PromotionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Promotion::class);
    }

    public function findAllOrderedByYearWithPaging(int $currentPage, int $nbPerPage)
    {
        $query = $this->createQueryBuilder('promo')
            ->leftJoin('promo.annee', 'annee')
            ->orderBy('annee.anneePromotion', 'DESC')
            ->setFirstResult(($currentPage - 1) * $nbPerPage)
            ->setMaxResults($nbPerPage);

        return new Paginator($query);
    }

    public function findAllOrderedByYear()
    {
        return $this->createQueryBuilder('promo')
            ->leftJoin('promo.annee', 'annee')
            ->orderBy('annee.anneePromotion', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByRandomValue()
    {
        $count = $this->createQueryBuilder('u')
            ->select('COUNT(u)')
            ->getQuery()
            ->getSingleScalarResult();

        return $this->createQueryBuilder('u')
            ->setFirstResult(rand(0, $count - 1))
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleResult()
            ;
    }

    /*
    public function findOneBySomeField($value): ?Promotion
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
