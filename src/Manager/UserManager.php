<?php

namespace App\Manager;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
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

    public function authenticateUser(string $email, string $password)
    {
        $user = $this->findOneBy([
            'email' => $email,
        ]);
        if (!empty($user)) {
            return $this->encoder->isPasswordValid($user, $password);
        }
        return false;
    }

    public function createUser($user)
    {
    }
}
