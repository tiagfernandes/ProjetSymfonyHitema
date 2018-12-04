<?php
/**
 * Created by PhpStorm.
 * User: tiago
 * Date: 03/12/2018
 * Time: 21:49
 */
namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class CreditCard
{
    /**
     * @Assert\Length(min=16)
     */
    private $number;
    private $dateExpired;
    /**
     * @Assert\Length(min=3)
     */
    private $cryptogram;
    private $name;

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param mixed $number
     */
    public function setNumber($number): void
    {
        $this->number = $number;
    }

    /**
     * @return mixed
     */
    public function getDateExpired()
    {
        return $this->dateExpired;
    }

    /**
     * @param mixed $dateExpired
     */
    public function setDateExpired($dateExpired): void
    {
        $this->dateExpired = $dateExpired;
    }

    /**
     * @return mixed
     */
    public function getCryptogram()
    {
        return $this->cryptogram;
    }

    /**
     * @param mixed $cryptogram
     */
    public function setCryptogram($cryptogram): void
    {
        $this->cryptogram = $cryptogram;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }


}