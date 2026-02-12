<?php

namespace App\Repository;

use App\Entity\Epreuve;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Repository pour gérer les requêtes de l'entité Epreuve.
 * @extends ServiceEntityRepository<Epreuve>
 */
class EpreuveRepository extends ServiceEntityRepository
{
    /**
     * Constructeur du dépôt de l'entité Epreuve.
     * @param ManagerRegistry $registry Gestion du dépôt
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Epreuve::class);
    }
}
