<?php
/**
 * Created by PhpStorm.
 * User: severine
 * Date: 16/11/18
 * Time: 19:34
 */

namespace App\Service;

use App\Entity\Participation;
use App\Entity\Stall;
use App\Repository\ParticipationRepository;
use App\Repository\StallRepository;
use App\Repository\VolunteerRepository;
use Doctrine\ORM\EntityManagerInterface;

class ParticipationGenerator
{
    const SLOTS = [0,1,2,3,4,5];

    /**
     * @var VolunteerRepository
     */
    private $volunteerRepository;

    /**
     * @var StallRepository
     */
    private $stallRepository;

    /**
     * @var ParticipationRepository
     */
    private $participationRepository;

    private $manager;

    public function __construct(
        VolunteerRepository $volunteerRepository,
        StallRepository $stallRepository,
        ParticipationRepository $participationRepository,
        EntityManagerInterface $manager)
    {
        $this->volunteerRepository = $volunteerRepository;
        $this->stallRepository = $stallRepository;
        $this->participationRepository = $participationRepository;
        $this->manager = $manager;
    }

    /**
     * @param Stall $stall
     */
    public function initializeParticipations($stall)
    {
        $manager = $this->manager;
        $buildSlot = [
            0,
            $stall->isFirstSlot(),
            $stall->isSecondSlot(),
            $stall->isFirstSlot(),
            $stall->isPrepare(),
            $stall->isTidy()
        ];
        $volunteersList = [
            4 => $this->volunteerRepository->findByPrepare(),
            5 => $this->volunteerRepository->findByTidy(),
        ];
        $count = count($buildSlot);

        for ($i = 1; $i < $count; $i++) {
            if ($buildSlot[$i] === true) {
                $slot = $this->participationRepository->findBy([
                    'stall' => $stall,
                    'slot' => self::SLOTS[$i]
                ]);
                if (empty($slot)) {
                    $participation = new Participation();
                    $participation->setManual(false);
                    $participation->setStall($stall);
                    $participation->setSlot(self::SLOTS[$i]);
                    if ($i === 4 || $i === 5 ) {
                        foreach ($volunteersList[$i] as $parent) {
                            $participation->addVolunteers($parent);
                        }
                    }
                    $manager->persist($participation);
                }
            }
        }
        $manager->flush();
    }

    public function dispatchVolunteers()
    {
        $manager = $this->manager;

        $findVolunteers = [
            0,
            array_diff($this->volunteerRepository->findByFirstSlot(), $this->volunteerRepository->findByParticipation(1)),
            array_diff($this->volunteerRepository->findBySecondSlot(), $this->volunteerRepository->findByParticipation(2)),
            array_diff($this->volunteerRepository->findByThirdSlot(), $this->volunteerRepository->findByParticipation(3)),
        ];
        $participations = $this->participationRepository->findByMainSlots();

        foreach ($participations as $participation) {
            $slot = $participation->getSlot();
            $nbVolunteer = $participation->getStall()->getNbVolunteer();
            $count = count($participation->getVolunteers()) + 1;
            for ($i = $count; $i <= $nbVolunteer; $i++) {
                $parent = array_shift($findVolunteers[$slot]);
                if ($parent !== null) {
                    $participation->addVolunteers($parent);
                }
            }
            $manager->persist($participation);
        }

        $manager->flush();
    }
}
