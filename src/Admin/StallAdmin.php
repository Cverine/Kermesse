<?php
/**
 * Created by PhpStorm.
 * User: severine
 * Date: 25/07/18
 * Time: 22:19
 */

namespace App\Admin;


use App\Entity\Participation;
use App\Entity\Stall;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Form\Type\CollectionType;
use Sonata\CoreBundle\Validator\ErrorElement;
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
                    5 => 5,
                    6 => 6,
                    7 => 7,
                    8 => 8,
                    9 => 9,
                    10 => 10,
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
            ->add('grade', null, ['show_filter' =>true ], ChoiceType::class, [
                'choices' => [
                    'Maternelle' => Stall::GRADE_MATERNELLE,
                    'Primaire' => Stall::GRADE_PRIMAIRE
                ]
            ])
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
            ->addIdentifier('name')
            ->add('grade', 'choice', [
                'choices'   => [
                    1 => "Maternelle",
                    2 => "Elémentaire"
                ]
            ])
            ->add('nbVolunteer', 'text', [
                'row_align' => 'left'
            ])
            ->add('firstSlot')
            ->add('secondSlot')
            ->add('thirdSlot')
            ->add('isSitting')
            ->add('_action', null, [
                'actions' => [
                    'edit' => [],
                    'delete' => [],
                ]
            ])
        ;
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        foreach ($object->getParticipations() as $participation) {
            $existingParticipation = $this->modelManager->findBy(Participation::class, [
                'stall' => $participation->getStall(),
                'slot' => $participation->getSlot()
            ]);
            if (!empty($existingParticipation)) {
                $errorElement
                    ->with('participations')
                    ->addViolation('Il existe déjà des affectations sur le stand ' . $participation->getStall() . ' et le créneau '
                        . $participation->getSlot() . '. Pour y ajouter une affectation, vous devez passer par la page Affectations.')
                    ->end();
            }
        }
    }

    protected function configureBatchActions($actions)
    {
        $actions['match'] = [
            'label' => 'batch.action.dispatch',
            'ask_confirmation' => true
        ];

        return $actions;
    }
}
