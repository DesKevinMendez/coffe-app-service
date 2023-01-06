<?php

namespace Tests\Feature\Orders;

use App\Models\{Commerce, Order};
use Database\Seeders\RolesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(RolesSeeder::class);

        $this->signUp();
    }

    /**
     * @test
     */
    public function can_get_all_order_by_commerce()
    {
        $commerce = Commerce::factory()
            ->has(Order::factory()->count(5))
            ->create();

        $response = $this->getJson(route('api.v1.commerces.order.index', $commerce->id));

        $response->assertOk()
            ->assertJsonCount(5, 'data')
            ->assertSeeText(['links'])
            ->assertSeeText(['meta']);
    }
}
