<?php

namespace Tests\Feature\Commerce;

use App\Models\{Commerce};
use Database\Seeders\RolesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommerceTest extends TestCase
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
    public function can_get_all_commerces()
    {
        Commerce::factory()->count(10)->create(['isActive' => true]);
        $response = $this->getJson(route('api.v1.commerces.index'));

        $response->assertOk()
            ->assertJsonCount(10, 'data')
            ->assertSeeText(['links'])
            ->assertSeeText(['meta']);
    }

    /**
     * @test
     */
    public function can_see_only_active_commerces()
    {
        Commerce::factory()->count(2)->create(['isActive' => false]);
        Commerce::factory()->count(8)->create(['isActive' => true]);
        $response = $this->getJson(route('api.v1.commerces.index'));

        $response->assertOk()
            ->assertJsonCount(8, 'data')
            ->assertSeeText(['links'])
            ->assertSeeText(['meta']);
    }

    /**
     * @test
     */
    public function can_save_a_commerce()
    {
        $company = Commerce::factory()->raw();
        $response = $this->postJson(route('api.v1.commerces.store'), $company);

        $response->assertCreated();

        $this->assertDatabaseHas('commerces', [
            'name' => $company['name'],
        ]);
    }

    /**
     * @test
     */
    public function name_must_be_required()
    {
        $company = Commerce::factory()->raw(['name' => '']);
        $response = $this->postJson(route('api.v1.commerces.store'), $company);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors('name');
    }

    /**
     * @test
     */
    public function description_must_be_required()
    {
        $company = Commerce::factory()->raw(['description' => '']);
        $response = $this->postJson(route('api.v1.commerces.store'), $company);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors('description');
    }

    /**
     * @test
     */
    public function address_must_be_required()
    {
        $company = Commerce::factory()->raw(['address' => '']);
        $response = $this->postJson(route('api.v1.commerces.store'), $company);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors('address');
    }

    /**
     * @test
     */
    public function can_get_only_one_company()
    {
        $company = Commerce::factory()->create();
        $response = $this->getJson(route('api.v1.commerces.show', $company->id));

        $response->assertOk()
            ->assertSee($company->name)
            ->assertSee($company->description);
    }

    /**
     * @test
     */
    public function can_update_company()
    {
        $company = Commerce::factory()->create([
            'name' => 'Just for test'
        ]);
        $companyRaw = Commerce::factory()->raw();
        $response = $this->putJson(route('api.v1.commerces.show', $company->id), $companyRaw);

        $response->assertOk()
            ->assertSee($companyRaw['name'])
            ->assertSee($companyRaw['description']);

        $this->assertDatabaseMissing('commerces', [
            'name' => $company->name
        ]);

        $this->assertDatabaseHas('commerces', [
            'name' => $companyRaw['name']
        ]);
    }

    /**
     * @test
     */
    public function can_delete_a_company_as_a_soft_delete()
    {
        $company = Commerce::factory()->create(['name' => 'test to delete']);
        $response = $this->deleteJson(route('api.v1.commerces.destroy', $company->id));

        $response->assertNoContent();

        $this->assertSoftDeleted('commerces', [
            'name' => 'test to delete'
        ]);
    }
}
