<?php

namespace App\Repository;

use App\Entity\TennisSet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TennisSet|null find($id, $lockMode = null, $lockVersion = null)
 * @method TennisSet|null findOneBy(array $criteria, array $orderBy = null)
 * @method TennisSet[]    findAll()
 * @method TennisSet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TennisSetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TennisSet::class);
    }

    // /**
    //  * @return TennisSet[] Returns an array of TennisSet objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TennisSet
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
