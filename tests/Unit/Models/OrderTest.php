<?php

namespace Tests\Unit\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\{usePaginate};
use App\Models\{Order, Product};
use Database\Seeders\RolesSeeder;
use Tests\TestCase;

class OrderTest extends TestCase
{
    /**
     * @test
     */
    public function must_have_traits()
    {
        $this->assertClassUsesTrait(Order::class, HasFactory::class);
        $this->assertClassUsesTrait(Order::class, usePaginate::class);
        $this->assertClassUsesTrait(Order::class, SoftDeletes::class);
    }


    /**
     * @test
     */
    public function model_must_have_products_relationships()
    {
        $this->seed(RolesSeeder::class);
        $this->signUp();
        $product = Product::factory()->create();
        $model = Order::factory()->create();
        $model->products()->attach($product->id);

        $this->assertInstanceOf(Product::class, $model->products()->first());
    }
}
