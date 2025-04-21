<?php

namespace App\Repository;

use App\Entity\DetailGarde;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DetailGarde|null find($id, $lockMode = null, $lockVersion = null)
 * @method DetailGarde|null findOneBy(array $criteria, array $orderBy = null)
 * @method DetailGarde[]    findAll()
 * @method DetailGarde[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DetailGardeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DetailGarde::class);
    }

    // /**
    //  * @return DetailGarde[] Returns an array of DetailGarde objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DetailGarde
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
