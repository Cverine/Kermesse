<?php
/**
 * Created by PhpStorm.
 * User: severine
 * Date: 03/10/18
 * Time: 21:38
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TestController extends Controller
{
    public function jeFaisUnTruc()
    {
        $this->container->get('admin.volunteer');
    }
}