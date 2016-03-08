<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class UserController extends AbstractActionController
{
    public function indexAction()
    {
	    return new ViewModel(['users' => $this->getServiceLocator()->get('userManager')->getList()]);
    }

	public function addAction()
	{
		return new ViewModel();
	}

	public function editAction()
	{
		return new ViewModel(['user' => $this->getServiceLocator()->get('userManager')->get($this->params('id'))]);
	}
}
