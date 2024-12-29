<?php

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserPassword extends TestCase
{
    public function testPasswordSetterAndGetter(): void
    {
        // Créer une instance de l'entité User
        $user = new User();

        $user->setPassword('my_secure_password');
        $this->assertEquals('my_secure_password', $user->getPassword());
    }
}