<?php
/**
 * Created by PhpStorm.
 * User: severine
 * Date: 25/07/18
 * Time: 22:19
 */

namespace App\Admin;


use App\Entity\Stall;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class StallAdmin extends AbstractAdmin
{

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('form.group.general_info', ['class' => 'col-md-6'])
            ->add('name')
            ->add('grade', ChoiceType::class, [
                'choices' => [
                    'Maternelle' => Stall::GRADE_MATERNELLE,
                    'Primaire' => Stall::GRADE_PRIMAIRE
                ]
            ])
            ->add('nbVolunteer', ChoiceType::class, [
                'choices' => [
                    1 => 1,
                    2 => 2,
                    3 => 3,
                    4 => 4,
                    100 => 100
                ]
            ])
            ->end()
            ->with('form.group.schedule', ['class' => 'col-md-6'])
            ->add('firstSlot', null, ['data' => true])
            ->add('secondSlot', null, ['data' => true])
            ->add('thirdSlot', null, ['data' => true])
            ->add('prepare')
            ->add('tidy')
            ->end()
            ->with('form.group.extra', ['class' => 'col-md-6'])
            ->add('isSensitive')
            ->add('isSitting')
            ->end()
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('name', null, ['show_filter' =>true])
            ->add('grade', null, ['show_filter' =>true])
            ->add('firstSlot', null , ['show_filter' =>true])
            ->add('secondSlot', null, ['show_filter' =>true])
            ->add('thirdSlot', null, ['show_filter' =>true])
            ->add('prepare', null, ['show_filter' =>true])
            ->add('tidy', null, ['show_filter' =>true])
            ->add('isSensitive', null, ['show_filter' =>true])
            ->add('isSitting', null, ['show_filter' =>true])
        ;
    }

    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('id')
            ->addIdentifier('name')
            ->add('grade')
            ->add('nbVolunteer')
            ->add('firstSlot')
            ->add('secondSlot')
            ->add('thirdSlot')
            ->add('prepare')
            ->add('tidy')
            ->add('isSensitive')
            ->add('isSitting')
        ;
    }

    protected function configureBatchActions($actions)
    {
        $actions['match'] = [
            'label' => 'Répartir les parents',
            'ask_confirmation' => true
        ];

        return $actions;
    }
}
