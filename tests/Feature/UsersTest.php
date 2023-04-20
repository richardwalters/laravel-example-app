<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Mockery\MockInterface;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_users_returns_a_successful_list_of_users(): void
    {
        $this->seed();
        $response = $this->get('/api/users');

        $response->assertStatus(200);
        $response
            ->assertJson(fn (AssertableJson $json) => $json->has('data', 11));
    }

    /**
     * A basic test example for users list one user.
     */
    public function test_get_a_users_returns_a_successful_user_from_the_list(): void
    {
        $user = User::factory()->create([
            'name' => 'Harry Potter',
            'email' => 'harrypotter@hogwarts.com',
        ]);
        $response = $this->get('/api/users');

        $response->assertStatus(200);
        $response
            ->assertJson(fn (AssertableJson $json) => $json->has('data', 1)
                ->has('data.0', fn (AssertableJson $json) => $json->where('id', $user->id)
                    ->where('name', 'Harry Potter')
                    ->where('email', 'harrypotter@hogwarts.com')
                    ->missing('password')
                    ->etc()
                )
            );
    }

    /**
     * Returns an empty list of users if no users available.
     */
    public function test_users_returns_a_successful_empty_list_of_users(): void
    {
        $response = $this->get('/api/users');

        $response->assertStatus(200);
        $response
            ->assertJson(fn (AssertableJson $json) => $json->has('data', 0));
    }

    /**
     * A basic test example for one user.
     */
    public function test_get_a_user_returns_a_successful_user(): void
    {
        $user = User::factory()->create([
            'name' => 'Harry Potter',
            'email' => 'harrypotter@hogwarts.com',
        ]);
        $response = $this->get("/api/user/{$user->id}");

        $response->assertStatus(200);
        $response
            ->assertJson(fn (AssertableJson $json) => $json->has('data', fn (AssertableJson $json) => $json->where('id', $user->id)
                ->where('name', 'Harry Potter')
                ->where('email', 'harrypotter@hogwarts.com')
                ->missing('password')
                ->etc()
            )
            );
    }

    /**
     * A basic test example for one user.
     */
    public function test_get_no_existent_user_returns_not_found(): void
    {
        $user = User::factory()->create([
            'name' => 'Harry Potter',
            'email' => 'harrypotter@hogwarts.com',
        ]);
        $response = $this->get('/api/user/100');

        $response->assertStatus(404);
        $response
            ->assertJson(fn (AssertableJson $json) => $json->where('message', 'Record not found.'));
    }

    public function test_users_returns_a_successful_list_of_users_with_mock(): void
    {
        $this->mock(UserService::class, function (MockInterface $mock) {
            $mock
                ->shouldReceive('getAll')
                ->once()
                ->andReturn([[
                    'id' => 12,
                    'name' => 'Hermione Granger',
                    'email' => 'hermionegranger@hogwarts.com',
                ]]);
        });

        $response = $this->get('/api/users_via_controller');
        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) => $json->has('data', 1)
            ->has('data.0', fn (AssertableJson $json) => $json->where('id', 12)
            ->where('name', 'Hermione Granger')
            ->where('email', 'hermionegranger@hogwarts.com')
            ->etc()
        ));
    }
}
