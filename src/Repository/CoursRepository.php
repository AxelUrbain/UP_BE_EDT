<?php

namespace App\Repository;

use App\Entity\Cours;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManager;

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

    public function findBySemaineEtFormationEtUtilisateur($semaine, $formationId, $utilisateur) {
        $minCreneau = (($semaine - 1) * 20) + 1;
        $maxCreneau = (($semaine - 1) * 20) + 20;

        $expr = $this->_em->getExpressionBuilder();

        $ues = $this->_em->createQueryBuilder()
        ->select('u2.id')
        ->from('App:Formation', 'f')
        ->where('f.id = :formationId')
        ->join('f.formationUEs', 'fu')
        ->join('fu.ue', 'u2');

        if(in_array('ROLE_ETU', $utilisateur->getRoles())) {
            $ues->join('App:Etudiant', 'e')
                ->andWhere('e.id = :id')
                ->join('e.promotion', 'pr')
                ->andWhere('pr.anneeFormation = fu.anneeFormation');
        }

        $qb = $this->createQueryBuilder('c')
            ->andWhere('c.creneau >= :minCreneau')
            ->setParameter('minCreneau', $minCreneau)
            ->andWhere('c.creneau <= :maxCreneau')
            ->setParameter('maxCreneau', $maxCreneau)
            ->andWhere('c.isValide = true')
            ->leftJoin('c.UE', 'u')
            ->andWhere(
                $expr->in(
                    'u.id',
                    $ues->getDQL()
                )
            )
            ->setParameter('formationId', $formationId)
            ->addSelect('u.couleur as u_couleur')
            ->addSelect('u.nomUE as u_nomUE')
            ->leftJoin('c.professeur', 'p')
            ->leftJoin('p.RFID', 'r')
            ->addSelect('CONCAT(r.nom, \' \', r.prenom) as p_nom')
            ->leftJoin('c.salle', 's')
            ->addSelect('s.nom as s_nom')
            ->orderBy('c.creneau', 'ASC')
        ;

        if(in_array('ROLE_ETU', $utilisateur->getRoles())) {
            $qb->setParameter('id', $utilisateur->getId());
        }

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
