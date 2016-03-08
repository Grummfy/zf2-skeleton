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
		return $this->_repository->findAll();
	}
}
