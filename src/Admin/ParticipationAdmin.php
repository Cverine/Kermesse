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
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ChoiceFieldMaskType;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ParticipationAdmin extends AbstractAdmin
{
    const SLOT1 = 1;
    const SLOT2 = 2;
    const SLOT3 = 3;
    const SLOT4 = 4;
    const SLOT5 = 5;


    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('stall', EntityType::class, [
                'class' => Stall::class,
                'choice_label'  => 'name'
            ])
            ->add('volunteers', ModelType::class, [
                'property' => 'name',
                'label' => 'volontaire',
                'required' => false,
                'multiple' => true,
                'class' => Volunteer::class,
                'translation_domain' => 'SonataUserBundle'
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
            ->add('volunteers')
            ->add('stall')
            ->add('slot')
            ->add('missingVolunteers')
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
            ->add('id')
            ->add('stall')
            ->add('volunteers')
            ->add('slot')
            ;
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('stall', null, ['show_filter' =>true])
            ->add('volunteers', null, ['show_filter' =>true])
            ->add('slot', null, ['show_filter' =>true])
        ;
    }

    public function getExportFields()
    {
        return [
            'volunteers' => 'exportedVolunteers',
            'stall' => 'stall',
            'slot' => 'slot'
        ];
    }

}
