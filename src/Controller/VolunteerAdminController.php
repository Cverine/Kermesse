<?php
/**
 * Created by PhpStorm.
 * User: severine
 * Date: 19/12/18
 * Time: 10:12
 */

namespace App\Controller;

use Sonata\AdminBundle\Controller\CRUDController as BaseController;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Symfony\Component\HttpFoundation\Request;


class VolunteerAdminController extends BaseController
{
    public function batchActionEmail(ProxyQueryInterface $selectedModelQuery, Request $request = null)
    {
        $volunteers = $selectedModelQuery->execute();


    }
}