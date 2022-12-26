<?php

namespace Tests\Feature\Roles;

use Database\Seeders\RolesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use App\Models\{Roles, User};
use Tests\TestCase;

class ForbiddenRolesWithPermissionsTest extends TestCase
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
    public function cannot_get_roles_with_theirs_permissions_if_user_has_role_casher()
    {
        $role = Roles::first();
        $response = $this->getJson(route('api.v1.roles.permissions', $role->id));

        $response->assertForbidden();
    }
}
