<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testGetAuthenticatedUser()
    {
        $user = User::factory()->create();

        $response = $this->actingAs( $user )->get( '/user' );

        $response->assertStatus( 200 );
        $response->assertJson( [
            'id'   => $user->id,
            'name' => $user->name,
        ] );
    }

    public function testGetAllUsers()
    {
        $users = User::factory()->count( 3 )->create();
        $user  = $users->first();

        $response = $this->actingAs( $user )->get( '/users' );

        $response->assertStatus( 200 );
        $response->assertJsonCount( 3 );
    }

    public function testGetSingleUser()
    {
        $user = User::factory()->create();

        $response = $this->actingAs( $user )->get( "/users/{$user->id}" );

        $response->assertStatus( 200 );

        $response->assertJson( [
            'data' => [
                'id'   => $user->id,
                'name' => $user->name,
            ],
        ] );
    }

    public function testCreateUser()
    {
        $user = User::factory()->make();

        $response = $this->actingAs( $user )->post( '/users', [
            'name'                  => $user->name,
            'email'                 => $user->email,
            'password'              => $user->password,
            'password_confirmation' => $user->password,
        ] );

        $response->assertStatus( 201 );

        $this->assertDatabaseHas( 'users', [
            'name' => $user->name,
        ] );
    }

    public function testUpdateUser()
    {
        $user = User::factory()->create();

        $response = $this->actingAs( $user )->put( "/users/{$user->id}", [
            'email' => 'm1aladham@gmail.com',
            'name' => 'Mohammed Aladham',
        ] );

        $response->assertStatus( 200 );

        $this->assertDatabaseHas( 'users', [
            'id'   => $user->id,
            'name' => 'Mohammed Aladham',
        ] );
    }

    public function testDeleteUser()
    {
        $user = User::factory()->create();

        $response = $this->actingAs( $user )->delete( "/users/{$user->id}" );

        $response->assertStatus( 204 );

        $this->assertSoftDeleted( 'users', [
            'id' => $user->id,
        ] );
    }

}
