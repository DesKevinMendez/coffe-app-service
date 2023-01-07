<?php

namespace Tests\Feature\Orders;

use Database\Seeders\RolesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderUnauthorizeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function cannot_get_orders_if_user_arenot_authenticated()
    {
        $response = $this->getJson(route('api.v1.commerces.order.index', 1));
        $response->assertUnauthorized();
    }
}
