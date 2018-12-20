<?php
/**
 * Created by PhpStorm.
 * User: severine
 * Date: 11/07/18
 * Time: 22:01
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Participation
 * @ORM\Entity
 * @UniqueEntity(
 *     fields={"slot", "stall"},
 *     errorPath="slot",
 *     message="Ce créneau existe déjà pour ce stand"
 * )

 */
class Participation
{
    const SLOT1 = 1;
    const SLOT2 = 2;
    const SLOT3 = 3;
    const SLOT4 = 4;
    const SLOT5 = 5;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=255)
     *
     */
    private $slot;

    /**
     * @var Volunteer[]|null
     *
     * @ORM\ManyToMany(targetEntity=Volunteer::class, inversedBy="participations")
     *
     */
    private $volunteers;

    /**
     * @var Stall|null
     *
     * @ORM\ManyToOne(targetEntity=Stall::class, inversedBy="participations")
     */
    private $stall;

    protected $exportedVolunteers;

    public function __construct()
    {
        $this->volunteers = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getSlot(): ?string
    {
        return $this->slot;
    }

    /**
     * @param null|string $slot
     */
    public function setSlot(?string $slot): void
    {
        $this->slot = $slot;
    }

    /**
     * @return Stall|null
     */
    public function getStall(): ?Stall
    {
        return $this->stall;
    }

    /**
     * @param Stall|null $stall
     */
    public function setStall(?Stall $stall): void
    {
        $this->stall = $stall;
    }

    /**
     * @return Collection|Volunteer[]|null
     */
    public function getVolunteers(): ?Collection
    {
        return $this->volunteers;
    }

    /**
     * @param Volunteer $volunteer
     */
    public function addVolunteers(Volunteer $volunteer)
    {
        if ($this->volunteers->contains($volunteer)) {
            return;
        }
        $this->volunteers->add($volunteer);

    }

    /**
     * @param Volunteer $volunteer
     */
    public function removeVolunteers(Volunteer $volunteer)
    {
        if (!$this->volunteers->contains($volunteer)) {
            return;
        }
        $this->volunteers->removeElement($volunteer);
    }

    /**
     * @return int|null
     */
    public function getMissingVolunteers()
    {
        $registered = count($this->getVolunteers());
        $wanted = $this->getStall()->getNbVolunteer();
        $missing = $wanted - $registered;
        if ($missing > 0) {
            return $missing;
        } else {
            return 0;
        }
    }

    /**
     * @return string
     */
    public function getExportedVolunteers()
    {
        $exportedVolunteers = [];
        $i = 1;
        foreach ($this->getVolunteers() as $key => $volunteer) {
            $exportedVolunteers[] = /*$i .
                ') ' . */$volunteer->getName();
        $i++;
    }
        return $this->exportedVolunteers = join(', ', $exportedVolunteers);
    }

    /**
     * @param ExecutionContextInterface $context
     * @param $payload
     *
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context, $payload)
    {
        $nbVolunteers = $this->getStall()->getNbVolunteer();
        if (count($this->getVolunteers()) > $nbVolunteers ) {
            $context->buildViolation('Le nombre de volontaires dépasse le nombre prévu ( ' . $nbVolunteers . ' )' )
                ->atPath('volunteers')
                ->addViolation();
        }
    }

    public function __toString()
    {
        return $this->stall->getName() . '-' . $this->slot;
    }
}
