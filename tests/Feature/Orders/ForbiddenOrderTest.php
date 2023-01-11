<?php

namespace Tests\Feature\Orders;

use App\Models\{Product, Commerce, Order, User};
use Database\Seeders\RolesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ForbiddenOrderTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(RolesSeeder::class);

        $this->signUp('admin');
    }

    /**
    * @test
    */
    public function can_update_an_order_if_the_user_has_role_admin()
    {
        $commerce = Commerce::factory()
            ->create();
        $products = Product::factory()->count(2)->create([
            'commerce_id' => $commerce->id
        ]);
        $product = Product::factory()->create([
            'commerce_id' => $commerce->id
        ]);

        $orderRaw = Order::factory()->raw();

        $order = Order::factory()->create(
            ['commerce_id' => $commerce->id]
        );
        $order->products()->attach($product->id);

        $response = $this->putJson(
            route('api.v1.commerces.order.update', [$commerce->id, $order->id]),
            array_merge($orderRaw, [
                'products' => [...$products->pluck('id')->toArray(),]
            ])
        );

        $response->assertOk();
    }

    /**
    * @test
    */
    public function cannot_update_an_order_if_the_order_dont_belongs_to_logged_user()
    {
        $commerce = Commerce::factory()
            ->create();
        $products = Product::factory()->count(2)->create([
            'commerce_id' => $commerce->id
        ]);

        $orderRaw = Order::factory()->raw();

        $order = Order::factory()->create([
            'commerce_id' => $commerce->id
        ]);
        $order->user_id = User::factory()->create()->id;
        $order->update();

        $response = $this->putJson(
            route('api.v1.commerces.order.update', [$commerce->id, $order->id]),
            array_merge($orderRaw, [
                'products' => [...$products->pluck('id')->toArray(),]
            ])
        );

        $response->assertForbidden();
    }
}
