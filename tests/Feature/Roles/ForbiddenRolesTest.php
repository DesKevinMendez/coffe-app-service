<?php

namespace Tests\Feature\Roles;

use Database\Seeders\RolesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use App\Models\{User};
use Tests\TestCase;

class ForbiddenRolesTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(RolesSeeder::class);

        $this->user = User::factory()->create();
        $this->user->assignRole('casher');

        Sanctum::actingAs(
            $this->user
        );
    }

    /**
    * @test
    */
    public function cannot_get_roles_if_user_has_role_casher()
    {
        $response = $this->getJson(route('api.v1.roles.index'));
        $response->assertForbidden();
    }
}
