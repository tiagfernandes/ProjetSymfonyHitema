<?php

namespace App\Entity;

use App\Service\FileUploader;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\OneToMany;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VideoRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Video
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
    private $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dtRelease;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dtAdd;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Character", inversedBy="videosFilmmaker")
     * @JoinTable(name="videos_filmmakers")
     */
    private $filmmakers;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Character", inversedBy="videosActor")
     * @JoinTable(name="videos_actors")
     */
    private $actors;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Genre")
     */
    private $genres;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Type")
     * @JoinColumn(name="type_id", referencedColumnName="id")
     */
    private $type;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $requiredAge;

    /**
     * @ORM\Column(type="string", length=2083)
     */
    private $image;

    /**
     * @Assert\File(mimeTypes={ "image/jpeg", "image/png" })
     */
    private $rowImage;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @Assert\Url()
     */
    private $urlTrailer;

    /**
     * @ORM\Column(type="string", length=5000)
     */
    private $comment;

    /**
     * @OneToMany(targetEntity="App\Entity\Purchase", mappedBy="video")
     */
    private $purchases;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=128, unique=true, nullable=false)
     */
    private $slug;

    public function __construct()
    {
        $this->actors = new ArrayCollection();
        $this->genres = new ArrayCollection();
        $this->filmmakers = new ArrayCollection();
        $this->setDtAdd(new \DateTime());
    }

    /**
     * @return mixed
     */
    public function getPurchases()
    {
        return $this->purchases;
    }

    /**
     * @param mixed $purchases
     */
    public function setPurchases($purchases): void
    {
        $this->purchases = $purchases;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDtRelease(): ?\DateTimeInterface
    {
        return $this->dtRelease;
    }

    public function setDtRelease(\DateTimeInterface $dtRelease): self
    {
        $this->dtRelease = $dtRelease;

        return $this;
    }

    public function getFilmmakers()
    {
        return $this->filmmakers;
    }

    public function addFilmmaker(Character $character): self
    {
        if (!$this->filmmakers->contains($character)) {
            $this->filmmakers->add($character);
        }
        return $this;
    }

    public function removeFilmmaker(Character $character): self
    {
        if ($this->filmmakers->contains($character)) {
            $this->filmmakers->removeElement($character);
        }
        return $this;
    }

    public function getActors()
    {
        return $this->actors;
    }

    public function addActor(Character $character): self
    {
        if (!$this->actors->contains($character)) {
            $this->actors->add($character);
        }
        return $this;
    }

    public function removeGenre(Character $character): self
    {
        if ($this->actors->contains($character)) {
            $this->actors->removeElement($character);
        }
        return $this;
    }

    public function getGenres()
    {
        return $this->genres;
    }

    public function addGenres(Genre $genre)
    {
        if (!$this->genres->contains($genre)) {
            $this->genres->add($genre);
        }

    }

    public function removeGenres(Genre $genre)
    {
        if (!$this->genres->contains($genre)) {
            $this->genres->removeElement($genre);
        }
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType(Type $type)
    {
        $this->type = $type;

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

    public function getRequiredAge(): ?int
    {
        return $this->requiredAge;
    }

    public function setRequiredAge(int $requiredAge): self
    {
        $this->requiredAge = $requiredAge;

        return $this;
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
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $comment
     */
    public function setComment($comment): void
    {
        $this->comment = $comment;
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
    public function getDtAdd()
    {
        return $this->dtAdd;
    }

    /**
     * @param mixed $dtAdd
     */
    public function setDtAdd($dtAdd): void
    {
        $this->dtAdd = $dtAdd;
    }

    /**
     * @return mixed
     */
    public function getUrlTrailer()
    {
        return $this->urlTrailer;
    }

    /**
     * @param mixed $urlTrailer
     */
    public function setUrlTrailer($urlTrailer): void
    {
        $this->urlTrailer = $urlTrailer;
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
}
