<?php

namespace Tests\Unit\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\usePaginate;
use App\Models\{Commerce, Order, Product,};
use App\Traits\{useSlug, useIsActive};
use Database\Seeders\RolesSeeder;
use Tests\TestCase;

class CommerceTest extends TestCase
{
    /**
     * @test
     */
    public function must_have_traits()
    {
        $this->assertClassUsesTrait(Commerce::class, HasFactory::class);
        $this->assertClassUsesTrait(Commerce::class, usePaginate::class);
        $this->assertClassUsesTrait(Commerce::class, SoftDeletes::class);
        $this->assertClassUsesTrait(Commerce::class, useSlug::class);
        $this->assertClassUsesTrait(Commerce::class, useIsActive::class);
    }

    /**
     * @test
     */
    public function model_must_have_products_relation_with_hasMany()
    {
        $this->seed(RolesSeeder::class);
        $this->signUp();

        $commerceCount = 5;
        $model = Commerce::factory()
            ->has(Product::factory()->count($commerceCount))
            ->create();

        $this->assertTrue($model->products[0] instanceof Product);
        $this->assertCount($commerceCount, $model->products);
    }


    /**
     * @test
     */
    public function model_must_have_orders_relation_with_hasMany()
    {
        $this->seed(RolesSeeder::class);
        $this->signUp();
        $commerceCount = 5;

        $model = Commerce::factory()
            ->has(Order::factory()->count($commerceCount))
            ->create();

        $this->assertTrue($model->orders[0] instanceof Order);
        $this->assertCount($commerceCount, $model->orders);
    }
}
