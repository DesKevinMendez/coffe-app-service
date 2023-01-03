<?php

namespace Tests\Unit\Models;

use App\Models\{Commerce, Company};
use App\Traits\{useIsActive, usePaginate, useSlug};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tests\TestCase;

class CompanyTest extends TestCase
{

    /**
     * @test
     */
    public function must_have_traits()
    {
        $this->assertClassUsesTrait(Company::class, HasFactory::class);
        $this->assertClassUsesTrait(Company::class, usePaginate::class);
        $this->assertClassUsesTrait(Company::class, SoftDeletes::class);
        $this->assertClassUsesTrait(Company::class, useSlug::class);
        $this->assertClassUsesTrait(Company::class, useIsActive::class);
    }

    /**
     * @test
     */
    public function model_must_have_commerce_relation_with_hasMany()
    {
        $commerceCount = 5;
        $model = Company::factory()
            ->has(Commerce::factory()->count($commerceCount))
            ->create();

        $this->assertTrue($model->commerces[0] instanceof Commerce);
        $this->assertCount($commerceCount, $model->commerces);
    }
}
