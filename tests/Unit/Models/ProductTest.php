<?php

namespace Tests\Unit\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\usePaginate;
use App\Models\Product;
use App\Traits\useSlug;
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
}
