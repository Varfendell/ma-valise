<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HebergementMois
 *
 * @ORM\Table(name="hebergement_mois")
 * @ORM\Entity
 */
class HebergementMois
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


}
