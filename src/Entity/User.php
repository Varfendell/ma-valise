<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity
 */
class User extends AbstractEntity implements UserInterface
{
	const ROLE_ADMIN = 'ROLE_ADMIN';
	const ROLE_USER = 'ROLE_USER';


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
	 * @ORM\Column(name="first_name", type="string", length=100, nullable=false)
	 */
	private $firstName;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="last_name", type="string", length=100, nullable=false)
	 */
	private $lastName;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="email", type="string", length=100, nullable=false)
	 */
	private $email;

	/**
	 * @var string|null
	 *
	 * @ORM\Column(name="phone", type="string", length=100, nullable=true)
	 */
	private $phone;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="password", type="string", length=100, nullable=false)
	 */
	private $password;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="salt", type="string", length=100, nullable=false)
	 */
	private $salt;

	/**
	 * @var string|null
	 *
	 * @ORM\Column(name="city", type="string", length=100, nullable=true)
	 */
	private $city;

	/**
	 * @var Collection
	 *
	 * @ORM\OneToMany(targetEntity="Project", mappedBy="user")
	 */
	private $projects;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="roles", type="string", length=100, nullable=false)
	 */
	private $roles;

	public function __construct()
   	{
   		parent::__construct();
   		$this->projects = new ArrayCollection();
   		$this->roles = json_encode([]);
   	}

	public function getId(): ?int
   	{
   		return $this->id;
   	}

	public function getPhone(): ?string
   	{
   		return $this->phone;
   	}

	public function setPhone(?string $phone): self
   	{
   		$this->phone = $phone;
   
   		return $this;
   	}

	public function getPassword(): ?string
   	{
   		return $this->password;
   	}

	public function setPassword(string $password): self
   	{
   		$this->password = $password;
   
   		return $this;
   	}

	public function getSalt(): ?string
   	{
   		return $this->salt;
   	}

	public function setSalt(string $salt): self
   	{
   		$this->salt = $salt;
   
   		return $this;
   	}

	public function getCity(): ?string
   	{
   		return $this->city;
   	}

	public function setCity(?string $city): self
   	{
   		$this->city = $city;
   
   		return $this;
   	}

	/**
	 * Returns the roles granted to the user.
	 *
	 *     public function getRoles()
	 *     {
	 *         return ['ROLE_USER'];
	 *     }
	 *
	 * Alternatively, the roles might be stored on a ``roles`` property,
	 * and populated in any number of different ways when the user object
	 * is created.
	 *
	 * @return string[] The user roles
	 */
	public function getRoles()
   	{
   		return json_decode($this->roles);
   	}

	/**
	 * @return $this
	 */
	public function setRoleAdmin(): User
   	{
   		$this->roles = json_encode([self::ROLE_ADMIN]);
   		return $this;
   	}

	/**
	 * @return $this
	 */
	public function setRoleUser(): User
   	{
   		$this->roles = json_encode([self::ROLE_USER]);
   		return $this;
   	}

	/**
	 * Returns the username used to authenticate the user.
	 *
	 * @return string The username
	 */
	public function getUsername()
   	{
   		return $this->getEmail();
   	}

	public function getEmail(): ?string
   	{
   		return $this->email;
   	}

	public function setEmail(string $email): self
   	{
   		$this->email = $email;
   
   		return $this;
   	}

	/**
	 * Removes sensitive data from the user.
	 *
	 * This is important if, at any given point, sensitive information like
	 * the plain-text password is stored on this object.
	 */
	public function eraseCredentials()
   	{
   		// TODO: Implement eraseCredentials() method.
   	}

	/**
	 * @return Collection
	 */
	public function getProjects(): Collection
   	{
   		return $this->projects;
   	}

	public function getFirstNameLastName()
   	{
   		return $this->getFirstName() . ' ' . $this->getLastName();
   	}

	public function getFirstName(): ?string
   	{
   		return $this->firstName;
   	}

	public function setFirstName(string $firstName): self
   	{
   		$this->firstName = $firstName;
   
   		return $this;
   	}

	public function getLastName(): ?string
   	{
   		return $this->lastName;
   	}

	public function setLastName(string $lastName): self
   	{
   		$this->lastName = $lastName;
   
   		return $this;
   	}

	public function addProject(Project $project): self
   	{
   		if (!$this->projects->contains($project)) {
   			$this->projects[] = $project;
   			$project->setUser($this);
   		}
   
   		return $this;
   	}

	public function removeProject(Project $project): self
   	{
   		if ($this->projects->contains($project)) {
   			$this->projects->removeElement($project);
   			// set the owning side to null (unless already changed)
   			if ($project->getUser() === $this) {
   				$project->setUser(null);
   			}
   		}
   
   		return $this;
   	}

    public function setRoles(string $roles): self
    {
        $this->roles = $roles;

        return $this;
    }


}
