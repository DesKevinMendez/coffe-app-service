<?php

namespace Tests\Feature\Roles;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UnauthorizeRolesWithPermissionsTest extends TestCase
{
    use RefreshDatabase;

    /**
    * @test
    */
    public function cannot_get_role_with_pemrissions_if_user_arenot_authenticated()
    {
        $response = $this->getJson(route('api.v1.roles.permissions', 1));

        $response->assertUnauthorized();
    }
}
