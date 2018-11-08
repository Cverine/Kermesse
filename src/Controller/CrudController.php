<?php


namespace App\Controller;

use App\Repository\ParticipationRepository;
use App\Repository\StallRepository;
use App\Repository\VolunteerRepository;
use Sonata\AdminBundle\Controller\CRUDController as BaseController;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Symfony\Component\HttpFoundation\Request;

class ParticipationAdminController extends BaseController
{
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

    public function __construct(
        VolunteerRepository $volunteerRepository,
        StallRepository $stallRepository,
        ParticipationRepository $participationRepository)
    {
        $this->volunteerRepository = $volunteerRepository;
        $this->stallRepository = $stallRepository;
        $this->participationRepository = $participationRepository;
    }

    public function batchActionMatch(ProxyQueryInterface $selectedModelQuery, Request $request = null)
    {
        $volunteers = $this->volunteerRepository->findAll();
        $stall = $this->stallRepository->findAll();
dump($volunteers);
dump($stall);die;

    }

}