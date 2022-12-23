<?php

namespace Tests\Feature\Roles;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InauthorizeRolesTest extends TestCase
{
    use RefreshDatabase;

    /**
    * @test
    */
    public function cannot_get_roles_if_user_arenot_authenticated()
    {
        $response = $this->getJson(route('api.v1.roles.index'));
        $response->assertUnauthorized();
    }
}
