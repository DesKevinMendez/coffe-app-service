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
}
