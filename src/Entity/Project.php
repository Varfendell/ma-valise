<?php

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\ManyToOne;


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
     * Quelles sont tes envies?
     * Many Projects have Many Wish.
     * @ManyToMany(targetEntity="Wish")
     * @JoinTable(name="projects_wishes",
     *      joinColumns={@JoinColumn(name="project_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="wishes_id", referencedColumnName="id")}
     *      )
     */
    private $wishes;

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
     * Avec qui?
     *
     * Many Projects have one withWho.

     * @ManyToOne(targetEntity="WithWho")
     * @JoinColumn(name="withWho_id", referencedColumnName="id")
     */
    private $withWho;

    /**
     * @var DateTime|null
     *
     * @ORM\Column(name="date_end", type="date", nullable=true)
     */
    private $dateEnd;

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
            $this->wishes = new ArrayCollection();
	}

    /**
     * @return mixed
     */
    public function getWithWho()
    {
        return $this->withWho;
    }

    /**
     * @param mixed $withWho
     * @return Project
     */
    public function setWithWho($withWho)
    {
        $this->withWho = $withWho;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getWishes(): ArrayCollection
    {
        return $this->wishes;
    }

    /**
     * @param Wish $wish
     * @return Project
     */
    public function addWishes(Wish $wish): Project

    {

        if (!$this->wishes->contains($wish)) {

            $this->wishes->add($wish);

        }

        return $this;

    }

    public function removeWishes(Wish $wish): Project

    {

        if ($this->wishes->contains($wish)) {

            $this->wishes->removeElement($wish);

        }

        return $this;

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
