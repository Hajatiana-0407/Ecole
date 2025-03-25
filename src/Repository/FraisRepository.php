<?php

namespace App\Repository;

use App\Entity\Frais;
use App\Entity\Search\Search;
use App\Entity\Search\SearchDate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Frais>
 */
class FraisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Frais::class);
    }

    public function __get_all(SearchDate $search): Query
    {
        $query =  $this->createQueryBuilder('f')
            ->innerJoin('f.Niveau', 'n')
            ->addSelect('n')
            ->orderBy('f.id', 'desc');

        if ($search->getRecherche() != '') {
            $query->andWhere('n.nom LIKE :mot')
                ->setParameter('mot', '%' . $search->getRecherche() . '%');
        }
        if ($search->getDateDebut() != '') {
            $query->andwhere('f.createdAt >= :datedebut')
            ->setParameter('datedebut' ,$search->getDateDebut()) ; 
        }
        if ($search->getDateFin() != '') {
            $query->andwhere('f.createdAt <= :datefin')
            ->setParameter('datefin' ,$search->getDateFin()) ; 
        }

        return     $query->getQuery();
    }

    //    /**
    //     * @return Frais[] Returns an array of Frais objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('f.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Frais
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
