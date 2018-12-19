<?php
/**
 * Created by PhpStorm.
 * User: severine
 * Date: 17/07/18
 * Time: 21:36
 */

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class VolunteerAdmin extends AbstractAdmin
{

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('form.group.identity', ['class' => 'col-md-6'])
            ->add('name', TextType::class)
            ->add('email', EmailType::class)
            ->add('phone')
            ->end()
            ->with('form.group.availability', ['class' => 'col-md-6'])
            ->add('firstSlot')
            ->add('secondSlot')
            ->add('thirdSlot')
            ->add('prepare')
            ->add('tidy')
            ->end()
            ->with('form.group.extra', ['class' => 'col-md-6'])
            ->add('okSensitive')
            ->add('isSitting')
            ->end()
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('name', null, ['show_filter' =>true])
            ->add('firstSlot', null , ['show_filter' =>true])
            ->add('secondSlot', null, ['show_filter' =>true])
            ->add('thirdSlot', null, ['show_filter' =>true])
            ->add('prepare', null, ['show_filter' =>true])
            ->add('tidy', null, ['show_filter' =>true])
            ->add('okSensitive', null, ['show_filter' =>true])
            ->add('isSitting', null, ['show_filter' =>true])
        ;
    }

    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('name')
            ->add('email')
            ->add('phone')
            ->add('firstSlot')
            ->add('secondSlot')
            ->add('thirdSlot')
            ->add('prepare')
            ->add('tidy')
            ->add('okSensitive')
            ->add('isSitting')
            ;
    }
}
