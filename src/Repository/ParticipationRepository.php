<?php
/**
 * Created by PhpStorm.
 * User: severine
 * Date: 09/10/18
 * Time: 22:08
 */

namespace App\Repository;

use App\Entity\Participation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ParticipationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Participation::class);
    }

    public function findByFirstSlot()
    {
        return $this->createQueryBuilder('participation')
            ->where('participation.slot = 1')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findBySecondSlot()
    {
        return $this->createQueryBuilder('participation')
            ->where('participation.slot = 2')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByThirdSlot()
    {
        return $this->createQueryBuilder('participation')
            ->where('participation.slot = 3')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByPrepare()
    {
        return $this->createQueryBuilder('participation')
            ->where('participation.slot = 4')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByTidy()
    {
        return $this->createQueryBuilder('participation')
            ->where('participation.slot = 5')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findBySensitive()
    {
        return $this->createQueryBuilder('participation')
            ->join('participation.stall', 'stall')
            ->where('stall.isSensitive = true')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findBySit()
    {
        return $this->createQueryBuilder('participation')
            ->join('participation.stall', 'stall')
            ->where('stall.isSitting = true')
            ->getQuery()
            ->getResult()
            ;
    }
}