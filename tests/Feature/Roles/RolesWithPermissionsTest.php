<?php

namespace Tests\Feature\Roles;

use Database\Seeders\RolesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use App\Models\{Roles, SpatiePermissions, User};
use Tests\TestCase;

class RolesWithPermissionsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(RolesSeeder::class);

        $this->user = User::factory()->create();
        $this->user->assignRole('superadmin');

        Sanctum::actingAs(
            $this->user
        );
    }

    /**
     * @test
     */
    public function can_get_role_with_theirs_permissions()
    {
        $role = Roles::create(['name' => 'testing']);
        $permissions = SpatiePermissions::factory()->count(5)->create();

        $role->givePermissionTo($permissions[0]->name);
        $role->givePermissionTo($permissions[1]->name);
        $role->givePermissionTo($permissions[2]->name);
        $role->givePermissionTo($permissions[3]->name);
        $role->givePermissionTo($permissions[4]->name);

        $response = $this->getJson(route('api.v1.roles.permissions', $role->id));

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'testing'])
            ->assertJsonCount(5, 'data.permissions');
    }
}
