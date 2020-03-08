<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * HebergementHashtag
 *
 * @ORM\Table(name="hashtag")
 * @ORM\Entity
 */
class Hashtag
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
	 * @ORM\Column(name="label", type="string", length=100, nullable=false)
	 */
	private $label;

	/**
	 * @ORM\ManyToMany(targetEntity="Hebergement", mappedBy="hashtags")
	 */
	private $hebergements;

	public function __construct()
	{
		$this->hebergements = new ArrayCollection();
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getLabel(): ?string
	{
		return $this->label;
	}

	public function setLabel(string $label): self
	{
		$this->label = $label;

		return $this;
	}

	/**
	 * @return Collection|Hebergement[]
	 */
	public function getHebergements(): Collection
	{
		return $this->hebergements;
	}

	public function addHebergement(Hebergement $hebergement): self
	{
		if (!$this->hebergements->contains($hebergement)) {
			$this->hebergements[] = $hebergement;
			$hebergement->addHashtag($this);
		}

		return $this;
	}

	public function removeHebergement(Hebergement $hebergement): self
	{
		if ($this->hebergements->contains($hebergement)) {
			$this->hebergements->removeElement($hebergement);
			$hebergement->removeHashtag($this);
		}

		return $this;
	}


}
