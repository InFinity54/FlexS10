<?php

namespace App\Repository;

use App\Entity\Champion;
use App\Entity\MatchComp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method MatchComp|null find($id, $lockMode = null, $lockVersion = null)
 * @method MatchComp|null findOneBy(array $criteria, array $orderBy = null)
 * @method MatchComp[]    findAll()
 * @method MatchComp[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MatchsCompRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MatchComp::class);
    }

    public function getPlayedChamps()
    {
        return $this->createQueryBuilder("m")
            ->select('(c.displayName) as champion', '(COUNT(m.champion)) as number')
            ->from($this->getEntityManager()->getRepository(Champion::class)->getEntityName(), "c")
            ->where("c.name = m.champion")
            ->groupBy("c.displayName")
            ->orderBy("COUNT(m.champion)", "DESC")
            ->setMaxResults("10")
            ->getQuery()
            ->getResult();
    }
}
