<?php

namespace App\Repository;

use App\Entity\DetailRespo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DetailRespo|null find($id, $lockMode = null, $lockVersion = null)
 * @method DetailRespo|null findOneBy(array $criteria, array $orderBy = null)
 * @method DetailRespo[]    findAll()
 * @method DetailRespo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DetailRespoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DetailRespo::class);
    }

    // /**
    //  * @return DetailRespo[] Returns an array of DetailRespo objects
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
    public function findOneBySomeField($value): ?DetailRespo
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
