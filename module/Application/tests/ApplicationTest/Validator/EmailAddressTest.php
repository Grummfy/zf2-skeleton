<?php

namespace ApplicationTest\Validator;

use Application\Validator\EmailAddress;

class EmailAdressTest extends \PHPUnit_Framework_TestCase
{
	public function getFixtures()
	{
		// each arg of the test method will be in the array
		return [
			['toto@youkulele.com', true],
			['toto-at-youkulele-dot-com', false],
		];
	}

	/**
	 * @dataProvider getFixtures()
	 */
	public function testValidAddressThroughFixture($address, $isValid)
	{
		$validator = new EmailAddress();
		$this->assertEquals($isValid, $validator->isValid($address));
	}

	public function testValidAddress()
	{
		$address = 'toto@youkulele.com';

		$validator = new EmailAddress();
		$this->assertTrue($validator->isValid($address));
	}

	public function testInvalidAddress()
	{
		$address = 'toto-at-youkulele-dot-com';

		$validator = new EmailAddress();
		$this->assertFalse($validator->isValid($address));
	}
}
