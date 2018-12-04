<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PurchaseRepository")
 */
class Purchase
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ManyToOne(targetEntity="App\Entity\Video", inversedBy="purchases")
     * @JoinColumn(name="video_id", referencedColumnName="id")
     */
    private $video;

    /**
     * @ManyToOne(targetEntity="App\Entity\User", inversedBy="purchases")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPaid;


    /**
     * @ORM\Column(type="datetime")
     */
    private $dtPaid;

    /**
     * Purchase constructor.
     * @param $isPaid
     */
    public function __construct()
    {
        $this->isPaid = false;
        $this->dtPaid = new \DateTime();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVideo()
    {
        return $this->video;
    }

    public function setVideo(Video $video)
    {
        $this->video = $video;

        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIsPaid()
    {
        return $this->isPaid;
    }

    /**
     * @param mixed $isPaid
     */
    public function setIsPaid($isPaid): void
    {
        $this->isPaid = $isPaid;
    }

    /**
     * @return mixed
     */
    public function getDtPaid()
    {
        return $this->dtPaid;
    }

    /**
     * @param mixed $dtPaid
     */
    public function setDtPaid($dtPaid): void
    {
        $this->dtPaid = $dtPaid;
    }



}
