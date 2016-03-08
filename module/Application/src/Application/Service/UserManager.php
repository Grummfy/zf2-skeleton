<?php
namespace Application\Service;

use Doctrine\ORM\EntityRepository;

class UserManager
{
	/**
	 * @var EntityRepository
	 */
	protected $_repository;

	public function setRepository(EntityRepository $repository)
	{
		$this->_repository = $repository;
		return $this;
	}

	public function getList()
	{
		if (!$this->_repository)
		{
			throw new Exception();
		}
		return $this->_repository->findAll();
	}
}
