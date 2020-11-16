<?php

namespace App\Repository;

use App\Entity\Match;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Match|null find($id, $lockMode = null, $lockVersion = null)
 * @method Match|null findOneBy(array $criteria, array $orderBy = null)
 * @method Match[]    findAll()
 * @method Match[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MatchsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Match::class);
    }

    public function findAllOrderedByDate()
    {
        $qb = $this->createQueryBuilder("m");
        return $qb->select("m")
            ->orderBy("m.datetime", "DESC")
            ->getQuery()
            ->getResult();
    }

    public function getNumberOfMatchs()
    {
        $qb = $this->createQueryBuilder("m");
        return $qb->select("COUNT(m.id)")
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function getNumberOfVictory()
    {
        $qb = $this->createQueryBuilder("m");
        return $qb->select("COUNT(m.result)")
            ->where("m.result = 'WIN'")
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function getNumberOfDefeat()
    {
        $qb = $this->createQueryBuilder("m");
        return $qb->select("COUNT(m.result)")
            ->where("m.result = 'LOSE'")
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function getNumberOfRemake()
    {
        $qb = $this->createQueryBuilder("m");
        return $qb->select("COUNT(m.result)")
            ->where("m.result = 'REMAKE'")
            ->getQuery()
            ->getSingleScalarResult();
    }
}
