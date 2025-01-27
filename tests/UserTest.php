<?php

namespace App\Tests;

use App\Entity\User;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserTest extends KernelTestCase
{
    /*
     * @var EntityManagerInterface
     */
    private $entityManager;
    /*
     * @var ValidatorInterface
     */
    private $validator;
    protected function setUp():void
    {
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
        $this->validator = $kernel->getContainer()->get('validator');
        $schemaTool = new SchemaTool($this->entityManager);
        $metadata = $this->entityManager->getMetadataFactory()->getAllMetadata();

        if (!empty($metadata)) {
            $schemaTool->dropSchema($metadata);
            $schemaTool->createSchema($metadata);
        }
    }

    public function testCreateUser()
    {
        $user = new User();
        $user->setEmail('test@test.com');
        $user->setFirstName('Test');
        $user->setLastName('User');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword('testing@123#');
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        $userRepository = $this->entityManager->getRepository(User::class);
        $user = $userRepository->findOneByEmail(['email'=>'test@test.com']) ?? null;
        $this->assertNotNull($user);
        $this->assertEquals('test@test.com', $user->getEmail());
        $this->assertEquals('Test', $user->getFirstName());
        $this->assertEquals('User', $user->getLastName());
        $this->assertEquals(['ROLE_USER'], $user->getRoles());
    }

}