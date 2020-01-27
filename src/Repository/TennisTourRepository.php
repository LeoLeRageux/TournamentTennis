<?php

namespace App\Repository;

use App\Entity\TennisTour;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TennisTour|null find($id, $lockMode = null, $lockVersion = null)
 * @method TennisTour|null findOneBy(array $criteria, array $orderBy = null)
 * @method TennisTour[]    findAll()
 * @method TennisTour[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TennisTourRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TennisTour::class);
    }

    // /**
    //  * @return TennisTour[] Returns an array of TennisTour objects
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
    public function findOneBySomeField($value): ?TennisTour
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
