<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Wishes
 *
 * @ORM\Table(name="wishes")
 * @ORM\Entity
 */
class Wishes extends AbstractEntity
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
     * @ORM\Column(name="url", type="string", length=200, nullable=true)
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
     * @return Wishes
     */
    public function setId(int $id): Wishes
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
     * @return Wishes
     */
    public function setLabel(?string $label): Wishes
    {
        $this->label = $label;
        return $this;
    }

}