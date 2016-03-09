<?php
/**
 * Created by PhpStorm.
 * User: fred
 * Date: 08/03/16
 * Time: 11:50
 */

namespace ApplicationTest\Service;

use Application\Entity\User;
use Application\Service\UserManager;
use Doctrine\Common\Collections\ArrayCollection;
use org\bovigo\vfs\vfsStream;

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
        $entityManager = $this->getMockBuilder('Doctrine\ORM\EntityManagerInterface')
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->assertSame($userManager, $userManager->setEntityManager($entityManager));
        
        $this->assertAttributeSame($entityManager, 'entityManager', $userManager);
    }
    
    public function testFileStorageSetterReallySetFileStorageProperty()
    {
        $userManager = new UserManager();
        $fileStorage = $this->getMockBuilder('Application\Service\FileStorage\FileStorageInterface')
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->assertSame($userManager, $userManager->setFileStorage($fileStorage));
        
        $this->assertAttributeSame($fileStorage, 'fileStorage', $userManager);
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
    
    public function testSaveUserActuallySaveInDatabase()
    {
        $userManager = new UserManager();
        $user = new User();

        $entityManager = $this->getMock('Doctrine\ORM\EntityManagerInterface');
        
        $userManager->setEntityManager($entityManager);
        
        $entityManager->expects($this->once())
            ->id('persist')
            ->method('persist')
            ->with($user);
        $entityManager->expects($this->once())
            ->after('persist')
            ->method('flush');
        
        $userManager->save($user);
    }
    
    public function testSaveUserWithTemporaryAvatarActuallyStoreNewAvatarOnFileStorage()
    {
        $userManager = new UserManager();
        $id = 42;
        $avatarContent = 'totoImage';
        $vfs = vfsStream::setup('root', null, [
            'tmp' => [
                'toto.jpg' => $avatarContent
            ]
        ]);
        $avatar = $vfs->url() . '/tmp/toto.jpg';
        $user = $this->getMock('Application\Entity\User');
        $user->expects($this->atLeastOnce())
            ->method('getId')
            ->willReturn($id);
        
        $user->expects($this->atLeastOnce())
            ->method('getTemporaryAvatar')
            ->willReturn($avatar);

        $entityManager = $this->getMock('Doctrine\ORM\EntityManagerInterface');
        
        $fileStorage = $this->getMockBuilder('Application\Service\FileStorage\FileStorageInterface')
            ->setMethods(['filePutContent'])
            ->getMock();
        $userManager->setFileStorage($fileStorage);
        
        $fileStorage->expects($this->once())
            ->method('filePutContent')
            ->with('/' . $id . '/toto.jpg', $avatarContent);
        
        $userManager->setEntityManager($entityManager);
        
        $userManager->save($user);
    }
}