<?php
namespace ApplicationTest\Entity;

use Application\Entity\User;

class UserTest extends \PHPUnit_Framework_TestCase
{
	public function testSettersNames()
	{
		$user = new User();

		$user->setLastname('toto');
		$this->assertAttributeSame('toto', 'lastname', $user);

		$user->setFirstname('tata');
		$this->assertAttributeSame('tata', 'firstname', $user);
	}

	public function testGettersNames()
	{
		$user = new User();
		$this->_setPropertyValue($user, 'lastname', 'tutu');
		$this->_setPropertyValue($user, 'firstname', 'tata');

		$this->assertSame('tutu', $user->getLastname());
		$this->assertSame('tata', $user->getFirstname());
	}

	public function testGetId()
	{
		$user = new User();
		$this->_setPropertyValue($user, 'id', 45);

		$this->assertSame(45, $user->getId());
	}

	protected function _setPropertyValue($object, $propertyName, $value)
	{
		$reflection = new \ReflectionObject($object);
		$property = $reflection->getProperty($propertyName);
		$property->setAccessible(true);
		$property->setValue($object, $value);
	}
}
