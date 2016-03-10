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
    protected $userManager;
    
    public function setUp()
    {
//        echo 'will be executed before each test';
        $this->userManager = new UserManager();
    }

//    public function tearDown()
//    {
//        // will be executed after each test
//        parent::tearDown();
//        unset($this->userManager);
//        echo 'end' . PHP_EOL;
//    }

    /**
     *  @small
     */
    public function testRepositorySetterReallySetRepositoryProperty()
    {
        sleep(5);
        $this->userManager = new UserManager();
        $repository = $this->getMockBuilder('Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->assertSame($this->userManager, $this->userManager->setRepository($repository));
        
        $this->assertAttributeSame($repository, 'repository', $this->userManager);
    }
    
    public function testEntityManagerSetterReallySetEntityManagerProperty()
    {
        $this->userManager = new UserManager();
        $entityManager = $this->getMockBuilder('Doctrine\ORM\EntityManagerInterface')
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->assertSame($this->userManager, $this->userManager->setEntityManager($entityManager));
        
        $this->assertAttributeSame($entityManager, 'entityManager', $this->userManager);
    }
    
    public function testFileStorageSetterReallySetFileStorageProperty()
    {
        $this->userManager = new UserManager();
        $fileStorage = $this->getMockBuilder('Application\Service\FileStorage\FileStorageInterface')
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->assertSame($this->userManager, $this->userManager->setFileStorage($fileStorage));
        
        $this->assertAttributeSame($fileStorage, 'fileStorage', $this->userManager);
    }
    
    public function testGetListActuallyGetUserListFromDatabase()
    {
        $this->userManager = new UserManager();
        $repository = $this->getMockBuilder('Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $this->userManager->setRepository($repository);
        $result = new ArrayCollection();
        
        $repository->expects($this->once())
            ->method('findAll')
            ->willReturn($result);
        
        $this->assertSame($result, $this->userManager->getList());
    }
    
    public function testGetActuallyGetAUserFromDatabase()
    {
        $this->userManager = new UserManager();
        $repository = $this->getMockBuilder('Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $this->userManager->setRepository($repository);
        
        $result = new User();
        $id = 42;
        
        $repository->expects($this->once())
            ->method('find')
            ->with($id)
            ->willReturn($result);
        
        $this->assertSame($result, $this->userManager->get($id));
    }

    /**
     * @expectedException \Application\Service\Exception
     */
    public function testGetListThrowsExceptionWhenNoRepositoryIsProvided()
    {
        $this->userManager = new UserManager();
        $this->userManager->getList();
    }
    
    public function testSaveUserActuallySaveInDatabase()
    {
        $this->userManager = new UserManager();
        $user = new User();

        $entityManager = $this->getMock('Doctrine\ORM\EntityManagerInterface');
        
        $this->userManager->setEntityManager($entityManager);
        
        $entityManager->expects($this->once())
            ->id('persist')
            ->method('persist')
            ->with($user);
        $entityManager->expects($this->once())
            ->after('persist')
            ->method('flush');
        
        $this->userManager->save($user);
    }
    
    public function testSaveUserWithTemporaryAvatarActuallyStoreNewAvatarOnFileStorage()
    {
        $this->userManager = new UserManager();
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
        $this->userManager->setFileStorage($fileStorage);
        
        $fileStorage->expects($this->once())
            ->method('filePutContent')
            ->with('/' . $id . '/toto.jpg', $avatarContent);
        
        $this->userManager->setEntityManager($entityManager);
        
        $this->userManager->save($user);
    }
}
