<?php
/**
 * Created by PhpStorm.
 * User: severine
 * Date: 11/07/18
 * Time: 22:01
 */

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Participation
 * @ORM\Entity
 */
class Participation
{
    const SLOT1 = "First slot";
    const SLOT2 = "Second slot";
    const SLOT3 = "Third slot";
    const SLOT4 = "Prepare slot";
    const SLOT5 = "Tidy slot";

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
     * @ORM\ManyToMany(targetEntity=Volunteer::class)
     */
    private $listVolunteers;

    /**
     * @var Volunteer|null
     *
     * @ORM\ManyToOne(targetEntity=Volunteer::class, inversedBy="participations")
     */
    private $volunteer;

    /**
     * @var Stall|null
     *
     * @ORM\ManyToOne(targetEntity=Stall::class, inversedBy="participations")
     */
    private $stall;

    public function __construct()
    {
        $this->listVolunteers = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Volunteer|null
     */
    public function getVolunteer(): ?Volunteer
    {
        return $this->volunteer;
    }

    /**
     * @param Volunteer|null $volunteer
     */
    public function setVolunteer(?Volunteer $volunteer): void
    {
        $this->volunteer = $volunteer;
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
    public function getListVolunteers(): ?Collection
    {
        return $this->listVolunteers;
    }

    /**
     * @param Volunteer $volunteer
     */
    public function addListVolunteers(Volunteer $volunteer)
    {
        if ($this->listVolunteers->contains($volunteer)) {
            return;
        }
        $this->listVolunteers->add($volunteer);

    }

    /**
     * @param Volunteer $volunteer
     */
    public function removeListVolunteers(Volunteer $volunteer)
    {
        if (!$this->listVolunteers->contains($volunteer)) {
            return;
        }
        $this->listVolunteers->removeElement($volunteer);
    }
}
