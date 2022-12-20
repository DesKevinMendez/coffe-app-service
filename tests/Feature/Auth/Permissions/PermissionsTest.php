<?php

namespace Tests\Feature\Auth\Permissions;

use App\Models\SpatiePermissions;
use App\Models\User;
use App\Utils\Role;
use Database\Seeders\PermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PermissionsTest extends TestCase
{
    private $countPermissions = 0;

    public function setUp(): void
    {
        $role = new Role;

        $this->countPermissions = count($role->getPermissions());

        parent::setUp();
        $this->user = User::factory()->create();
        Sanctum::actingAs(
            $this->user
        );
        $this->seed(PermissionsSeeder::class);
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
        $response->assertStatus(422)
            ->assertJsonValidationErrors('name');
    }
}
