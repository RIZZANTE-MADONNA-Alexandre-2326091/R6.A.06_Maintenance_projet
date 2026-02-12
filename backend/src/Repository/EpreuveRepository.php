<?php

namespace App\Repository;

use App\Entity\Epreuve;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Repository pour gérer les requêtes de l'entité Epreuve.
 *
 * @extends ServiceEntityRepository<Epreuve>
 */
class EpreuveRepository extends ServiceEntityRepository
{
    /**
     * Constructeur du dépôt de l'entité Epreuve.
     *
     * @param ManagerRegistry $registry Gestion du dépôt
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Epreuve::class);
    }

    //    /**
    //     * @return Epreuve[] Returns an array of Epreuve objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Epreuve
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
