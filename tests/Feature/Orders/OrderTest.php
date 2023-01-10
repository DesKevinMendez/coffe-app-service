<?php

namespace Tests\Feature\Orders;

use App\Models\{Commerce, Order, Product};
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
        $product = Product::factory()->create();
        $commerce = Commerce::factory()
            ->create();

        $orderRaw = Order::factory()->raw();

        $response = $this->postJson(
            route('api.v1.commerces.order.store', $commerce->id),
            array_merge($orderRaw, [
                'products' => [$product->id]
            ])
        );

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
        $product = Product::factory()->create();

        Order::factory()->create(['order' => 1]);
        $orderRaw = Order::factory()->raw();

        $response = $this->postJson(
            route('api.v1.commerces.order.store', $commerce->id),
            array_merge($orderRaw, [
                'products' => [$product->id]
            ])
        );

        $response->assertCreated();

        $this->assertDatabaseHas('orders', [
            'commerce_id' => $commerce->id,
            'order' => 1,
            'user_id' => $this->user->id,
        ]);

        $product = Product::factory()->create();
        $response = $this->postJson(route('api.v1.commerces.order.store', $commerce->id), [
            ...$orderRaw, 'products' => [$product->id]
        ]);

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

        $product = Product::factory()->create();
        $response = $this->postJson(
            route('api.v1.commerces.order.store', $commerce->id),
            array_merge($orderRaw, [
                'products' => [$product->id]
            ])
        );

        $response->assertCreated();

        $this->assertDatabaseHas('orders', [
            'commerce_id' => $commerce->id,
            'order' => 1,
            'user_id' => $this->user->id,
        ]);

        $response = $this->postJson(
            route('api.v1.commerces.order.store', $commerce->id),
            array_merge($orderRaw, [
                'products' => []
            ])
        );

        $this->assertDatabaseHas('orders', [
            'commerce_id' => $commerce->id,
            'order' => 2,
            'user_id' => $this->user->id,
        ]);

        $newCommerce = Commerce::factory()
            ->create();
        $product = Product::factory()->create();

        $response = $this->postJson(
            route('api.v1.commerces.order.store', $newCommerce->id),
            array_merge($orderRaw, [
                'products' => [$product->id]
            ])
        );

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
            route('api.v1.commerces.order.store', 10),
            array_merge($orderRaw, [
                'products' => []
            ])
        );

        $response->assertNotFound();
    }

    /**
     * @test
     */
    public function can_save_a_new_order_with_products()
    {
        $products = Product::factory()->count(3)->create();
        $orderRaw = Order::factory()->raw();
        $commerce = Commerce::factory()
            ->create();

        $response = $this->postJson(
            route('api.v1.commerces.order.store', $commerce->id),
            array_merge($orderRaw, [
                'products' => [...$products->pluck('id')->toArray(),]
            ])
        );

        $response->assertCreated();

        $this->assertDatabaseHas(
            'order_product',
            [
                'order_id' => $response->json('data')['id'],
                'product_id' => $products[0]->id,
            ]
        );

        $this->assertDatabaseHas(
            'order_product',
            [
                'order_id' => $response->json('data')['id'],
                'product_id' => $products[1]->id,
            ]
        );

        $this->assertDatabaseHas(
            'order_product',
            [
                'order_id' => $response->json('data')['id'],
                'product_id' => $products[2]->id,
            ]
        );
    }

    /**
     * @test
     */
    public function cannot_save_a_new_order_if_producst_doesnt_array()
    {
        $orderRaw = Order::factory()->raw();
        $commerce = Commerce::factory()
            ->create();

        $response = $this->postJson(
            route('api.v1.commerces.order.store', $commerce->id),
            array_merge($orderRaw, [
                'products' => 1
            ])
        );

        $response->assertUnprocessable()
            ->assertJsonValidationErrors('products');
    }

    /**
     * @test
     */
    public function cannot_save_a_new_order_if_products_array_is_empty()
    {
        $orderRaw = Order::factory()->raw();
        $commerce = Commerce::factory()
            ->create();

        $response = $this->postJson(
            route('api.v1.commerces.order.store', $commerce->id),
            array_merge($orderRaw, [
                'products' => []
            ])
        );

        $response->assertUnprocessable()
            ->assertJsonValidationErrors('products');
    }

    /**
     * @test
     */
    public function cannot_save_a_new_order_if_products_array_have_unknow_id_for_products()
    {
        $orderRaw = Order::factory()->raw();
        $commerce = Commerce::factory()
            ->create();

        $response = $this->postJson(
            route('api.v1.commerces.order.store', $commerce->id),
            array_merge($orderRaw, [
                'products' => [100]
            ])
        );

        $response->assertUnprocessable()
            ->assertJsonValidationErrors('products.0');
    }
}
