<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class Volunteer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     *
     * @Assert\NotBlank()
     */
    private $firstName;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     *
     * @Assert\NotBlank()
     */
    private $lastName;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Assert\Email()
     */
    private $email;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=10, nullable=true)
     *
     * @Assert\Length(min=10, max=10)
     */
    private $phone;

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
    private $okSensitive;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    private $isSitting;

    /**
     * @var Participation|null
     *
     * @ORM\OneToMany(targetEntity=Participation::class, mappedBy="volunteer")
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
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName|null
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName|null
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
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
    public function setFirstSlot(bool $firstSlot): void
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
    public function setSecondSlot(bool $secondSlot): void
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
    public function setThirdSlot(bool $thirdSlot): void
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
    public function setPrepare(bool $prepare): void
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
    public function setTidy(bool $tidy): void
    {
        $this->tidy = $tidy;
    }

    /**
     * @return bool
     */
    public function isOkSensitive(): ?bool
    {
        return $this->okSensitive;
    }

    /**
     * @param bool $okSensitive
     */
    public function setOkSensitive(bool $okSensitive): void
    {
        $this->okSensitive = $okSensitive;
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
    public function setIsSitting(bool $isSitting): void
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

    public function __toString()
    {
        return $this->firstName . " " . $this->lastName;
    }
}

