<?php

namespace Tests\Unit\Services;

use App\Models\User;
use App\Services\UserService;
use Mockery;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_should_call_user_model(): void
    {
        $mockUser = Mockery::mock(User::class);
        $mockUser
            ->shouldReceive('all')
            ->once()
            ->andReturn([[
                'id' => 12,
                'name' => 'Hermione Granger',
                'email' => 'hermionegranger@hogwarts.com',
            ]]);

        $userService = new UserService($mockUser);
        $users = $userService->getAll();

        $this->assertCount(1, $users);
        $expectedUser = (array) $users[0];
        $this->assertArrayHasKey('name', $expectedUser);
        $this->assertEquals('Hermione Granger', $expectedUser['name']);
        $this->assertArrayHasKey('email', $expectedUser);
        $this->assertEquals('hermionegranger@hogwarts.com', $expectedUser['email']);

    }
}
