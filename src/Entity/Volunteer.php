<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @Assert\Regex(
     *    pattern="/\d/",
     *    match=false,
     *    message="Il ne peut pas y avoir de nombre dans le nom"
     * )
     */
    private $name;

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
     * @var Participation[]|null
     *
     * @ORM\ManyToMany(targetEntity=Participation::class, mappedBy="volunteers")
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
     * @param string $name|null
     */
    public function setName(string $name): void
    {
        $this->name = $name;
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
     * @return Collection|Participation[]|null
     */
    public function getParticipations(): ?Collection
    {
        return $this->participations;
    }

    /**
     * @param Participation $participation
     */
    public function addParticipations(Participation $participation)
    {
        if ($this->participations->contains($participation)) {
            return;
        }
        $this->participations->add($participation);

    }

    /**
     * @param Participation $participation
     */
    public function removeParticipations(Participation $participation)
    {
        if (!$this->participations->contains($participation)) {
            return;
        }
        $this->participations->removeElement($participation);
    }

    public function __toString()
    {
        return $this->name;
    }
}

