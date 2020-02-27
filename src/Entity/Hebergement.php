<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Hebergement
 *
 * @ORM\Table(name="hebergement")
 * @ORM\Entity
 */
class Hebergement
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="mail", type="string", length=200, nullable=true)
     */
    private $mail;

    /**
     * @var string|null
     *
     * @ORM\Column(name="web_address", type="string", length=300, nullable=true)
     */
    private $webAddress;

    /**
     * @var float|null
     *
     * @ORM\Column(name="price", type="float", precision=10, scale=0, nullable=true)
     */
    private $price;

    /**
     * @var int|null
     *
     * @ORM\Column(name="address", type="integer", nullable=true)
     */
    private $address;

    /**
     * @var string|null
     *
     * @ORM\Column(name="city", type="string", length=100, nullable=true)
     */
    private $city;

    /**
     * @var string|null
     *
     * @ORM\Column(name="town", type="string", length=100, nullable=true)
     */
    private $town;

    /**
     * @var string|null
     *
     * @ORM\Column(name="localisation", type="string", length=100, nullable=true)
     */
    private $localisation;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="Hashtag", inversedBy="hebergements")
     * @ORM\JoinTable(name="hebergement_hashtag")
     *
     *
     */
    private $hashtags;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="Month", inversedBy="hebergements")
     * @ORM\JoinTable(name="hebergement_month")
     *
     *
     */
    private $months;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="Type", inversedBy="hebergements")
     * @ORM\JoinTable(name="hebergement_type")
     *
     *
     */
    private $types;

    public function __construct()
    {
        $this->hashtags = new ArrayCollection();
        $this->months = new ArrayCollection();
        $this->types = new ArrayCollection();
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

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(?string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getWebAddress(): ?string
    {
        return $this->webAddress;
    }

    public function setWebAddress(?string $webAddress): self
    {
        $this->webAddress = $webAddress;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getAddress(): ?int
    {
        return $this->address;
    }

    public function setAddress(?int $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getTown(): ?string
    {
        return $this->town;
    }

    public function setTown(?string $town): self
    {
        $this->town = $town;

        return $this;
    }

    public function getLocalisation(): ?string
    {
        return $this->localisation;
    }

    public function setLocalisation(?string $localisation): self
    {
        $this->localisation = $localisation;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Hashtag[]
     */
    public function getHashtags(): Collection
    {
        return $this->hashtags;
    }

    public function addHashtag(Hashtag $hashtag): self
    {
        if (!$this->hashtags->contains($hashtag)) {
            $this->hashtags[] = $hashtag;
        }

        return $this;
    }

    public function removeHashtag(Hashtag $hashtag): self
    {
        if ($this->hashtags->contains($hashtag)) {
            $this->hashtags->removeElement($hashtag);
        }

        return $this;
    }

    /**
     * @return Collection|Month[]
     */
    public function getMonths(): Collection
    {
        return $this->months;
    }

    public function addMonth(Month $month): self
    {
        if (!$this->months->contains($month)) {
            $this->months[] = $month;
        }

        return $this;
    }

    public function removeMonth(Month $month): self
    {
        if ($this->months->contains($month)) {
            $this->months->removeElement($month);
        }

        return $this;
    }

    /**
     * @return Collection|Type[]
     */
    public function getTypes(): Collection
    {
        return $this->types;
    }

    public function addType(Type $type): self
    {
        if (!$this->types->contains($type)) {
            $this->types[] = $type;
        }

        return $this;
    }

    public function removeType(Type $type): self
    {
        if ($this->types->contains($type)) {
            $this->types->removeElement($type);
        }

        return $this;
    }


}
