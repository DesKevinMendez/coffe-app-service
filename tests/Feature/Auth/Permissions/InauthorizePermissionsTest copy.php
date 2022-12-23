<?php

namespace Tests\Feature\Auth\Permissions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InauthorizePermissionsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function cannot_get_all_permissions_if_user_arenot_authenticated()
    {
        $response = $this->getJson(route('api.v1.permissions.index'));
        $response->assertUnauthorized()->assertSee('Unauthenticated.');
    }

    /**
     * @test
     */
    public function cannot_save_permissions_if_user_arenot_authenticated()
    {
        $response = $this->postJson(route('api.v1.permissions.store'), ['name' => 'name']);
        $response->assertUnauthorized();
    }

    /**
     * @test
     */
    public function cannot_show_permission_if_user_arenot_authenticated()
    {
        $response = $this->getJson(route('api.v1.permissions.show', 1));
        $response->assertUnauthorized();
    }

    /**
     * @test
     */
    public function cannot_update_permission_if_user_arenot_authenticated()
    {
        $response = $this->putJson(route('api.v1.permissions.update', 1));
        $response->assertUnauthorized();
    }
    /**
     * @test
     */
    public function cannot_delete_permission_if_user_arenot_authenticated()
    {
        $response = $this->putJson(route('api.v1.permissions.destroy', 1));
        $response->assertUnauthorized();
    }
}
