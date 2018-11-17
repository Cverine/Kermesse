<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class Stall
{
    const GRADE_MATERNELLE = 1;
    const GRADE_PRIMAIRE = 2;

    const SLOT1 = "First slot";
    const SLOT2 = "Second slot";
    const SLOT3 = "Third slot";
    const SLOT4 = "Prepare slot";
    const SLOT5 = "Tidy slot";


    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=255)

     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=255, nullable=true, options={"default" : "GRADE_PRIMAIRE"})
     */
    private $grade;

    /**
     * @var integer|null
     *
     * @ORM\Column(type="smallint", nullable=true)
     *
     */
    private $nbVolunteer;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    private $firstSlot;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    private $secondSlot;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    private $thirdSlot;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    private $prepare;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    private $tidy;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    private $isSensitive;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    private $isSitting;

    /**
     * @var Participation|null
     *
     * @ORM\OneToMany(targetEntity=Participation::class, mappedBy="stall")
     */
    private $participations;

    public function __construct()
    {
        $this->participations = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getGrade()
    {
        return $this->grade;
    }

    /**
     * @param mixed $grade
     */
    public function setGrade($grade): void
    {
        $this->grade = $grade;
    }

    /**
     * @return int|null
     */
    public function getNbVolunteer(): ?int
    {
        return $this->nbVolunteer;
    }

    /**
     * @param int|null $nbVolunteer
     */
    public function setNbVolunteer(?int $nbVolunteer): void
    {
        $this->nbVolunteer = $nbVolunteer;
    }

    /**
     * @return bool
     */
    public function isFirstSlot(): ?bool
    {
        return $this->firstSlot;
    }

    /**
     * @param bool $firstSlot
     */
    public function setFirstSlot(?bool $firstSlot): void
    {
        $this->firstSlot = $firstSlot;
    }

    /**
     * @return bool
     */
    public function isSecondSlot(): ?bool
    {
        return $this->secondSlot;
    }

    /**
     * @param bool $secondSlot
     */
    public function setSecondSlot(?bool $secondSlot): void
    {
        $this->secondSlot = $secondSlot;
    }

    /**
     * @return bool
     */
    public function isThirdSlot(): ?bool
    {
        return $this->thirdSlot;
    }

    /**
     * @param bool $thirdSlot
     */
    public function setThirdSlot(?bool $thirdSlot): void
    {
        $this->thirdSlot = $thirdSlot;
    }

    /**
     * @return bool
     */
    public function isPrepare(): ?bool
    {
        return $this->prepare;
    }

    /**
     * @param bool $prepare
     */
    public function setPrepare(?bool $prepare): void
    {
        $this->prepare = $prepare;
    }

    /**
     * @return bool
     */
    public function isTidy(): ?bool
    {
        return $this->tidy;
    }

    /**
     * @param bool $tidy
     */
    public function setTidy(?bool $tidy): void
    {
        $this->tidy = $tidy;
    }

    /**
     * @return bool
     */
    public function isSensitive(): ?bool
    {
        return $this->isSensitive;
    }

    /**
     * @param bool $isSensitive
     */
    public function setIsSensitive(?bool $isSensitive): void
    {
        $this->isSensitive = $isSensitive;
    }

    /**
     * @return bool
     */
    public function isSitting(): ?bool
    {
        return $this->isSitting;
    }

    /**
     * @param bool $isSitting
     */
    public function setIsSitting(?bool $isSitting): void
    {
        $this->isSitting = $isSitting;
    }

    /**
     * @return Participation|null
     */
    public function getParticipations(): ?Participation
    {
        return $this->participations;
    }

    /**
     * @param Participation|null $participations
     */
    public function setParticipations(?Participation $participations): void
    {
        $this->participations = $participations;
    }


    public function __toString(): ?string
    {
        return $this->getName() ?: '';
    }
}
