<?php

namespace App\Repository;

use App\Entity\Participation;
use App\Entity\Volunteer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Volunteer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Volunteer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Volunteer[]    findAll()
 * @method Volunteer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VolunteerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Volunteer::class);
    }

    /**
     * @return Volunteer[]
     */
    public function findBySensitive()
    {
        return $this->createQueryBuilder('volunteer')
            ->where('volunteer.okSensitive = true')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByFirstSlot()
    {
        return $this->createQueryBuilder('volunteer')
            ->where('volunteer.firstSlot = true')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findBySecondSlot()
    {
        return $this->createQueryBuilder('volunteer')
            ->where('volunteer.secondSlot = true')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByThirdSlot()
    {
        return $this->createQueryBuilder('volunteer')
            ->where('volunteer.thirdSlot = true')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByPrepare()
    {
        return $this->createQueryBuilder('volunteer')
            ->where('volunteer.prepare = true')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByTidy()
    {
        return $this->createQueryBuilder('volunteer')
            ->where('volunteer.tidy = true')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findBySitFirstSlot()
    {
        return $this->createQueryBuilder('volunteer')
            ->where('volunteer.isSitting = true')
            ->andWhere('volunteer.firstSlot = true')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findBySitSecondSlot()
    {
        return $this->createQueryBuilder('volunteer')
            ->where('volunteer.isSitting = true')
            ->andWhere('volunteer.secondSlot = true')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findBySitThirdSlot()
    {
        return $this->createQueryBuilder('volunteer')
            ->where('volunteer.isSitting = true')
            ->andWhere('volunteer.thirdSlot = true')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByParticipation($slot)
    {
        return $this->createQueryBuilder('v')
            ->join('v.participations', 'p')
            ->where('p.slot = :slot')
            ->setParameter('slot', $slot)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findWithoutParticipationBySlot1()
    {
        $rawSql = "SELECT v.name from volunteer v where v.first_slot = 1 and v.id NOT IN (
                        select pv.volunteer_id from participation_volunteer pv
                        left join participation p on p.id = pv.participation_id
                        where p.slot = 1);";

        $stmt = $this->getEntityManager()->getConnection()->prepare($rawSql);
        $stmt->execute([]);
    
        return $stmt->fetchAll();
    }
    
    public function findWithoutParticipationBySlot2()
    {
        $rawSql = "SELECT v.name from volunteer v where v.second_slot = 1 and v.id NOT IN (
                        select pv.volunteer_id from participation_volunteer pv
                        left join participation p on p.id = pv.participation_id
                        where p.slot = 2);";

        $stmt = $this->getEntityManager()->getConnection()->prepare($rawSql);
        $stmt->execute([]);
    
        return $stmt->fetchAll();
    }

    public function findWithoutParticipationBySlot3()
    {
        $rawSql = "SELECT v.name from volunteer v where v.third_slot = 1 and v.id NOT IN (
                        select pv.volunteer_id from participation_volunteer pv
                        left join participation p on p.id = pv.participation_id
                        where p.slot = 3);";

        $stmt = $this->getEntityManager()->getConnection()->prepare($rawSql);
        $stmt->execute([]);
    
        return $stmt->fetchAll();
    }

}
