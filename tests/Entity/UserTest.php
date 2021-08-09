<?php

namespace App\Tests\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testSetAndGetFirstName(): void
    {
        $user = new User();
        $user->setFirstName('George');
        $this->assertSame('George', $user->getFirstName());
    }
}