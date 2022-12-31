<?php

namespace Tests\Feature\Product;

use Database\Seeders\RolesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use App\Models\{Product, User};
use Tests\TestCase;

class PruductTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(RolesSeeder::class);

        $this->user = User::factory()->create();
        $this->user->assignRole('superadmin');

        Sanctum::actingAs(
            $this->user
        );
    }

    /**
     * @test
     */
    public function can_get_all_products()
    {
        Product::factory()->count(10)->create();
        $response = $this->getJson(route('api.v1.products.index'));

        $response->assertOk()
            ->assertJsonCount(10, 'data')
            ->assertSeeText(['links'])
            ->assertSeeText(['meta']);
    }

    /**
     * @test
     */
    public function can_get_only_one_product()
    {
        $product = Product::factory()->create();
        $response = $this->getJson(route('api.v1.products.show', $product->id));

        $response->assertOk()
            ->assertJsonFragment([
                'name' => $product->name,
                'uuid' => $product->uuid,
            ]);
    }

    /**
     * @test
     */
    public function can_save_products()
    {
        $product = Product::factory()->raw();

        $response = $this->postJson(route('api.v1.products.store'), $product);

        $response->assertCreated();

        $this->assertDatabaseHas('products', [
            'name' => $product['name'],
            'description' => $product['description'],
            'price' => $product['price'],
            'isUnit' => $product['isUnit'],
            'isActive' => $product['isActive'],
            'isTemporary' => $product['isTemporary'],
        ]);
    }

    /**
     * @test
     */
    public function product_name_must_be_required()
    {
        $product = Product::factory()->raw(['name' => '']);

        $response = $this->postJson(route('api.v1.products.store'), $product);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors('name');
    }

    /**
     * @test
     */
    public function when_we_save_product_description_can_be_null()
    {
        $productt = Product::factory()->raw(
            ['description' => null]
        );

        $response = $this->postJson(route('api.v1.products.store'), $productt);
        $response->assertCreated();
    }

    /**
     * @test
     */
    public function product_price_must_be_required()
    {
        $product = Product::factory()->raw(['price' => '']);

        $response = $this->postJson(route('api.v1.products.store'), $product);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors('price');
    }

    /**
     * @test
     */
    public function product_price_must_be_numeric()
    {
        $product = Product::factory()->raw(['price' => 'hola']);

        $response = $this->postJson(route('api.v1.products.store'), $product);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors('price');
    }

    /**
     * @test
     */
    public function product_price_must_be_greather_than_0()
    {
        $product = Product::factory()->raw(['price' => -1]);

        $response = $this->postJson(route('api.v1.products.store'), $product);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors('price');
    }

    /**
     * @test
     */
    public function product_isUnit_must_be_required()
    {
        $product = Product::factory()->raw(['isUnit' => '']);

        $response = $this->postJson(route('api.v1.products.store'), $product);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors('isUnit');
    }

    /**
     * @test
     */
    public function product_isUnit_must_be_a_boolean()
    {
        $product = Product::factory()->raw(['isUnit' => 'hola']);

        $response = $this->postJson(route('api.v1.products.store'), $product);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors('isUnit');
    }

    /**
     * @test
     */
    public function product_isActive_must_be_required()
    {
        $product = Product::factory()->raw(['isActive' => '']);

        $response = $this->postJson(route('api.v1.products.store'), $product);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors('isActive');
    }

    /**
     * @test
     */
    public function product_isActive_must_be_a_boolean()
    {
        $product = Product::factory()->raw(['isActive' => 'hola']);

        $response = $this->postJson(route('api.v1.products.store'), $product);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors('isActive');
    }

    /**
     * @test
     */
    public function product_isTemporary_must_be_required()
    {
        $product = Product::factory()->raw(['isTemporary' => '']);

        $response = $this->postJson(route('api.v1.products.store'), $product);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors('isTemporary');
    }

    /**
     * @test
     */
    public function product_isTemporary_must_be_a_boolean()
    {
        $product = Product::factory()->raw(['isTemporary' => 'hola']);

        $response = $this->postJson(route('api.v1.products.store'), $product);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors('isTemporary');
    }

    /**
     * @test
     */
    public function can_update_a_product()
    {

        $productRaw = Product::factory()->raw();
        $product = Product::factory()->create([
            'name' => 'only-for-test'
        ]);

        $response = $this->putJson(
            route('api.v1.products.update', $product->id), $productRaw
        );

        $response->assertOk();

        $this->assertDatabaseMissing('products', [
            'name' => 'only-for-test'
        ]);

        $this->assertDatabaseHas('products', [
            'name' => $productRaw['name']
        ]);
    }
}
