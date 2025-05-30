<?php

namespace App\Repository;

use App\Entity\Droit;
use App\Entity\Search\Search;
use App\Entity\Search\SearchDate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Droit>
 */
class DroitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Droit::class);
    }

    public function __get_all(SearchDate $search): Query
    {
        $query = $this->createQueryBuilder('d')
            ->innerJoin('d.Niveau', 'n')
            ->addSelect('n')
            ->orderBy('d.id', 'desc');


        if ($search->getRecherche() != '') {
            $query->andWhere('n.nom LIKE :mot')
                ->setParameter('mot', '%' . $search->getRecherche() . '%');
        }
        if ($search->getDateDebut() != '') {
            $query->andwhere('d.createdAt >= :datedebut')
            ->setParameter('datedebut' ,$search->getDateDebut()) ; 
        }
        if ($search->getDateFin() != '') {
            $query->andwhere('d.createdAt <= :datefin')
            ->setParameter('datefin' ,$search->getDateFin()) ; 
        }
        return   $query->getQuery();
    }

    //    /**
    //     * @return Droit[] Returns an array of Droit objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('d.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Droit
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
