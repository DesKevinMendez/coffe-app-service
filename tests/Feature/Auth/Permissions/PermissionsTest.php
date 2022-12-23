<?php

namespace Tests\Feature\Auth\Permissions;

use App\Models\{SpatiePermissions, User};
use App\Utils\Role;
use Database\Seeders\{PermissionsSeeder, RolesSeeder};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PermissionsTest extends TestCase
{
    use RefreshDatabase;

    private $countPermissions = 0;

    public function setUp(): void
    {
        $role = new Role;

        $this->countPermissions = count($role->getPermissions());

        parent::setUp();

        $this->seed(PermissionsSeeder::class);
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
    public function can_get_all_permissions()
    {
        $response = $this->getJson(route('api.v1.permissions.index'));
        $response->assertStatus(200)
            ->assertJsonCount($this->countPermissions, 'data')
            ->assertSeeText(['links'])
            ->assertSeeText(['meta']);
    }

    /**
     * @test
     */
    public function can_save_permissions()
    {
        $params = SpatiePermissions::factory()->raw();
        $response = $this->postJson(route('api.v1.permissions.store'), $params);
        $response->assertStatus(201);

        $this->assertDatabaseHas('permissions', [
            'name' => $params['name']
        ]);
    }

    /**
     * @test
     */
    public function name_must_be_required()
    {
        $response = $this->postJson(route('api.v1.permissions.store'), ['name' => '']);
        $response->assertUnprocessable()
            ->assertJsonValidationErrors('name');
    }

    /**
     * @test
     */
    public function can_get_permission_by_id()
    {
        $permission = SpatiePermissions::create(['name' => 'test']);
        $response = $this->getJson(route('api.v1.permissions.show', $permission->id));
        $response->assertOk()
            ->assertSee('data');
    }

    /**
     * @test
     */
    public function can_update_permission_by_id()
    {
        $permission = SpatiePermissions::create(['name' => 'test']);
        $response = $this->putJson(route('api.v1.permissions.show', $permission->id), [
            'name' => 'another-test-name'
        ]);
        $response->assertOk();

        $this->assertDatabaseMissing('permissions', ['name' => 'test']);
        $this->assertDatabaseHas('permissions', ['name' => 'another-test-name']);
    }

    /**
     * @test
     */
    public function cannot_update_permission_by_id_if_name_is_empty()
    {
        $permission = SpatiePermissions::create(['name' => 'test']);
        $response = $this->putJson(route('api.v1.permissions.update', $permission->id), [
            'name' => ''
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors('name');
    }

    /**
     * @test
     */
    public function can_delete_a_permission_as_a_soft_delete()
    {
        $permission = SpatiePermissions::create(['name' => 'test to delete']);
        $response = $this->deleteJson(route('api.v1.permissions.destroy', $permission->id));

        $response->assertNoContent();

        $this->assertSoftDeleted('permissions', [
            'name' => 'test to delete'
        ]);
    }
}
