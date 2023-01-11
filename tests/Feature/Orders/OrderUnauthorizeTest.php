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

    /**
     * @test
     */
    public function cannot_save_orders_if_user_arenot_authenticated()
    {
        $response = $this->postJson(route('api.v1.commerces.order.index', 1), []);
        $response->assertUnauthorized();
    }

    /**
     * @test
     */
    public function cannot_get_single_order_if_user_arenot_authenticated()
    {
        $response = $this->getJson(route('api.v1.commerces.order.show', [1, 1]));
        $response->assertUnauthorized();
    }

    /**
     * @test
     */
    public function cannot_update_order_if_user_arenot_authenticated()
    {
        $response = $this->putJson(route('api.v1.commerces.order.update', [1, 1]));
        $response->assertUnauthorized();
    }
}
