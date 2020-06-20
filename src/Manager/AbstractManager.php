<?php

namespace App\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ObjectRepository;
use LogicException;

/**
 * Class AbstractManager
 *
 * Every manager should extends this class.
 *
 * @package AciaPro\AppBundle\Services\Manager
 */
abstract class AbstractManager
{
	/**
	 * @var string $entity
	 */
    protected string $entityClassName;
	/**
	 * @var EntityManagerInterface
	 */
    protected EntityManagerInterface $entityManager;
	/**
	 * @var ObjectRepository $repository
	 */
    private ObjectRepository $repository;

	/**
	 * AbstractManager constructor.
	 *
	 * @param EntityManagerInterface $entityManager
	 */
	public function __construct(EntityManagerInterface $entityManager)
	{
		if (null === $this->entityClassName) {
			throw new LogicException('You must set $entityClassName attribute prior to call AbstractManager constructor.');
		}

		$this->setEntityManager($entityManager);
	}

	/**
	 * Allows entity manager overrideing
	 *
	 * @param EntityManagerInterface $entityManager
	 */
	public function setEntityManager(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;
		$this->repository = $entityManager->getRepository($this->entityClassName);
	}

	/**
	 * @param int $id
	 * @return object
	 * @throws ORMException
	 */
	public function getReference(int $id)
	{
		return $this->entityManager->getReference($this->entityClassName, $id);
	}

	/**
	 * @todo should be protected to avoid use from controller
	 * Gets managed entity's repository
	 */
	public function getRepository()
	{
		return $this->repository;
	}

	/**
	 * Finds an object by its primary key / identifier
	 *
	 * @param int $id
	 * @return null|object
	 */
	public function find(int $id)
	{
		return $this->repository->find($id);
	}

	/**
	 * Finds a single entity by a set of criteria
	 *
	 * @param array $criteria
	 * @return null|object
	 */
	public function findOneBy(array $criteria)
	{
		return $this->repository->findOneBy($criteria);
	}

	/**
	 * Finds entities by a set of criteria
	 *
	 * @param array $criteria An array used by findBy doctrine method
	 * @param array|null $orderBy
	 * @param int|null $limit
	 * @param int|null $offset
	 *
	 * @return array
	 */
	public function findBy(array $criteria, array $orderBy = null, int $limit = null, int $offset = null)
	{
		return $this->repository->findBy($criteria, $orderBy, $limit, $offset);
	}

	/**
	 * Finds all entities in the repository
	 *
	 * @return array
	 */
	public function findAll()
	{
		return $this->repository->findAll();
	}

	/**
	 * Removes an array of object instances
	 *
	 * @param array $objects
	 * @param bool $flush
	 *
	 * @todo replace array by iterable from php 7.1
	 */
	public function deleteMany(array $objects, bool $flush = true)
	{
		foreach ($objects as $object) {
			$this->delete($object, false);
		}

		if ($flush) {
			$this->flush();
		}
	}

	/**
	 * Removes an object instance
	 *
	 * @param mixed $entity
	 * @param bool $flush
	 * @todo: extends all entities from one interface
	 *
	 */
	public function delete($entity, bool $flush = true)
	{
		$this->entityManager->remove($entity);

		if ($flush) {
			$this->flush();
		}
	}

	/**
	 * Flushes all changes
	 */
	public function flush()
	{
		$this->entityManager->flush();
	}

	/**
	 * Persists an array of object instances
	 *
	 * @param array $objects
	 * @param bool $flush
	 * @todo replace array by iterable from php 7.1
	 */
	public function saveMany(array $objects, bool $flush = true)
	{
		foreach ($objects as $object) {
			$this->save($object, false);
		}

		if ($flush) {
			$this->flush();
		}
	}

	/**
	 * Persists and optionally flushes an entity
	 *
	 * @param mixed $object
	 * @param bool $flush
	 * @todo: extends all entities from one interface
	 *
	 */
	public function save($object, bool $flush = true)
	{
		$this->entityManager->persist($object);

		if ($flush) {
			$this->flush();
		}
	}
}
