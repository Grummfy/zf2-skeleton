<?php

namespace Application\Controller;

use Application\Service\UserManager;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class UserController extends AbstractActionController
{
    public function listAction()
    {
        /** @var UserManager $userManager */
        $userManager = $this->getServiceLocator()->get('userManager');
        
        $data = [
            'users' => $userManager->getList()
        ];
        
        return new ViewModel($data);
    }
    
    public function addAction()
    {
        return new ViewModel();
    }
    
    public function editAction()
    {
        /** @var UserManager $userManager */
        $userManager = $this->getServiceLocator()->get('userManager');
        
        $user = $userManager->get($this->params('id'));

        if (!$user)
        {
            $this->getResponse()->setStatusCode(404);
	        return;
        }

	    if ($this->getRequest()->isPost())
	    {
		    $user->setFirstname($this->params('Firstname'));
		    $user->setLastname($this->params('Lastname'));
		    $userManager->save($user);
		    $this->flashMessenger()->addSuccessMessage($user->getFirstname() . ' ' . $user->getLastname() . ' has been saved');
	    }

        $data = [
            'user' => $user
        ];

        return new ViewModel($data);
    }
}
