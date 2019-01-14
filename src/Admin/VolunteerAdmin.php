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
use Sonata\AdminBundle\Form\Type\AdminType;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Form\Type\CollectionType;
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
            ->with('form.group.participations', ['class' => 'col-md-6'])
                ->add('participations', CollectionType::class, [], [
                        'edit' => 'inline',
                        'inline' => 'table'
                    ]
                )
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
            ->add('_action', null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ]
            ]);
            ;
    }

    protected function configureShowFields(ShowMapper $show)
    {
        $show
            ->with('show.group.identity', ['class' => 'col-md-6'])
                ->add('name')
                ->add('email')
                ->add('phone')
            ->end()
            ->with('show.group.availability', ['class' => 'col-md-6'])
                ->add('firstSlot')
                ->add('secondSlot')
                ->add('thirdSlot')
                ->add('prepare')
                ->add('tidy')
            ->end()
            ->with('show.group.extra', ['class' => 'col-md-6'])
                ->add('okSensitive')
                ->add('isSitting')
            ->end()
            ->with('show.group.participations', ['class' => 'col-md-6'])
                ->add('participations')
            ->end()
            ;
    }

    public function configureBatchActions($actions)
    {
        $actions['email'] = [
            'label' => 'batch.action.email',
            'ask_confirmation' => true
        ];

        return $actions;
    }
}
