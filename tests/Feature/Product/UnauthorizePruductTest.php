<?php

namespace Tests\Feature\Product;

use Database\Seeders\RolesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use App\Models\{User};
use Tests\TestCase;

class UnauthorizePruductTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function cannot_get_products_if_user_arenot_authenticated()
    {
        $response = $this->getJson(route('api.v1.products.index'));
        $response->assertUnauthorized();
    }

    /**
     * @test
     */
    public function cannot_get_product_if_user_arenot_authenticated()
    {
        $response = $this->getJson(route('api.v1.products.show', 1));
        $response->assertUnauthorized();
    }

    /**
     * @test
     */
    public function cannot_save_product_if_user_arenot_authenticated()
    {
        $response = $this->postJson(route('api.v1.products.store'), []);
        $response->assertUnauthorized();
    }

    /**
     * @test
     */
    public function cannot_update_product_if_user_arenot_authenticated()
    {
        $response = $this->putJson(route('api.v1.products.update', 1), []);
        $response->assertUnauthorized();
    }

    /**
     * @test
     */
    public function cannot_delete_product_if_user_arenot_authenticated()
    {
        $response = $this->deleteJson(route('api.v1.products.destroy', 1));
        $response->assertUnauthorized();
    }
}
