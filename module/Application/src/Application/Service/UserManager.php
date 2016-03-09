<?php
/**
 * Created by PhpStorm.
 * User: fred
 * Date: 08/03/16
 * Time: 11:47
 */

namespace Application\Service;


use Application\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class UserManager
{
    /** @var  EntityRepository */
    protected $repository;

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    public function setEntityManager(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

        return $this;
    }
    
    public function setRepository(EntityRepository $repository)
    {
        $this->repository = $repository;
        
        return $this;
    }

    public function getList()
    {
        if (!$this->repository) {
            throw new Exception;
        }
        
        return $this->repository->findAll();
    }

    /**
     * @param $id
     *
     * @return User
     * @throws Exception
     */
    public function get($id)
    {
        if (!$this->repository) {
            throw new Exception;
        }
        
        return $this->repository->find($id);
    }

	public function save(User $user)
	{
		if (!$this->entityManager) {
			throw new Exception;
		}

		$this->entityManager->persist($user);
		$this->entityManager->flush();
	}
}