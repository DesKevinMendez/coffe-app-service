<?php

namespace Tests\Feature\Roles;

use App\Models\Roles;
use App\Models\SpatiePermissions;
use App\Models\User;
use App\Utils\Role;
use Database\Seeders\RolesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class RolesTest extends TestCase
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
    public function can_get_all_roles()
    {
        $roles = new Role();
        $response = $this->getJson(route('api.v1.roles.index'));
        $response->assertStatus(200)
            ->assertJsonCount(count($roles->getRoles()), 'data')
            ->assertSeeText(['links'])
            ->assertSeeText(['meta']);;
    }
}
