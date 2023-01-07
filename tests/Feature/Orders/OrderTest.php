<?php

namespace Tests\Feature\Orders;

use App\Models\{Commerce, Order};
use Carbon\Carbon;
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

    /**
     * @test
     */
    public function can_save_a_new_order()
    {
        $commerce = Commerce::factory()
            ->create();

        $orderRaw = Order::factory()->raw();

        $response = $this->postJson(route('api.v1.commerces.order.store', $commerce->id), $orderRaw);

        $response->assertCreated();

        $this->assertDatabaseHas('orders', [
            'commerce_id' => $commerce->id,
            'user_id' => $this->user->id,
        ]);
    }

    /**
     * @test
     */
    public function can_save_a_new_order_and_order_must_be_sequence_of_order()
    {
        $commerce = Commerce::factory()
            ->create();

        $order = Order::factory()->create(['order' => 1]);
        $orderRaw = Order::factory()->raw();

        $response = $this->postJson(route('api.v1.commerces.order.store', $commerce->id), $orderRaw);

        $response->assertCreated();

        $this->assertDatabaseHas('orders', [
            'commerce_id' => $commerce->id,
            'order' => 1,
            'user_id' => $this->user->id,
        ]);

        $response = $this->postJson(route('api.v1.commerces.order.store', $commerce->id), $orderRaw);

        $this->assertDatabaseHas('orders', [
            'commerce_id' => $commerce->id,
            'order' => 2,
            'user_id' => $this->user->id,
        ]);
    }

    /**
     * @test
     */
    public function can_save_a_new_order_and_the_order_must_be_sequenced_of_order_by_day()
    {
        $commerce = Commerce::factory()
            ->create();
        $dayToSave = Carbon::now()->subDays();

        Order::factory()->create(
            [
                'order' => 1,
                'created_at' => $dayToSave,
                'commerce_id' => $commerce->id,
            ]
        );
        Order::factory()->create(
            [
                'order' => 2,
                'created_at' => $dayToSave,
                'commerce_id' => $commerce->id,
            ]
        );
        $orderRaw = Order::factory()->raw();

        $response = $this->postJson(
            route('api.v1.commerces.order.store', $commerce->id), $orderRaw
        );

        $response->assertCreated();

        $this->assertDatabaseHas('orders', [
            'commerce_id' => $commerce->id,
            'order' => 1,
            'user_id' => $this->user->id,
        ]);

        $response = $this->postJson(
            route('api.v1.commerces.order.store', $commerce->id), $orderRaw
        );

        $this->assertDatabaseHas('orders', [
            'commerce_id' => $commerce->id,
            'order' => 2,
            'user_id' => $this->user->id,
        ]);

        $newCommerce = Commerce::factory()
            ->create();
        $response = $this->postJson(route('api.v1.commerces.order.store', $newCommerce->id), $orderRaw);

        $this->assertDatabaseHas('orders', [
            'commerce_id' => $newCommerce->id,
            'order' => 1,
            'user_id' => $this->user->id,
        ]);
    }

    /**
     * @test
     */
    public function cannot_save_a_new_order_if_commerce_id_doesnt_exits()
    {
        $orderRaw = Order::factory()->raw();

        $response = $this->postJson(
            route('api.v1.commerces.order.store', 10), $orderRaw
        );

        $response->assertNotFound();
    }
}
