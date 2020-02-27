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
     * @var \Hebergement
     *
     * @ORM\ManyToOne(targetEntity="Hebergement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="herbergement", referencedColumnName="id")
     * })
     */
    private $herbergement;


}
