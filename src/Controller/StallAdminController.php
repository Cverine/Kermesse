<?php

namespace App\Controller;

use App\Service\ParticipationGenerator;
use Sonata\AdminBundle\Controller\CRUDController as BaseController;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class StallAdminController extends BaseController
{
    private $generator;

    public function __construct(ParticipationGenerator $generator)
    {
        $this->generator = $generator;
    }

    /**
     * @param ProxyQueryInterface $selectedModelQuery
     *
     * @return RedirectResponse
     */
    public function batchActionMatch(ProxyQueryInterface $selectedModelQuery)
    {
        $stalls = $selectedModelQuery->execute();
        $generator = $this->generator;

        foreach ($stalls as $stall) {
            $generator->initializeParticipations($stall);
            $generator->dispatchVolunteers();
        }

        return new RedirectResponse($this->generateUrl('admin_app_participation_list'));
    }
}
