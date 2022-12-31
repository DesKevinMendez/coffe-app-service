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
}
