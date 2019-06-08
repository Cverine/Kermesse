<?php
/**
 * Created by PhpStorm.
 * User: severine
 * Date: 27/09/18
 * Time: 22:11
 */

namespace App\Admin;

use App\Entity\Participation;
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
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ParticipationAdmin extends AbstractAdmin
{
    const SLOT1 = 1;
    const SLOT2 = 2;
    const SLOT3 = 3;
    const SLOT4 = 4;
    const SLOT5 = 5;

    protected $datagridValues = [
        '_sort_by' => 'stall'
    ];

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('stall', EntityType::class, [
                'class' => Stall::class,
                'choice_label'  => 'name'
            ])
            ->add('volunteers', ModelType::class, [
                'property' => 'name',
                'required' => false,
                'multiple' => true,
                'class' => Volunteer::class,
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
            ->add('manual')
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
            ->add('manual', null, ['show_filter' =>true])
            ;
    }

    public function getExportFields()
    {
        return [
            'Volontaires' => 'exportedVolunteers',
            'Stand' => 'stall',
            'Créneau' => 'slot'
        ];
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        $nbVolunteers = $object->getStall()->getNbVolunteer();
        if (count($object->getVolunteers()) > $nbVolunteers) {
            $errorElement
                ->with('volunteer')
                ->addViolation('Le nombre de volontaires dépasse le nombre prévu ( ' . $nbVolunteers . ' )')
                ->end();
        }

        foreach ($object->getVolunteers() as $volunteer) {
            if ($object->getSlot() === 1 && $volunteer->isFirstSlot() !== true) {
                $errorElement
                    ->with('volunteer')
                    ->addViolation($volunteer . ' n\'a pas choisi ce créneau')
                    ->end();
            }
            if ($object->getSlot() === 2 && $volunteer->isSecondSlot() !== true) {
                $errorElement
                    ->with('volunteer')
                    ->addViolation($volunteer . ' n\'a pas choisi ce créneau')
                    ->end();
            }
            if ($object->getSlot() === 3 && $volunteer->isThirdSlot() !== true) {
                $errorElement
                    ->with('volunteer')
                    ->addViolation($volunteer . ' n\'a pas choisi ce créneau')
                    ->end();
            }
            if ($this->isCurrentRoute('edit') === false) {
                $chosenSlot = $volunteer->getParticipations()->filter(function (Participation $participation) {
                    return $participation->getSlot() === 1;
                });

                if ($object->getSlot() === 1 && $chosenSlot->count() != 0) {
                    $errorElement
                        ->with('volunteer')
                        ->addViolation($volunteer . ' est déjà affecté(e) sur le créneau 1')
                        ->end();
                }

                $chosenSlot = $volunteer->getParticipations()->filter(function (Participation $participation) {
                    return $participation->getSlot() === 2;
                });
                if ($object->getSlot() === 2 && $chosenSlot->count() != 0) {
                    $errorElement
                        ->with('volunteer')
                        ->addViolation($volunteer . ' est déjà affecté(e) sur le créneau 2')
                        ->end();
                }
                $chosenSlot = $volunteer->getParticipations()->filter(function (Participation $participation) {
                    return $participation->getSlot() === 3;
                });
                if ($object->getSlot() === 3 && $chosenSlot->count() != 0) {
                    $errorElement
                        ->with('volunteer')
                        ->addViolation($volunteer . ' est déjà affecté(e) sur le créneau 3')
                        ->end();
                }
            }
        }


        parent::validate($errorElement, $object);
    }
}
