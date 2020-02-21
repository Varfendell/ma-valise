<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cagnotte
 *
 * @ORM\Table(name="cagnotte")
 * @ORM\Entity
 */
class Cagnotte
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
    private $url;

    /**
     * @var bool
     *
     * @ORM\Column(name="notification", type="boolean", nullable=false)
     */
    private $notification = '0';

    /**
     * @var Project
     *
     * @ORM\OneToOne(targetEntity="Project", mappedBy="cagnotte")
     * })
     */
    private $project;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getNotification(): ?bool
    {
        return $this->notification;
    }

    public function setNotification(bool $notification): self
    {
        $this->notification = $notification;

        return $this;
    }

    /**
     * @return Project
     */
    public function getProject(): Project
    {
        return $this->project;
    }

    /**
     * @param Project $project
     * @return Cagnotte
     */
    public function setProject(Project $project): Cagnotte
    {
        $this->project = $project;
        return $this;
    }


}
