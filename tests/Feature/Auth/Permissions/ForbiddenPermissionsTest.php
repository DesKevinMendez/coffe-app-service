<?php

namespace Tests\Feature\Auth\Permissions;

use App\Models\SpatiePermissions;
use App\Models\User;
use Database\Seeders\{PermissionsSeeder, RolesSeeder};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ForbiddenPermissionsTest extends TestCase
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
    public function cannot_get_all_permissions_if_user_has_role_casher()
    {
        $response = $this->getJson(route('api.v1.permissions.index'));
        $response->assertForbidden();
    }

    /**
     * @test
     */
    public function cannot_save_permissions_if_user_has_role_casher()
    {
        $response = $this->postJson(route('api.v1.permissions.store'), ['name' => 'name']);
        $response->assertForbidden();
    }

    /**
     * @test
     */
    public function cannot_show_permission_if_user_has_role_casher()
    {
        $permission = SpatiePermissions::create(['name' => 'test']);

        $response = $this->getJson(route('api.v1.permissions.show', $permission->id));
        $response->assertForbidden();
    }

    /**
     * @test
     */
    public function cannot_update_permission_if_user_has_role_casher()
    {
        $permission = SpatiePermissions::create(['name' => 'test']);
        $response = $this->putJson(route('api.v1.permissions.show', $permission->id), [
            'name' => 'another-test-name'
        ]);
        $response->assertForbidden();
    }
    /**
     * @test
     */
    public function cannot_delete_permission_if_user_has_role_casher()
    {
        $permission = SpatiePermissions::create(['name' => 'test']);
        $response = $this->putJson(route('api.v1.permissions.destroy', $permission->id), [
            'name' => 'test'
        ]);
        $response->assertForbidden();
    }
}
