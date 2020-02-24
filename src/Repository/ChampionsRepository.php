<?php

namespace App\Repository;

use App\Entity\Champions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Champions|null find($id, $lockMode = null, $lockVersion = null)
 * @method Champions|null findOneBy(array $criteria, array $orderBy = null)
 * @method Champions[]    findAll()
 * @method Champions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChampionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Champions::class);
    }
}
