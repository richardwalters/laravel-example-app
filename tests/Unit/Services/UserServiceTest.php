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

        expect($users)->toHaveLength(1);
        expect($users[0])->toHaveKey('name', 'Hermione Granger');
        expect($users[0])->toHaveKey('email', 'hermionegranger@hogwarts.com');
    }
}
