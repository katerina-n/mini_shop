<?php

namespace Diva\CommonBundle\Managers;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\OptimisticLockException;

/**
 * Class AbstractManager.
 */
abstract class AbstractManager
{
    /**
     * @var EntityRepository
     */
    protected $repository;

    /**
     * @var string
     */
    protected $entityClassName;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * AbstractManager constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Gets EntityManager.
     *
     * @return EntityManager
     */
    public function getEntityManager(): EntityManager
    {
        return $this->entityManager;
    }

    /**
     * Gets EntityClassName.
     *
     * @return string
     */
    public function getEntityClassName(): string
    {
        return $this->entityClassName;
    }

    /**
     * Sets EntityClassName.
     *
     * @param string $entityClassName
     *
     * @return AbstractManager
     */
    public function setEntityClassName(string $entityClassName): self
    {
        $this->entityClassName = $entityClassName;

        return $this;
    }

    /**
     * @param int $id
     *
     * @return null|object
     */
    public function find($id)
    {
        if ($id) {
            return $this->getRepository()->find($id);
        }

        return null;
    }

    /**
     * @return array
     */
    public function findAll()
    {
        return $this->getRepository()->findAll();
    }

    /**
     * @return EntityRepository
     */
    protected function getRepository()
    {
        if (!$this->repository && $this->getEntityClassName()) {
            $this->repository = $this->entityManager->getRepository($this->getEntityClassName());
        }

        return $this->repository;
    }

    /**
     * Flush only one repository.
     *
     * @param object|array $entity
     *
     * @return AbstractManager
     *
     * @throws OptimisticLockException
     */
    public function flush($entity): self
    {
        $this->entityManager->flush($entity);

        return $this;
    }

    /**
     * Flush all.
     *
     * @return AbstractManager
     */
    public function flushAll(): self
    {
        $this->entityManager->flush();

        return $this;
    }

    /**
     * @param $array
     *
     * @return null|object
     */
    public function findOneBy($array)
    {
        return $this->getRepository()->findOneBy($array);
    }

    /**
     * @param $entity
     */
    public function remove($entity)
    {
        $this->entityManager->transactional(function () use ($entity) {
            $this->entityManager->remove($entity);
        });
    }

    /**
     * @param string $type
     *
     * @return array|null|\Exception
     */
    public function findByType(string $type)
    {
        return $this->getRepository()->findBy(['group' => $type]);
    }
}
