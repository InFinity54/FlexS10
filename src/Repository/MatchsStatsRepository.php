<?php

namespace App\Repository;

use App\Entity\MatchStats;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method MatchStats|null find($id, $lockMode = null, $lockVersion = null)
 * @method MatchStats|null findOneBy(array $criteria, array $orderBy = null)
 * @method MatchStats[]    findAll()
 * @method MatchStats[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MatchsStatsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MatchStats::class);
    }

    public function getBestKills()
    {
        return $this->createQueryBuilder("s")
            ->select('(s.player) AS player', '(SUM(s.kills)) AS number')
            ->groupBy("s.player")
            ->orderBy("SUM(s.kills)", "DESC")
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()[0];
    }

    public function getBestDeaths()
    {
        return $this->createQueryBuilder("s")
            ->select('(s.player) AS player', '(SUM(s.deaths)) AS number')
            ->groupBy("s.player")
            ->orderBy("SUM(s.deaths)", "DESC")
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()[0];
    }

    public function getBestAssists()
    {
        return $this->createQueryBuilder("s")
            ->select('(s.player) AS player', '(SUM(s.assists)) AS number')
            ->groupBy("s.player")
            ->orderBy("SUM(s.assists)", "DESC")
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()[0];
    }

    public function getKdas()
    {
        return $this->createQueryBuilder("s")
            ->select('(s.player) AS player', '(SUM(s.kills)) AS kills', '(SUM(s.deaths)) AS deaths', '(SUM(s.assists)) AS assists')
            ->groupBy("s.player")
            ->orderBy("s.player")
            ->getQuery()
            ->getResult();
    }
}
