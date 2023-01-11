<?php

namespace Tests\Unit\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\usePaginate;
use App\Models\{Order, Product};
use App\Traits\useSlug;
use Database\Seeders\RolesSeeder;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * @test
     */
    public function must_have_traits()
    {
        $this->assertClassUsesTrait(Product::class, HasFactory::class);
        $this->assertClassUsesTrait(Product::class, usePaginate::class);
        $this->assertClassUsesTrait(Product::class, SoftDeletes::class);
        $this->assertClassUsesTrait(Product::class, useSlug::class);
    }

    /**
     * @test
     */
    public function model_must_have_order_relationships()
    {
        $this->seed(RolesSeeder::class);
        $this->signUp();
        $model = Product::factory()->create();
        $order = Order::factory()->create();
        $model->orders()->attach($order->id);

        $this->assertInstanceOf(Order::class, $model->orders()->first());
    }
}
