<?php

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Boolean;

/**
 * Project
 *
 * @ORM\Table(name="project", indexes={@ORM\Index(name="project_fk", columns={"cagnotte"}), @ORM\Index(name="projet_fk", columns={"user"})})
 * @ORM\Entity
 */
class Project extends AbstractEntity
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
	 * @var DateTime|null
	 *
	 * @ORM\Column(name="date_start", type="date", nullable=true)
	 */
	private $dateStart;

	/**
	 * @var DateTime|null
	 *
	 * @ORM\Column(name="date_end", type="date", nullable=true)
	 */
	private $dateEnd;

    /**
     * @var boolean
     *
     * @ORM\Column(name="desires", type="boolean", nullable=false)
     */
    private $desires;

    /**
     * @return Boolean
     */
    public function getDesires(): Boolean
    {
        return $this->desires;
    }

    /**
     * @param Boolean $desires
     * @return Project
     */
    public function setDesires(Boolean $desires): Project
    {
        $this->desires = $desires;
        return $this;
    }

	/**
	 * @var string|null
	 *
	 * @ORM\Column(name="description", type="text", length=65535, nullable=true)
	 */
	private $description;

	/**
	 * @var Cagnotte
	 *
	 * @ORM\OneToOne(targetEntity="Cagnotte", inversedBy="project")
	 * @ORM\JoinColumn(name="cagnotte", referencedColumnName="id")
	 */
	private $cagnotte;

	/**
	 * @var User
	 *
	 * @ORM\ManyToOne(targetEntity="User", inversedBy="projects")
	 * @ORM\JoinColumn(name="user", referencedColumnName="id")
	 */
	private $user;

	/**
	 * @var Collection
	 *
	 * @ORM\OneToMany(targetEntity="Participant", mappedBy="project")
	 */
	private $participants;

	public function __construct()
	{
		parent::__construct();
		$this->participants = new ArrayCollection();
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

	public function getDateStart(): ?DateTimeInterface
	{
		return $this->dateStart;
	}

	public function setDateStart(?DateTimeInterface $dateStart): self
	{
		$this->dateStart = $dateStart;

		return $this;
	}

	public function getDateEnd(): ?DateTimeInterface
	{
		return $this->dateEnd;
	}

	public function setDateEnd(?DateTimeInterface $dateEnd): self
	{
		$this->dateEnd = $dateEnd;

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

	public function getCagnotte(): ?Cagnotte
	{
		return $this->cagnotte;
	}

	public function setCagnotte(?Cagnotte $cagnotte): self
	{
		$this->cagnotte = $cagnotte;

		return $this;
	}

	public function getUser(): ?User
	{
		return $this->user;
	}

	public function setUser(?User $user): self
	{
		$this->user = $user;

		return $this;
	}

	/**
	 * @return Collection<Participant>
	 */
	public function getParticipants(): Collection
	{
		return $this->participants;
	}

	public function addParticipant(Participant $participant): self
	{
		if (!$this->participants->contains($participant)) {
			$this->participants[] = $participant;
			$participant->setProject($this);
		}

		return $this;
	}

	public function removeParticipant(Participant $participant): self
	{
		if ($this->participants->contains($participant)) {
			$this->participants->removeElement($participant);
			// set the owning side to null (unless already changed)
			if ($participant->getProject() === $this) {
				$participant->setProject(null);
			}
		}

		return $this;
	}
}
