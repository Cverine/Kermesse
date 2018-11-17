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
    const SLOT1 = "First slot";
    const SLOT2 = "Second slot";
    const SLOT3 = "Third slot";
    const SLOT4 = "Prepare slot";
    const SLOT5 = "Tidy slot";

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
                    $participation->addListVolunteers($parent);
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
                    $participation->addListVolunteers($parent);
                    $manager->persist($participation);
                }
            }
        }

        if ($stall->isFirstSlot() === true) {
            $exist = $this->participationRepository->findBy([
                'stall' => $stall,
                'slot' => "First slot"
            ]);
            for ($i = count($exist) + 1; $i <= $stall->getNbVolunteer(); $i++) {
                $participation = new Participation();
                $participation->setStall($stall);
                $participation->setSlot(1);
                $manager->persist($participation);
            }
        }

        if ($stall->isSecondSlot() === true) {
            $exist = $this->participationRepository->findBy([
                'stall' => $stall,
                'slot' => "Second slot"
            ]);
            for ($i = count($exist) + 1; $i <= $stall->getNbVolunteer(); $i++) {
                $participation = new Participation();
                $participation->setStall($stall);
                $participation->setSlot(2);
                $manager->persist($participation);
            }
        }

        if ($stall->isThirdSlot() === true) {
            $exist = $this->participationRepository->findBy([
                'stall' => $stall,
                'slot' => "Third slot"
            ]);
            for ($i = count($exist) + 1; $i <= $stall->getNbVolunteer(); $i++) {
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

        $firstSlotVolunteers = $this->volunteerRepository->findByFirstSlot();
        $secondSlotVolunteers = $this->volunteerRepository->findBySecondSlot();
        $thirdSlotVolunteers = $this->volunteerRepository->findByThirdSlot();
        $sittingVolunteers = $this->volunteerRepository->findBySit();

        $firstSlotParticipations = $this->participationRepository->findByFirstSlot();
        $secondSlotParticipations = $this->participationRepository->findBySecondSlot();
        $thirdSlotParticipations = $this->participationRepository->findByThirdSlot();
        $sittingParticipations = $this->participationRepository->findBySit();

        foreach ($sittingParticipations as $participation) {
            if ($participation->getVolunteer() === null) {
                $parent = array_shift($sittingVolunteers);
                $participation->setVolunteer($parent);
                $manager->persist($participation);
            }
        }
        foreach ($firstSlotParticipations as $participation) {
            if ($participation->getVolunteer() === null) {
                $parent = array_shift($firstSlotVolunteers);
                $participation->setVolunteer($parent);
                $manager->persist($participation);
            }
        }
        foreach ($secondSlotParticipations as $participation) {
            if ($participation->getVolunteer() === null) {
                $parent = array_shift($secondSlotVolunteers);
                $participation->setVolunteer($parent);
                $manager->persist($participation);
            }
        }
        foreach ($thirdSlotParticipations as $participation) {
            if ($participation->getVolunteer() === null) {
                $parent = array_shift($thirdSlotVolunteers);
                $participation->setVolunteer($parent);
                $manager->persist($participation);
            }
        }
        $manager->flush();
    }
}
