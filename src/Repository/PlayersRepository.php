<?php

namespace App\Repository;

use App\Entity\MatchStats;
use App\Entity\Player;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Player|null find($id, $lockMode = null, $lockVersion = null)
 * @method Player|null findOneBy(array $criteria, array $orderBy = null)
 * @method Player[]    findAll()
 * @method Player[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlayersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Player::class);
    }

    public function countNumberOfGames(string $id)
    {
        $qb = $this->createQueryBuilder("p");
        return $qb->select("COUNT(ms.match)")
            ->from(MatchStats::class, "ms")
            ->where("ms.player = p.nickname")
            ->andWhere("ms.player = '".$id."'")
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countKills(string $id)
    {
        $qb = $this->createQueryBuilder("p");
        return $qb->select('(SUM(ms.kills)) AS number')
            ->from(MatchStats::class, "ms")
            ->where("ms.player = p.nickname")
            ->andWhere("ms.player = '".$id."'")
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countDeaths(string $id)
    {
        $qb = $this->createQueryBuilder("p");
        return $qb->select('(SUM(ms.deaths)) AS number')
            ->from(MatchStats::class, "ms")
            ->where("ms.player = p.nickname")
            ->andWhere("ms.player = '".$id."'")
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countAssists(string $id)
    {
        $qb = $this->createQueryBuilder("p");
        return $qb->select('(SUM(ms.assists)) AS number')
            ->from(MatchStats::class, "ms")
            ->where("ms.player = p.nickname")
            ->andWhere("ms.player = '".$id."'")
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countCreeps(string $id)
    {
        $qb = $this->createQueryBuilder("p");
        return $qb->select('(SUM(ms.creeps)) AS number')
            ->from(MatchStats::class, "ms")
            ->where("ms.player = p.nickname")
            ->andWhere("ms.player = '".$id."'")
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countTotalDmg(string $id)
    {
        return $this->countTotalPhysDmg($id) + $this->countTotalMagicDmg($id) + $this->countTotalRawDmg($id);
    }

    public function countTotalPhysDmg(string $id)
    {
        $qb = $this->createQueryBuilder("p");
        return $qb->select('(SUM(ms.physDamage)) AS number')
            ->from(MatchStats::class, "ms")
            ->where("ms.player = p.nickname")
            ->andWhere("ms.player = '".$id."'")
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countTotalMagicDmg(string $id)
    {
        $qb = $this->createQueryBuilder("p");
        return $qb->select('(SUM(ms.magicDamage)) AS number')
            ->from(MatchStats::class, "ms")
            ->where("ms.player = p.nickname")
            ->andWhere("ms.player = '".$id."'")
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countTotalRawDmg(string $id)
    {
        $qb = $this->createQueryBuilder("p");
        return $qb->select('(SUM(ms.rawDamage)) AS number')
            ->from(MatchStats::class, "ms")
            ->where("ms.player = p.nickname")
            ->andWhere("ms.player = '".$id."'")
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function avgKills(string $id)
    {
        $qb = $this->createQueryBuilder("p");
        return $qb->select('(AVG(ms.kills)) AS number')
            ->from(MatchStats::class, "ms")
            ->where("ms.player = p.nickname")
            ->andWhere("ms.player = '".$id."'")
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function avgDeaths(string $id)
    {
        $qb = $this->createQueryBuilder("p");
        return $qb->select('(AVG(ms.deaths)) AS number')
            ->from(MatchStats::class, "ms")
            ->where("ms.player = p.nickname")
            ->andWhere("ms.player = '".$id."'")
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function avgAssists(string $id)
    {
        $qb = $this->createQueryBuilder("p");
        return $qb->select('(AVG(ms.assists)) AS number')
            ->from(MatchStats::class, "ms")
            ->where("ms.player = p.nickname")
            ->andWhere("ms.player = '".$id."'")
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function avgCreeps(string $id)
    {
        $qb = $this->createQueryBuilder("p");
        return $qb->select('(AVG(ms.creeps)) AS number')
            ->from(MatchStats::class, "ms")
            ->where("ms.player = p.nickname")
            ->andWhere("ms.player = '".$id."'")
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function avgDmg(string $id)
    {
        return $this->avgPhysDmg($id) + $this->avgMagicDmg($id) + $this->avgRawDmg($id);
    }

    public function avgPhysDmg(string $id)
    {
        $qb = $this->createQueryBuilder("p");
        return $qb->select('(AVG(ms.physDamage)) AS number')
            ->from(MatchStats::class, "ms")
            ->where("ms.player = p.nickname")
            ->andWhere("ms.player = '".$id."'")
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function avgMagicDmg(string $id)
    {
        $qb = $this->createQueryBuilder("p");
        return $qb->select('(AVG(ms.magicDamage)) AS number')
            ->from(MatchStats::class, "ms")
            ->where("ms.player = p.nickname")
            ->andWhere("ms.player = '".$id."'")
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function avgRawDmg(string $id)
    {
        $qb = $this->createQueryBuilder("p");
        return $qb->select('(AVG(ms.rawDamage)) AS number')
            ->from(MatchStats::class, "ms")
            ->where("ms.player = p.nickname")
            ->andWhere("ms.player = '".$id."'")
            ->getQuery()
            ->getSingleScalarResult();
    }
}
