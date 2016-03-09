<?php

namespace Application\Validator;

class EmailAddress
{
	public function isValid($emailAddress)
	{
		return (bool)preg_match('#^([a-zA-Z0-9]*)@([a-zA-Z]*).([a-zA-Z]{2,4})$#', $emailAddress);
	}
}
