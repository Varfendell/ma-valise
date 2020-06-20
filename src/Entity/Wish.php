<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Wish
 *
 * @ORM\Table(name="wish")
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
     * @ORM\Column(name="plage", type="string", nullable=true)
     */
    private $plage;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ski", type="string", nullable=true)
     */
    private $ski;

    /**
     * @var string|null
     *
     * @ORM\Column(name="montagne", type="string", nullable=true)
     */
    private $montagne;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nature", type="string", nullable=true)
     */
    private $nature;

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
    public function getPlage(): ?string
    {
        return $this->plage;
    }

    /**
     * @param string|null $plage
     * @return Wish
     */
    public function setPlage(?string $plage): Wish
    {
        $this->plage = $plage;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSki(): ?string
    {
        return $this->ski;
    }

    /**
     * @param string|null $ski
     * @return Wish
     */
    public function setSki(?string $ski): Wish
    {
        $this->ski = $ski;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMontagne(): ?string
    {
        return $this->montagne;
    }

    /**
     * @param string|null $montagne
     * @return Wish
     */
    public function setMontagne(?string $montagne): Wish
    {
        $this->montagne = $montagne;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNature(): ?string
    {
        return $this->nature;
    }

    /**
     * @param string|null $nature
     * @return Wish
     */
    public function setNature(?string $nature): Wish
    {
        $this->nature = $nature;
        return $this;
    }

}

