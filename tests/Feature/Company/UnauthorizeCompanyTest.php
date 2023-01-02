<?php

namespace Tests\Feature\Company;

use Tests\TestCase;

class UnauthorizeCompanyTest extends TestCase
{
    /**
     * @test
     */
    public function cannot_get_companies_if_user_arenot_authenticated()
    {
        $response = $this->getJson(route('api.v1.companies.index'));
        $response->assertUnauthorized();
    }

    /**
     * @test
     */
    public function cannot_save_companies_if_user_arenot_authenticated()
    {
        $response = $this->postJson(route('api.v1.companies.store'), []);
        $response->assertUnauthorized();
    }
}
