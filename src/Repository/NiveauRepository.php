<?php

namespace App\Repository;

use App\Entity\Niveau;
use App\Entity\Search\SearchDate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Niveau>
 *
 * @method Niveau|null find($id, $lockMode = null, $lockVersion = null)
 * @method Niveau|null findOneBy(array $criteria, array $orderBy = null)
 * @method Niveau[]    findAll()
 * @method Niveau[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NiveauRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Niveau::class);
    }

    public function __get_all(SearchDate $search): Query
    {

        $query =  $this->createQueryBuilder('n')
            ->orderBy('n.id', 'desc')
            ->leftJoin('n.frais', 'f', 'WITH', 'f.id = (
                        SELECT MAX(f2.id) FROM App\Entity\Frais f2 
                        WHERE f2.Niveau = n.id
                    )')
            ->leftJoin('n.droits', 'd', 'WITH', 'd.id = (
                        SELECT MAX(d2.id) FROM App\Entity\Droit d2 
                        WHERE d2.Niveau = n.id
                    )')
            ->leftJoin('n.classes', 'c')
            ->addSelect('f');

        // Recherche avec date
        if ($search->getRecherche() != '') {
            $query->andwhere('n.nom LIKE :motcle')
            ->setParameter('motcle' , '%'.$search->getRecherche().'%') ; 
        }
        if ($search->getDateDebut() != '') {
            $query->andwhere('n.createdAt >= :datedebut')
            ->setParameter('datedebut' ,$search->getDateDebut()) ; 
        }
        if ($search->getDateFin() != '') {
            $query->andwhere('n.createdAt <= :datefin')
            ->setParameter('datefin' ,$search->getDateFin()) ; 
        }
        return $query->getQuery();
    }

    public function getAllNiveau()
    {
        return $this->createQueryBuilder('n')
            ->orderBy('n.id', 'desc')
            ->getQuery()
            ->getResult();;
    }


    //    /**
    //     * @return Niveau[] Returns an array of Niveau objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('n')
    //            ->andWhere('n.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('n.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Niveau
    //    {
    //        return $this->createQueryBuilder('n')
    //            ->andWhere('n.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
