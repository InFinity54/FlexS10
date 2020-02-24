<?php

namespace App\Repository;

use App\Entity\MatchsStats;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method MatchsStats|null find($id, $lockMode = null, $lockVersion = null)
 * @method MatchsStats|null findOneBy(array $criteria, array $orderBy = null)
 * @method MatchsStats[]    findAll()
 * @method MatchsStats[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MatchsStatsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MatchsStats::class);
    }
}
