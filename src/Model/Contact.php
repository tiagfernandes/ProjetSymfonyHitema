<?php
/**
 * Created by PhpStorm.
 * User: tiago
 * Date: 04/12/2018
 * Time: 11:42
 */

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class Contact
{
    /**
     * @Assert\NotNull()
     * @Assert\Type("string")
     * @Assert\Length(min=2, max=255)
     */
    private $name;
    /**
     * @Assert\NotNull()
     * @Assert\Email(checkHost=true, checkMX=true)
     */
    private $email;
    /**
     * @Assert\NotNull()
     * @Assert\Type("string")
     * @Assert\Length(min=10)
     */
    private $subject;
    /**
     * @Assert\NotNull()
     * @Assert\Type("string")
     */
    private $message;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     *
     * @return Contact
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
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
     *
     * @return Contact
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param mixed $subject
     *
     * @return Contact
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     *
     * @return Contact
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }
}