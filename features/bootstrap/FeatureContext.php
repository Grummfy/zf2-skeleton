<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext implements Context, SnippetAcceptingContext
{
	/**
	 * @var \Zend\ServiceManager\ServiceManager
	 */
	protected static $_serviceManager;

	/**
	 * @var \Application\Entity\User
	 */
	protected $_temporaryUser;

	/**
	 * Will initilized the zf app
	 */
	public static function bootstrapApplication()
	{
		if (!isset(static::$_serviceManager))
		{
			\ApplicationTest\Bootstrap::init();
			static::$_serviceManager = \ApplicationTest\Bootstrap::getServiceManager();
		}
	}

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
	    self::bootstrapApplication();
    }

    /**
     * @Given I have a stored user with:
     */
    public function iHaveAStoredUserWith(TableNode $table)
    {
	    $userData = $table->getRowsHash();
	    /* @var \Zend\Stdlib\Hydrator\ClassMethods $hydrator */
	    $hydrator = static::$_serviceManager->get('hydratorManager')->get('classMethods');
	    $user = new \Application\Entity\User();
	    $hydrator->hydrate($userData, $user);
	    $this->_getEntityManager()->persist($user);
	    $this->_getEntityManager()->flush();

	    $this->_temporaryUser = $user;
    }

    /**
     * @Then I should be on the user edit page
     */
    public function iShouldBeOnTheUserEditPage()
    {
        throw new PendingException();
    }

	/**
	 * @AfterScenario @cleanup
	 */
	public function cleanup()
	{
		// will be executed for all scenario with this tags (after it)

		// remove created users
		if ($this->_temporaryUser)
		{
			$this->_getEntityManager()->remove($this->_temporaryUser);
			$this->_getEntityManager()->flush();
		}
	}

	/**
	 * @return \Doctrine\ORM\EntityManager
	 */
	protected function _getEntityManager()
	{
		return static::$_serviceManager->get('doctrine.entitymanager.orm_default');
	}
}
