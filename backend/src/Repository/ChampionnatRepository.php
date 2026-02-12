<?php

namespace App\Repository;

use App\Entity\Championnat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Repository pour gérer les requêtes de l'entité Championnat.
 *
 * @extends ServiceEntityRepository<Championnat>
 */
class ChampionnatRepository extends ServiceEntityRepository
{
    /**
     * Constructeur du dépôt de l'entité Championnat.
     *
     * @param ManagerRegistry $registry Gestion du dépôt
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Championnat::class);
    }
}
