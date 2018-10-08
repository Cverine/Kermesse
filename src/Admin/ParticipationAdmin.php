<?php
/**
 * Created by PhpStorm.
 * User: severine
 * Date: 27/09/18
 * Time: 22:11
 */

namespace App\Admin;

use App\Entity\Stall;
use App\Entity\Volunteer;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ParticipationAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('stall', EntityType::class, [
                'class' => Stall::class,
                'choice_label'  => 'name'
            ])
            ->add('volunteer', EntityType::class, [
                'class' => Volunteer::class,
                'choice_label' => 'lastName'
            ])
            ->add('slot')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('stall')
            ->addIdentifier('volunteer')
            ->addIdentifier('slot')
        ;
    }
}