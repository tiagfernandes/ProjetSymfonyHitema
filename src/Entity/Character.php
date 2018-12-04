<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CharacterRepository")
 * @ORM\Table(name="`character`")
 */
class Character
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dtBorn;

    /**
     * @ManyToMany(targetEntity="App\Entity\Profession")
     */
    private $professions;

    /**
     * @ORM\Column(type="string")
     */
    private $image;

    /**
     * @Assert\File(mimeTypes={ "image/jpeg", "image/png" })
     */
    private $rowImage;

    /**
     * @Gedmo\Slug(fields={"lastname", "firstname"})
     * @ORM\Column(length=128, unique=true, nullable=false)
     */
    private $slug;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Video", mappedBy="filmmakers")
     */
    private $videosFilmmaker;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Video", mappedBy="actors")
     */
    private $videosActor;

    public function __construct()
    {
        $this->professions = new ArrayCollection();
        $this->videosFilmmaker = new ArrayCollection();
        $this->videosActor = new ArrayCollection();
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

    public function getDtBorn(): ?\DateTimeInterface
    {
        return $this->dtBorn;
    }

    public function setDtBorn(\DateTimeInterface $dtBorn): self
    {
        $this->dtBorn = $dtBorn;

        return $this;
    }

    public function getProfessions()
    {
        return $this->professions;
    }

    public function addProfession(Profession $profession)
    {
        if (!$this->professions->contains($profession)) {
            $this->professions->add($profession);
        }

    }

    public function removeProfession(Profession $profession)
    {
        if (!$this->professions->contains($profession)) {
            $this->professions->removeElement($profession);
        }
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image): void
    {
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getRowImage()
    {
        return $this->rowImage;
    }

    /**
     * @param mixed $rowImage
     */
    public function setRowImage($rowImage): void
    {
        $this->rowImage = $rowImage;
    }


    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @return mixed
     */
    public function getVideosFilmmaker()
    {
        return $this->videosFilmmaker;
    }

    public function addVideosFilmmaker(Video $video): self
    {
        if (!$this->videosFilmmaker->contains($video)) {
            $this->videosFilmmaker[] = $video;
        }

        return $this;
    }

    public function removeVideosFilmmaker(Video $video): self
    {
        if ($this->videosFilmmaker->contains($video)) {
            $this->videosFilmmaker->removeElement($video);
        }

        return $this;
    }

    public function getVideosActor()
    {
        return $this->videosActor;
    }

    public function addVideosActor(Video $video): self
    {
        if (!$this->videosActor->contains($video)) {
            $this->videosActor[] = $video;
        }

        return $this;
    }

    public function removeVideosActor(Video $video): self
    {
        if ($this->videosActor->contains($video)) {
            $this->videosActor->removeElement($video);
        }

        return $this;
    }
}
