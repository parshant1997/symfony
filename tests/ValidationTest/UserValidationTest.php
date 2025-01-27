<?php

namespace App\Tests\ValidationTest;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\User;

class UserValidationTest extends KernelTestCase
{
    private ValidatorInterface $validator;

    protected function setUp(): void
    {
        self::bootKernel();
        $container = self::getContainer();
        $this->validator = $container->get(ValidatorInterface::class);
    }

    public function testPasswordValidation(): void
    {
        $user = new User();
        $user->setPassword('short');
        $violations = $this->validator->validate($user);
        $this->assertGreaterThan(0, 1, 'Expected violations for invalid password.');
    }
}
