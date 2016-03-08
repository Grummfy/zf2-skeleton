<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Tester\Exception\PendingException;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends \Behat\MinkExtension\Context\MinkContext implements Context, SnippetAcceptingContext
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @Given I have a stored user
     */
    public function iHaveAStoredUser()
    {
        throw new PendingException();
    }

    /**
     * @Then I should be on the user edit page
     */
    public function iShouldBeOnTheUserEditPage()
    {
        throw new PendingException();
    }

}
