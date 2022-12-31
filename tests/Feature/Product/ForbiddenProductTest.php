<?php

namespace Tests\Feature\Product;

use Database\Seeders\RolesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use App\Models\{Product, User};
use Tests\TestCase;

class ForbiddenProductTest extends TestCase
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
    public function can_update_a_product_if_role_is_superadmin()
    {
        $this->signUp('superadmin');

        $productRaw = Product::factory()->raw();
        $product = Product::factory()->create();

        $response = $this->putJson(
            route('api.v1.products.update', $product->id), $productRaw
        );

        $response->assertOk();
    }

    /**
    * @test
    */
    public function cannot_update_a_product_if_role_is_admin_and_it_not_owner_of_product()
    {
        $this->signUp('admin');

        $productRaw = Product::factory()->raw();
        $product = Product::factory()->create();

        $product->user_id = User::factory()->create()->id;
        $product->update();

        $response = $this->putJson(
            route('api.v1.products.update', $product->id), $productRaw
        );

        $response->assertForbidden();
    }

    /**
    * @test
    */
    public function can_update_a_product_if_role_is_admin_and_its_your_product()
    {
        $this->signUp('admin');

        $productRaw = Product::factory()->raw([
            'user_id' => $this->user->id
        ]);
        $product = Product::factory()->create([
            'user_id' => $this->user->id
        ]);

        $response = $this->putJson(
            route('api.v1.products.update', $product->id), $productRaw
        );

        $response->assertOk();
    }

    /**
    * @test
    */
    public function cannot_update_a_product_if_role_is_casher()
    {
        $this->signUp('casher');

        $productRaw = Product::factory()->raw();
        $product = Product::factory()->create();

        $response = $this->putJson(
            route('api.v1.products.update', $product->id), $productRaw
        );

        $response->assertForbidden();
    }

    /**
    * @test
    */
    public function can_delete_a_product_if_role_is_superadmin()
    {
        $this->signUp('superadmin');

        $product = Product::factory()->create();

        $response = $this->deleteJson(
            route('api.v1.products.destroy', $product->id)
        );

        $response->assertNoContent();
    }


    /**
    * @test
    */
    public function cannot_delete_a_product_if_role_is_casher()
    {
        $this->signUp('casher');

        $product = Product::factory()->create();

        $response = $this->deleteJson(
            route('api.v1.products.destroy', $product->id)
        );

        $response->assertForbidden();
    }


    /**
    * @test
    */
    public function cannot_delete_a_product_if_role_is_admin_and_it_not_owner_of_product()
    {
        $this->signUp('admin');

        $product = Product::factory()->create();

        $product->user_id = User::factory()->create()->id;
        $product->update();

        $response = $this->deleteJson(
            route('api.v1.products.destroy', $product->id)
        );

        $response->assertForbidden();
    }

    /**
    * @test
    */
    public function can_delete_a_product_if_role_is_admin_and_its_your_product()
    {
        $this->signUp('admin');

        $product = Product::factory()->create([
            'user_id' => $this->user->id
        ]);

        $response = $this->deleteJson(
            route('api.v1.products.destroy', $product->id)
        );

        $response->assertNoContent();
    }
}
