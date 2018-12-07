<?php
/**
 * Created by PhpStorm.
 * User: severine
 * Date: 16/11/18
 * Time: 19:34
 */

namespace App\Service;

use App\Entity\Participation;
use App\Repository\ParticipationRepository;
use App\Repository\StallRepository;
use App\Repository\VolunteerRepository;
use Doctrine\ORM\EntityManagerInterface;

class ParticipationGenerator
{
    const SLOT1 = 1;
    const SLOT2 = 2;
    const SLOT3 = 3;
    const SLOT4 = 4;
    const SLOT5 = 5;

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
     * @param $stall
     */
    public function initializeParticipations($stall)
    {
        $manager = $this->manager;
        $prepareVolunteers = $this->volunteerRepository->findByPrepare();
        $tidyVolunteers = $this->volunteerRepository->findByTidy();

        if ($stall->isPrepare() === true) {
            $prepare = $this->participationRepository->findBy([
                'slot' => 4
            ]);
            if (empty($prepare)) {
                $participation = new Participation();
                $participation->setStall($stall);
                $participation->setSlot(4);
                foreach ($prepareVolunteers as $parent) {
                    $participation->addVolunteers($parent);
                }
                $manager->persist($participation);
            }
        }

        if ($stall->isTidy() === true) {
            $tidy = $this->participationRepository->findBy([
                'slot' => 5
            ]);
            if (empty($tidy)) {
                $participation = new Participation();
                $participation->setStall($stall);
                $participation->setSlot(5);
                foreach ($tidyVolunteers as $parent) {
                    $participation->addVolunteers($parent);
                }
                $manager->persist($participation);
            }
        }

        if ($stall->isFirstSlot() === true) {
            $exist = $this->participationRepository->findBy([
                'stall' => $stall,
                'slot' => 1
            ]);
            if (empty($exist)) {
                $participation = new Participation();
                $participation->setStall($stall);
                $participation->setSlot(1);
                $manager->persist($participation);
            }
        }

        if ($stall->isSecondSlot() === true) {
            $exist = $this->participationRepository->findBy([
                'stall' => $stall,
                'slot' => 2
            ]);
            if (empty($exist)) {
                $participation = new Participation();
                $participation->setStall($stall);
                $participation->setSlot(2);
                $manager->persist($participation);
            }
        }

        if ($stall->isThirdSlot() === true) {
            $exist = $this->participationRepository->findBy([
                'stall' => $stall,
                'slot' => 3
            ]);
            if (empty($exist)) {
                $participation = new Participation();
                $participation->setStall($stall);
                $participation->setSlot(3);
                $manager->persist($participation);
            }
        }
        $manager->flush();
    }

    public function dispatchVolunteers()
    {
        $manager = $this->manager;

        $firstSlotParticipations = $this->participationRepository->findByFirstSlot();
        $secondSlotParticipations = $this->participationRepository->findBySecondSlot();
        $thirdSlotParticipations = $this->participationRepository->findByThirdSlot();
        $sittingParticipations = $this->participationRepository->findBySit();


/*        $slotVolunteers = $this->volunteerRepository->findBySit(); TODO finaliser les sitting priorities
        foreach ($sittingParticipations as $participation) {
            $nbVolunteer = $participation->getStall()->getNbVolunteer();

            $manager->persist($participation);
        }*/
        $slotVolunteers = $this->volunteerRepository->findByFirstSlot();
        foreach ($firstSlotParticipations as $participation) {
            $nbVolunteer = $participation->getStall()->getNbVolunteer();
            $count = count($participation->getVolunteers()) + 1;
            for ($i = $count; $i <= $nbVolunteer; $i++) {
                $parent = array_shift($slotVolunteers);
                if ($parent !== null) {
                    $participation->addVolunteers($parent);
                }
            }
            $manager->persist($participation);
        }

        $slotVolunteers = $this->volunteerRepository->findBySecondSlot();
        foreach ($secondSlotParticipations as $participation) {
            $nbVolunteer = $participation->getStall()->getNbVolunteer();
            $count = count($participation->getVolunteers()) + 1;

            for ($i = $count; $i <= $nbVolunteer; $i++) {
                $parent = array_shift($slotVolunteers);
                if ($parent !== null) {
                    $participation->addVolunteers($parent);
                }
            }
            $manager->persist($participation);
        }

        $slotVolunteers = $this->volunteerRepository->findByThirdSlot();
        foreach ($thirdSlotParticipations as $participation) {
            $nbVolunteer = $participation->getStall()->getNbVolunteer();
            $count = count($participation->getVolunteers()) + 1;

            for ($i = $count; $i <= $nbVolunteer; $i++) {
                $parent = array_shift($slotVolunteers);
                if ($parent !== null) {
                    $participation->addVolunteers($parent);
                }
            }
            $manager->persist($participation);
        }
        $manager->flush();
    }

}
