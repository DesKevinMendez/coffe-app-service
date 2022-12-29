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
}
