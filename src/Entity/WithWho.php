<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WithWho
 *
 * @ORM\Table(name="withWho")
 * @ORM\Entity
 */
class WithWho extends AbstractEntity
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
     * @return WithWho
     */
    public function setId(int $id): WithWho
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
     * @return WithWho
     */
    public function setLabel(?string $label): WithWho
    {
        $this->label = $label;
        return $this;
    }

}