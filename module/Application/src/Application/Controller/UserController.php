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
		$user = $this->getServiceLocator()->get('userManager')->get($this->params('id'));

		if (null === $user)
		{
			$this->getResponse()
				->setStatusCode(404)
				->setReasonPhrase('error-user-not-found');
			return false;
		}

		return new ViewModel(['user' => $user]);
	}
}
