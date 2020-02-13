<?php

namespace App\Repository;

use App\Entity\Professeur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @method Professeur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Professeur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Professeur[]    findAll()
 * @method Professeur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfesseurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Professeur::class);
    }

    public function findAllWithPaging(int $currentPage, int $nbPerPage)
    {
        $query = $this->createQueryBuilder('p')
            ->leftJoin('p.statut', 's')
            ->leftJoin('p.RFID', 'r')
            ->addSelect('s')
            ->addSelect('r')
            ->setFirstResult(($currentPage - 1) * $nbPerPage)
            ->setMaxResults($nbPerPage);

        return new Paginator($query);
    }

    public function findProfessorById(int $id)
    {
        $query = $this->createQueryBuilder('p')
            ->where('p.id = :id')
            ->setParameter('id', $id)
            ->join('p.statut', 's')
            ->join('p.RFID', 'r')
            ->join('p.specialite', 'spe')
            ->addSelect('s')
            ->addSelect('r')
            ->addSelect('spe');

        return $query->getQuery()->getSingleResult();
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
    public function findOneBySomeField($value): ?Professeur
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
