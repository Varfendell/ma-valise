<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Photo
 *
 * @ORM\Table(name="photo", indexes={@ORM\Index(name="photo_fk", columns={"herbergement"})})
 * @ORM\Entity
 */
class Photo
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
	 * @var string|null
	 *
	 * @ORM\Column(name="picture_name", type="string", length=100, nullable=true)
	 */
	private $pictureName;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="blob", type="blob", length=65535, nullable=false)
	 */
	private $blob;

	/**
	 * @var Hebergement
	 *
	 * @ORM\ManyToOne(targetEntity="Hebergement")
	 * @ORM\JoinColumns({
	 *   @ORM\JoinColumn(name="herbergement", referencedColumnName="id")
	 * })
	 */
	private $herbergement;

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getPictureName(): ?string
	{
		return $this->pictureName;
	}

	public function setPictureName(?string $pictureName): self
	{
		$this->pictureName = $pictureName;

		return $this;
	}

	public function getBlob()
	{
		return $this->blob;
	}

	public function setBlob($blob): self
	{
		$this->blob = $blob;

		return $this;
	}

	public function getHerbergement(): ?Hebergement
	{
		return $this->herbergement;
	}

	public function setHerbergement(?Hebergement $herbergement): self
	{
		$this->herbergement = $herbergement;

		return $this;
	}


}
