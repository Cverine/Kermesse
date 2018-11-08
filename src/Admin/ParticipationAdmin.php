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
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ChoiceFieldMaskType;
use Sonata\AdminBundle\Form\Type\Filter\ChoiceType;
use Sonata\AdminBundle\Form\Type\ModelType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ParticipationAdmin extends AbstractAdmin
{
    const SLOT1 = "First slot";
    const SLOT2 = "Second slot";
    const SLOT3 = "Third slot";
    const SLOT4 = "Prepare slot";
    const SLOT5 = "Tidy slot";


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
            ->add('slot', ChoiceFieldMaskType::class, [
                'multiple' => false,
                'expanded' => false,
                'choices' => [
                    'First slot' => self::SLOT1,
                    'Second slot' => self::SLOT2,
                    'Third slot' => self::SLOT3,
                    'Prepare slot' => self::SLOT4,
                    'Tidy slot' => self::SLOT5,
                ]
            ]);
    }

    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('volunteer')
            ->add('stall')
            ->add('slot')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('volunteer', null, ['show_filter' =>true])
            ->add('stall', null, ['show_filter' =>true])
        ;
    }

    protected function configureBatchActions($actions)
    {

            $actions['match'] = [
                'ask_confirmation' => true
            ];

        return $actions;
    }
}