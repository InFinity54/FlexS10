<?php

namespace App\Repository;

use App\Entity\MatchsComp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method MatchsComp|null find($id, $lockMode = null, $lockVersion = null)
 * @method MatchsComp|null findOneBy(array $criteria, array $orderBy = null)
 * @method MatchsComp[]    findAll()
 * @method MatchsComp[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MatchsCompRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MatchsComp::class);
    }
}
