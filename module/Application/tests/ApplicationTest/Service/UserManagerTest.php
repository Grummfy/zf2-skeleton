<?php

namespace ApplicationTest\Service;

use Application\Entity\User;
use Application\Service\UserManager;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;

class UserManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testRepositorySetterReallySetRepositoryProperty()
    {
        $userManager = new UserManager();
        $repository = $this->getMockBuilder('Doctrine\ORM\EntityRepository')
                           ->disableOriginalConstructor()
                           ->getMock();

        $this->assertSame($userManager, $userManager->setRepository($repository));

        $this->assertAttributeSame($repository, 'repository', $userManager);
    }

    public function testEntityManagerSetterReallySetEntityManagerProperty()
    {
        $userManager = new UserManager();
        $manager = $this->getMockBuilder(EntityManagerInterface::class)
                           ->disableOriginalConstructor()
                           ->getMock();

        $this->assertSame($userManager, $userManager->setEntityManager($manager));

        $this->assertAttributeSame($manager, 'entityManager', $userManager);
    }
    
    public function testGetListActuallyGetUserListFromDatabase()
    {
        $userManager = new UserManager();
        $repository = $this->getMockBuilder('Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $userManager->setRepository($repository);
        $result = new ArrayCollection();
        
        $repository->expects($this->once())
            ->method('findAll')
            ->willReturn($result);
        
        $this->assertSame($result, $userManager->getList());
    }
    
    public function testGetActuallyGetAUserFromDatabase()
    {
        $userManager = new UserManager();
        $repository = $this->getMockBuilder('Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $userManager->setRepository($repository);
        
        $result = new User();
        $id = 42;
        
        $repository->expects($this->once())
            ->method('find')
            ->with($id)
            ->willReturn($result);
        
        $this->assertSame($result, $userManager->get($id));
    }

    /**
     * @expectedException \Application\Service\Exception
     */
    public function testGetListThrowsExceptionWhenNoRepositoryIsProvided()
    {
        $userManager = new UserManager();
        $userManager->getList();
    }

    public function testUserSave()
    {
        $userManager = new UserManager();

        $manager = $this->getMockBuilder(EntityManagerInterface::class)
                        ->disableOriginalConstructor()
                        ->getMock();
        $userManager->setEntityManager($manager);

        $user = new User();

        $manager->expects($this->once())
                      ->id('persist-id')
                      ->method('persist')
                      ->with($user);
        $manager->expects($this->once())
                      ->after('persist-id')
                      ->method('flush');

        $userManager->save($user);
    }
}