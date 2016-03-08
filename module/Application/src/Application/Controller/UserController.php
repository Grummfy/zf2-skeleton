<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class UserController extends AbstractActionController
{
    public function indexAction()
    {
	    return new ViewModel();
//        return new ViewModel('users', $this->getServiceLocator()->get('doctrine.entitymanager.orm_default')->getRepository('Application\Entity\User')->all());
    }

    public function addAction()
    {
        return new ViewModel();
    }
}
