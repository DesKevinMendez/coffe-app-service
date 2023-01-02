<?php

namespace Tests\Feature\Company;

use App\Models\Company;
use Database\Seeders\RolesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyTest extends TestCase
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
    public function can_get_all_companies()
    {
        Company::factory()->count(10)->create(['isActive' => true]);
        $response = $this->getJson(route('api.v1.companies.index'));

        $response->assertOk()
            ->assertJsonCount(10, 'data')
            ->assertSeeText(['links'])
            ->assertSeeText(['meta']);
    }

    /**
     * @test
     */
    public function can_see_only_active_companies()
    {
        Company::factory()->count(2)->create(['isActive' => false]);
        Company::factory()->count(8)->create(['isActive' => true]);
        $response = $this->getJson(route('api.v1.companies.index'));

        $response->assertOk()
            ->assertJsonCount(8, 'data')
            ->assertSeeText(['links'])
            ->assertSeeText(['meta']);
    }

    /**
     * @test
     */
    public function can_save_a_company()
    {
        $company = Company::factory()->raw();
        $response = $this->postJson(route('api.v1.companies.store'), $company);

        $response->assertCreated();

        $this->assertDatabaseHas('companies', [
            'name' => $company['name'],
        ]);
    }

    /**
     * @test
     */
    public function name_must_be_required()
    {
        $company = Company::factory()->raw(['name' => '']);
        $response = $this->postJson(route('api.v1.companies.store'), $company);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors('name');
    }

    /**
     * @test
     */
    public function description_must_be_required()
    {
        $company = Company::factory()->raw(['description' => '']);
        $response = $this->postJson(route('api.v1.companies.store'), $company);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors('description');
    }

    /**
     * @test
     */
    public function address_must_be_required()
    {
        $company = Company::factory()->raw(['address' => '']);
        $response = $this->postJson(route('api.v1.companies.store'), $company);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors('address');
    }

    /**
     * @test
     */
    public function can_get_only_one_company()
    {
        $company = Company::factory()->create();
        $response = $this->getJson(route('api.v1.companies.show', $company->id));

        $response->assertOk()
            ->assertSee($company->name)
            ->assertSee($company->description);
    }
}
