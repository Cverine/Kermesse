<?php
/**
 * Created by PhpStorm.
 * User: severine
 * Date: 17/07/18
 * Time: 21:36
 */

namespace App\Admin;

use App\Entity\Participation;
use App\Entity\Volunteer;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Form\Type\CollectionType;
use Sonata\CoreBundle\Validator\ErrorElement;
use Sonata\DoctrineORMAdminBundle\Filter\CallbackFilter;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
                ->setHelps([
                    'phone' => 'Format: 0X12345678'
                ])
            ->end()
            ->with('form.group.availability', ['class' => 'col-md-6'])
                ->add('firstSlot')
                ->add('secondSlot')
                ->add('thirdSlot')
                ->add('prepare')
                ->add('tidy')
            ->end()
            ->with('form.group.extra', ['class' => 'col-md-6'])
                ->add('grade', ChoiceType::class, [
                'choices' => [
                    'Maternelle' => Volunteer::GRADE_MATERNELLE,
                    'Primaire' => Volunteer::GRADE_PRIMAIRE
                ]
            ])
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
            ->add('grade', null, ['show_filter' =>true ], ChoiceType::class, [
                'choices' => [
                    'Maternelle' => Volunteer::GRADE_MATERNELLE,
                    'Primaire' => Volunteer::GRADE_PRIMAIRE
                ]
            ])
            ->add('firstSlot', null , ['show_filter' =>true])
            ->add('secondSlot', null, ['show_filter' =>true])
            ->add('thirdSlot', null, ['show_filter' =>true])
            ->add('prepare', null, ['show_filter' =>true])
            ->add('tidy', null, ['show_filter' =>true])
            ->add('okSensitive', null, ['show_filter' =>true])
            ->add('isSitting', null, ['show_filter' =>true])
            ->add('participations', CallbackFilter::class, [
                    'callback' => [$this, 'getWithoutParticipationFilter'],
                    'field_type' => CheckboxType::class,
                    'show_filter' =>true
              ])
        ;
    }

    public function getWithoutParticipationFilter($queryBuilder, $alias, $field, $value)
    {
        if (!$value['value']) {
            return;
        }
        $queryBuilder
            ->leftJoin($alias. '.participations', 'p')
            ->andWhere($queryBuilder->expr()->isNull('p'))
        ;

        return true;
    }

    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('name')
            ->add('email')
            ->add('grade')
            ->add('firstSlot')
            ->add('secondSlot')
            ->add('thirdSlot')
            ->add('prepare')
            ->add('tidy')
            ->add('isSitting')
            ->add('participations')
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
                ->add('grade')
                ->add('okSensitive')
                ->add('isSitting')
            ->end()
            ->with('show.group.participations', ['class' => 'col-md-6'])
                ->add('participations')
            ->end()
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

    public function configureBatchActions($actions)
    {
        $actions['email'] = [
            'label' => 'batch.action.email',
            'ask_confirmation' => true
        ];

        return $actions;
    }
}
