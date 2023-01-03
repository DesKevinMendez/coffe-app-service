<?php

namespace Tests\Feature\Commerce;

use Tests\TestCase;

class UnauthorizeCommerceTest extends TestCase
{
    /**
     * @test
     */
    public function cannot_get_companies_if_user_arenot_authenticated()
    {
        $response = $this->getJson(route('api.v1.commerces.index'));
        $response->assertUnauthorized();
    }

    /**
     * @test
     */
    public function cannot_save_companies_if_user_arenot_authenticated()
    {
        $response = $this->postJson(route('api.v1.commerces.store'), []);
        $response->assertUnauthorized();
    }

    /**
     * @test
     */
    public function cannot_get_one_company_if_user_arenot_authenticated()
    {
        $response = $this->getJson(route('api.v1.commerces.show', 1));
        $response->assertUnauthorized();
    }

    /**
     * @test
     */
    public function cannot_update_company_if_user_arenot_authenticated()
    {
        $response = $this->putJson(route('api.v1.commerces.update', 1), []);
        $response->assertUnauthorized();
    }

    /**
     * @test
     */
    public function cannot_delete_company_if_user_arenot_authenticated()
    {
        $response = $this->deleteJson(route('api.v1.commerces.destroy', 1));
        $response->assertUnauthorized();
    }
}
