<?php

namespace App\Repository;

use App\Entity\Cours;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Cours|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cours|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cours[]    findAll()
 * @method Cours[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CoursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cours::class);
    }

    public function findByWeek($semaine) {
        $minCreneau = (($semaine - 1) * 20) + 1;
        $maxCreneau = (($semaine - 1) * 20) + 20;
        dump($minCreneau);
        dump($maxCreneau);
        $qb = $this->createQueryBuilder('c')
            ->where('c.creneau >= :minCreneau')
            ->setParameter('minCreneau', $minCreneau)
            ->andWhere('c.creneau <= :maxCreneau')
            ->setParameter('maxCreneau', $maxCreneau)
            ->leftJoin('c.UE', 'u')
            ->addSelect('u.couleur as u_couleur')
            ->addSelect('u.nomUE as u_nomUE')
            ->leftJoin('c.professeur', 'p')
            ->leftJoin('p.RFID', 'r')
            ->addSelect('CONCAT(r.nom, \' \', r.prenom) as p_nom')
            ->leftJoin('c.salle', 's')
            ->addSelect('s.nom as s_nom')
            ->orderBy('c.creneau', 'ASC')
        ;

        return $qb->getQuery()->getScalarResult();
    }

    // /**
    //  * @return Cours[] Returns an array of Cours objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Cours
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
