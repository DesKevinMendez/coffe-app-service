<?php

namespace Tests\Unit\Models;

use App\Models\{User, Company};
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tests\TestCase;

class UserModelTest extends TestCase
{

    /**
     * @test
     */
    public function must_have_traits()
    {
        $this->assertClassUsesTrait(User::class, HasApiTokens::class);
        $this->assertClassUsesTrait(User::class, HasFactory::class);
        $this->assertClassUsesTrait(User::class, Notifiable::class);
        $this->assertClassUsesTrait(User::class, HasRoles::class);
    }

    /**
     * @test
     */
    public function model_must_have_company_relation()
    {
        $model = User::factory()->create();
        $this->assertInstanceOf(Company::class, $model->company);
        $this->assertIsObject($model->company);
    }
}
