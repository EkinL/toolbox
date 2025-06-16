<?php

namespace App\Repository;

use App\Entity\Toolbox;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Team;

/**
 * @extends ServiceEntityRepository<Toolbox>
 */
class ToolboxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Toolbox::class);
    }

public function findByTeam(Team $team): array
{
    return $this->createQueryBuilder('t')
        ->andWhere(':team MEMBER OF t.teamId')
        ->setParameter('team', $team)
        ->getQuery()
        ->getResult();
}

    //    /**
    //     * @return Toolbox[] Returns an array of Toolbox objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Toolbox
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
