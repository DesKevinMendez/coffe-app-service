<?php

namespace Tests\Unit\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\{usePaginate};
use App\Models\{Order};
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
}
