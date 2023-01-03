<?php

namespace Tests\Feature\Company;

use App\Models\Commerce;
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

    /**
     * @test
     */
    public function can_get_only_one_company_with_commerces()
    {
        $company = Company::factory()
            ->has(Commerce::factory())
            ->create();

        $response = $this->getJson(route('api.v1.companies.show', $company->id));

        $response->assertOk()
            ->assertSee('commerces');
    }

    /**
     * @test
     */
    public function can_update_company()
    {
        $company = Company::factory()->create([
            'name' => 'Just for test'
        ]);
        $companyRaw = Company::factory()->raw();
        $response = $this->putJson(route('api.v1.companies.show', $company->id), $companyRaw);

        $response->assertOk()
            ->assertSee($companyRaw['name'])
            ->assertSee($companyRaw['description']);

        $this->assertDatabaseMissing('companies', [
            'name' => $company->name
        ]);

        $this->assertDatabaseHas('companies', [
            'name' => $companyRaw['name']
        ]);
    }

    /**
     * @test
     */
    public function can_delete_a_company_as_a_soft_delete()
    {
        $company = Company::factory()->create(['name' => 'test to delete']);
        $response = $this->deleteJson(route('api.v1.companies.destroy', $company->id));

        $response->assertNoContent();

        $this->assertSoftDeleted('companies', [
            'name' => 'test to delete'
        ]);
    }
}
