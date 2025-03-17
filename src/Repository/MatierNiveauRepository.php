<?php

namespace App\Repository;

use App\Entity\MatierNiveau;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MatierNiveau>
 */
class MatierNiveauRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MatierNiveau::class);
    }

    public function __get_AllMat_by_niveau( $id_niveau ){
        return $this->createQueryBuilder('mn')
                ->leftJoin('mn.matier' , 'm')
                ->addSelect('m')
                ->where('mn.niveau = ' . $id_niveau ) 
                ->orderBy('mn.id' , 'desc')
                ->getQuery()
                ->getResult() ; 
    }

    //    /**
    //     * @return MatierNiveau[] Returns an array of MatierNiveau objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('m.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?MatierNiveau
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
