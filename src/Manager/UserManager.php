<?php

namespace App\Manager;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserManager
 * @package AciaPro\AppBundle\Services\Manager
 * @method UserRepository getRepository()
 * @method User findOneBy(array $criteria)()
 */
class UserManager extends AbstractManager
{
	/**
	 * @var UserPasswordEncoderInterface
	 */
	private $encoder;

	/**
	 * UserManager constructor.
	 * @param EntityManagerInterface $entityManager
	 * @param UserPasswordEncoderInterface $encoder
	 */
	public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder)
	{
		$this->entityClassName = User::class;
		parent::__construct($entityManager);
		$this->encoder = $encoder;
	}

	/**
	 * @param User $user
	 * @throws Exception
	 */
	public function createUser(User $user)
	{
		$user->setSalt(sha1(random_bytes(100)));
		$password = $this->encoder->encodePassword($user, $user->getPassword());
		$user->setPassword($password)->setRoleUser();
		$this->save($user);
	}
}
