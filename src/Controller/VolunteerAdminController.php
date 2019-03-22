<?php
/**
 * Created by PhpStorm.
 * User: severine
 * Date: 19/12/18
 * Time: 10:12
 */

namespace App\Controller;

use App\Service\EmailService;
use Sonata\AdminBundle\Controller\CRUDController as BaseController;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;


class VolunteerAdminController extends BaseController
{
    private $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    /**
     * @param ProxyQueryInterface $selectedModelQuery
     *
     * @return RedirectResponse
     */
    public function batchActionEmail(ProxyQueryInterface $selectedModelQuery)
    {
        $volunteers = $selectedModelQuery->execute();

        foreach ($volunteers as $volunteer) {
            $message = [
                'name' => $volunteer->getName(),
                'participations' => $volunteer->getParticipations(),
                'to' => $volunteer->getEmail()
            ];

            $this->emailService->sendParticipationEmail($message);
        }

        $this->addFlash(
            'notice',
            'Les emails ont bien été envoyés !!'
        );

        return new RedirectResponse($this->generateUrl('admin_app_volunteer_list'));
    }
}