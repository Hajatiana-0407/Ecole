<?php

namespace App\Repository;

use App\Entity\Classe;
use App\Entity\Search\Search;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Classe>
 *
 * @method Classe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Classe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Classe[]    findAll()
 * @method Classe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClasseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Classe::class);
    }

    public function __get_all(Search $search)
    {
        $query = $this->createQueryBuilder('c')
            ->innerJoin('c.Niveau', 'n')
            ->addSelect('n')
            ->orderBy('c.id', 'desc');

        if ($search->getRecherche() != '') {
            $query->andWhere('c.denomination LIKE :mot')
                ->orWhere('n.nom LIKE :mot')
                ->setParameter('mot', '%' . $search->getRecherche() . '%');
        }
        // ->orderBy('n.nom' , 'desc')
        return $query->getQuery();
    }


    public function __get_classeListe(Search $search , int $id )
    {
        $query = $this->createQueryBuilder('c')
            ->innerJoin('c.Niveau', 'n')
            ->addSelect('n')
            ->orderBy('c.id', 'desc')
            ->andWhere('n.id = :niveau_id')
            ->setParameter('niveau_id' , $id )
            ;

        if ($search->getRecherche() != '') {
            $query->andWhere('c.denomination LIKE :mot OR n.nom LIKE :mot')
                ->setParameter('mot', '%' . $search->getRecherche() . '%');
        }
        // ->orderBy('n.nom' , 'desc')
        return $query->getQuery();
    }

    //    /**
    //     * @return Classe[] Returns an array of Classe objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Classe
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
