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
     * @ORM\ManyToMany(targetEntity=Volunteer::class, inversedBy="participations")
     */
    private $volunteers;

    /**
     * @var Stall|null
     *
     * @ORM\ManyToOne(targetEntity=Stall::class, inversedBy="participations")
     */
    private $stall;

    public function __construct()
    {
        $this->volunteers = new \Doctrine\Common\Collections\ArrayCollection();
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
}
