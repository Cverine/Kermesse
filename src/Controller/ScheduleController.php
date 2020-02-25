<?php

namespace App\Controller;

use App\Entity\Participation;
use App\Entity\Stall;
use App\Entity\Volunteer;
use App\Repository\VolunteerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;


class ScheduleController extends AbstractController
{
    private $em;
    private $volunteerRepository;

    public function __construct(EntityManagerInterface $em, VolunteerRepository $volunteerRepository)
    {
        $this->em = $em;
        $this->volunteerRepository = $volunteerRepository;
    }

    /**
     * @Route("/schedule", name="schedule")
     */
    public function index(Request $request)
    {
        $participations = $this->em->getRepository(Participation::class)->findAll();
        $vol1 = $this->volunteerRepository->findWithoutParticipationBySlot1();
        $vol2 = $this->volunteerRepository->findWithoutParticipationBySlot2();
        $vol3 = $this->volunteerRepository->findWithoutParticipationBySlot3();
        $volunteers = array_merge($vol1, $vol2, $vol3);
        $stalls = $this->em->getRepository(Stall::class)->findAll();

        if ($request->isXmlHttpRequest()) {
            var_dump(new JsonResponse([], 201));
            var_dump('phhp');die;
        }

        return $this->render('schedule/schedule.html.twig', [
            'participations' => $participations,
            'volunteers' => $volunteers,
            'stalls' => $stalls,
            'vol1' => $vol1,
            'vol2' => $vol2,
            'vol3' => $vol3,
        ]);
    }
}
