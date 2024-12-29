<?php

namespace App\Tests;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserRolesTest extends TestCase
{
    public function testCustomRoles(): void
    {
        $user = new User();
        $user->setRoles(['ROLE_ADMIN']);
    
        // Vérifie que ROLE_ADMIN est bien présent
        $this->assertContains('ROLE_ADMIN', $user->getRoles());
    
        // Vérifie que ROLE_USER est également présent
        $this->assertContains('ROLE_USER', $user->getRoles());
    }
}

