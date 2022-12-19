<?php

namespace Tests\Feature\Auth\Permissions;

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
            ->assertJsonCount($this->countPermissions, 'data');
        dd($response->json());
    }
}
