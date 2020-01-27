<?php

namespace App\Repository;

use App\Entity\TennisTournoi;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TennisTournoi|null find($id, $lockMode = null, $lockVersion = null)
 * @method TennisTournoi|null findOneBy(array $criteria, array $orderBy = null)
 * @method TennisTournoi[]    findAll()
 * @method TennisTournoi[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TennisTournoiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TennisTournoi::class);
    }

    // /**
    //  * @return TennisTournoi[] Returns an array of TennisTournoi objects
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
    public function findOneBySomeField($value): ?TennisTournoi
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
