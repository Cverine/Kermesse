<?php

namespace App\Repository;

use App\Entity\Stall;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Stall|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stall|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stall[]    findAll()
 * @method Stall[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StallRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Stall::class);
    }


//    /**
//     * @return Stall[] Returns an array of Stall objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Stall
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
