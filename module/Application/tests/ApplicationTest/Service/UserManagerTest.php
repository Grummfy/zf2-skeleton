<?php
namespace ApplicationTest\Service;

use Application\Service\UserManager;
use Doctrine\Common\Collections\ArrayCollection;

class UserManagerTest extends \PHPUnit_Framework_TestCase
{
	public function testSetRepository()
	{
		$userManager = new UserManager();
		$repository = $this->getMockBuilder('Doctrine\ORM\EntityRepository')
			->disableOriginalConstructor()
			->getMock();
		$userManager->setRepository($repository);

		$this->assertAttributeSame($repository, '_repository', $userManager);
	}

	public function testGetListOfUserFromDatabase()
	{
		$userManager = new UserManager();
		$repository = $this->getMockBuilder('Doctrine\ORM\EntityRepository')
		                   ->disableOriginalConstructor()
		                   ->getMock();

		$userManager->setRepository($repository);
		$result = new ArrayCollection();

		// mock => pas de stub
		$repository->expects($this->once())
			->method('findAll')
			->willReturn($result);

		$this->assertSame($result, $userManager->getList());
	}

	public function testGetListThrowsExceptionWhenNoRepositoryProvided()
	{
		// programatical way
		$this->setExpectedException('Application\Service\Exception');

		// declarative way
		// @expectedException sur la méthode

		$userManager = new userManager();
		$userManager->getList();
	}
}
