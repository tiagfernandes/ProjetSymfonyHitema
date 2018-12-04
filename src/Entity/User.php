<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Captcha\Bundle\CaptchaBundle\Validator\Constraints as CaptchaAssert;
use Symfony\Component\Validator\Context\ExecutionContext;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity("username")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dtCreated;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dtUpdate;

    /**
     * @OneToMany(targetEntity="App\Entity\Purchase", mappedBy="user")
     */
    private $purchases;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dtBorn;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $roles;

    /**
     * @CaptchaAssert\ValidCaptcha(
     *      message = "CAPTCHA validation failed, try again."
     * )
     */
    protected $captchaCode;

    /** @var string|null
     * @Assert\Type("string")
     * @Assert\Length(min=5)
     */
    private $rawPassword;

    public function __construct()
    {
        $this->dtCreated = new \DateTime();
        $this->purchases = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getDtCreated(): ?\DateTimeInterface
    {
        return $this->dtCreated;
    }

    public function setDtCreated(\DateTimeInterface $dtCreated): self
    {
        $this->dtCreated = $dtCreated;

        return $this;
    }

    public function getDtUpdate(): ?\DateTimeInterface
    {
        return $this->dtUpdate;
    }

    public function setDtUpdate(\DateTimeInterface $dtUpdate): self
    {
        $this->dtUpdate = $dtUpdate;

        return $this;
    }

    public function addPurchase(Purchase $purchases): self
    {
        if (!$this->purchases->contains($purchases)) {
            $this->purchases->add($purchases);
        }
        return $this;
    }

    public function removePurchase(Purchase $purchases): self
    {
        if ($this->purchases->contains($purchases)) {
            $this->purchases->removeElement($purchases);
        }
        return $this;
    }

    public function getPurchases()
    {
        return $this->purchases;
    }

    public function getDtBorn(): ?\DateTimeInterface
    {
        return $this->dtBorn;
    }

    public function setDtBorn(\DateTimeInterface $dtBorn): self
    {
        $this->dtBorn = $dtBorn;

        return $this;
    }

    public function setRoles(string $role)
    {
        $this->roles = $role;
    }

    public function getRoles()
    {
        return [$this->roles];
    }

    public function getSalt()
    {
        return null;
    }

    /**
     * @return null|string
     */
    public function getRawPassword(): ?string
    {
        return $this->rawPassword;
    }

    /**
     * @param null|string $rawPassword
     */
    public function setRawPassword(?string $rawPassword): void
    {
        $this->rawPassword = $rawPassword;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }



    public function eraseCredentials()
    {
        $this->rawPassword = null;
    }

    /**
     * @ORM\PreUpdate
     * @ORM\PrePersist
     */
    public function setDateUpdate()
    {
        $this->setDtUpdate(new \DateTime());
    }

    public function getAge()
    {
        $date = $this->getDtBorn();
        $now = new DateTime();
        $interval = $now->diff($date);
        return $interval->y;
    }

    public function getCaptchaCode()
    {
        return $this->captchaCode;
    }

    public function setCaptchaCode($captchaCode)
    {
        $this->captchaCode = $captchaCode;
    }

    /**
     * @Assert\Callback()
     */
    public function assertIsValid(ExecutionContext $context)
    {
        if (null === $this->getId() && null === $this->getRawPassword()) {
            $context
                ->buildViolation('Vous devez définir un mot de passe')
                ->atPath('rawPassword')
                ->addViolation()
            ;
        }
    }
}
