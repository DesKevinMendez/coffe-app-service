<?php

namespace Tests\Feature\Company;

use App\Models\Company;
use Database\Seeders\RolesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ForbiddenTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(RolesSeeder::class);
    }

    /**
     * @test
     */
    public function cannot_get_all_companies_if_user_not_is_superadmin()
    {
        $this->signUp('casher');
        $response = $this->getJson(route('api.v1.companies.index'));
        $response->assertForbidden();

        $this->signUp('admin');
        $response = $this->getJson(route('api.v1.companies.index'));
        $response->assertForbidden();
    }

    /**
     * @test
     */
    public function cannot_save_company_if_user_not_is_superadmin()
    {
        $this->signUp('casher');
        $companyRaw = Company::factory()->raw();
        $response = $this->postJson(route('api.v1.companies.store'), $companyRaw);
        $response->assertForbidden();

        $this->signUp('admin');
        $companyRaw = Company::factory()->raw();
        $response = $this->postJson(route('api.v1.companies.store'), $companyRaw);
        $response->assertForbidden();
    }

    /**
     * @test
     */
    public function cannot_get_a_single_company_if_user_not_is_superadmin()
    {
        $this->signUp('casher');
        $company = Company::factory()->create();
        $response = $this->getJson(route('api.v1.companies.show', $company->id));
        $response->assertForbidden();

        $this->signUp('admin');
        $company = Company::factory()->create();
        $response = $this->getJson(route('api.v1.companies.show', $company->id));
        $response->assertForbidden();
    }

    /**
     * @test
     */
    public function cannot_update_a_single_company_if_user_not_is_superadmin()
    {
        $this->signUp('casher');
        $company = Company::factory()->create();
        $companyRaw = Company::factory()->raw();
        $response = $this->putJson(route('api.v1.companies.update', $company->id), $companyRaw);
        $response->assertForbidden();

        $this->signUp('admin');
        $company = Company::factory()->create();
        $response = $this->putJson(route('api.v1.companies.update', $company->id), $companyRaw);
        $response->assertForbidden();
    }

    /**
     * @test
     */
    public function cannot_delete_a_single_company_if_user_not_is_superadmin()
    {
        $this->signUp('casher');
        $company = Company::factory()->create();
        $response = $this->deleteJson(route('api.v1.companies.destroy', $company->id));
        $response->assertForbidden();

        $this->signUp('admin');
        $company = Company::factory()->create();
        $response = $this->deleteJson(route('api.v1.companies.destroy', $company->id));
        $response->assertForbidden();
    }
}
