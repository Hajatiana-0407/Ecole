<?php

namespace App\Repository;

use App\Entity\MatiereNiveau;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MatiereNiveau>
 */
class MatiereNiveauRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MatiereNiveau::class);
    }

    public function __get_AllMat_by_niveau( $id_niveau ){
        return $this->createQueryBuilder('mn')
                ->leftJoin('mn.Matiere' , 'm')
                ->addSelect('m')
                ->where('mn.niveau = ' . $id_niveau ) 
                ->orderBy('mn.id' , 'desc')
                ->getQuery()
                ->getResult() ; 
    }

    //    /**
    //     * @return MatiereNiveau[] Returns an array of MatiereNiveau objects
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

    //    public function findOneBySomeField($value): ?MatiereNiveau
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
