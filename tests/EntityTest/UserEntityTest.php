<?php
namespace App\Tests\EntityTest;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserEntityTest extends KernelTestCase
{
    private ValidatorInterface $validator;
    private UserPasswordHasherInterface $passwordHasher;

    protected function setUp(): void
    {
        self::bootKernel();
        $container = self::getContainer();
        $this->validator = $container->get(ValidatorInterface::class);
    }


    public function testValidUser()
    {
        $user = new User();
        $user->setEmail('test@test.com');
        $user->setRoles(['ROLE_USER']);
        $user->setFirstName('test');
        $user->setLastName('test');
        $errors = $this->validator->validate($user);
        $this->assertCount(0, $errors, 'User entity should be valid.');
    }
}
