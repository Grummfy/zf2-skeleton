<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User
{
	/**
	 * @ORM\Column(type="integer", options={"unsigned":true})
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @var string
	 * @ORM\Column(type="string")
	 */
	protected $lastname;

	/**
	 * @var string
	 * @ORM\Column(type="string")
	 */
	protected $firstname;

	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getLastname()
	{
		return $this->lastname;
	}

	/**
	 * @param string $lastname
	 */
	public function setLastname($lastname)
	{
		$this->lastname = $lastname;
	}

	/**
	 * @return string
	 */
	public function getFirstname()
	{
		return $this->firstname;
	}

	/**
	 * @param string $firstname
	 */
	public function setFirstname($firstname)
	{
		$this->firstname = $firstname;
	}
}
