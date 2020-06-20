<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Wish
 *
 * @ORM\Table(name="wishes")
 * @ORM\Entity
 */
class Wish extends AbstractEntity
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
     * @ORM\Column(name="label", type="string", length=200, nullable=true)
     */
    private $label;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Wish
     */
    public function setId(int $id): Wish
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * @param string|null $label
     * @return Wish
     */
    public function setLabel(?string $label): Wish
    {
        $this->label = $label;
        return $this;
    }

}