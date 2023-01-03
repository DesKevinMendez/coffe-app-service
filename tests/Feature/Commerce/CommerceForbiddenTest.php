<?php

namespace Tests\Feature\Commerce;

use App\Models\{Commerce};
use Database\Seeders\RolesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommerceForbiddenTest extends TestCase
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
    public function cannot_get_all_commerces_if_user_not_is_superadmin()
    {
        $this->signUp('casher');
        $response = $this->getJson(route('api.v1.commerces.index'));
        $response->assertForbidden();

        $this->signUp('admin');
        $response = $this->getJson(route('api.v1.commerces.index'));
        $response->assertForbidden();
    }

    /**
     * @test
     */
    public function cannot_save_commerces_if_user_not_is_superadmin()
    {
        $this->signUp('casher');
        $commerceRaw = Commerce::factory()->raw();
        $response = $this->postJson(route('api.v1.commerces.store'), $commerceRaw);
        $response->assertForbidden();

        $this->signUp('admin');
        $commerceRaw = Commerce::factory()->raw();
        $response = $this->postJson(route('api.v1.commerces.store'), $commerceRaw);
        $response->assertForbidden();
    }

    /**
     * @test
     */
    public function cannot_get_a_single_commerce_if_user_not_is_superadmin()
    {
        $this->signUp('casher');
        $commerce = Commerce::factory()->create();
        $response = $this->getJson(route('api.v1.commerces.show', $commerce->id));
        $response->assertForbidden();

        $this->signUp('admin');
        $commerce = Commerce::factory()->create();
        $response = $this->getJson(route('api.v1.commerces.show', $commerce->id));
        $response->assertForbidden();
    }

    /**
     * @test
     */
    public function cannot_update_a_single_commerce_if_user_not_is_superadmin()
    {
        $this->signUp('casher');
        $commerce = Commerce::factory()->create();
        $commerceRaw = Commerce::factory()->raw();
        $response = $this->putJson(route('api.v1.commerces.update', $commerce->id), $commerceRaw);
        $response->assertForbidden();

        $this->signUp('admin');
        $commerce = Commerce::factory()->create();
        $response = $this->putJson(route('api.v1.commerces.update', $commerce->id), $commerceRaw);
        $response->assertForbidden();
    }

    /**
     * @test
     */
    public function cannot_delete_a_single_commerce_if_user_not_is_superadmin()
    {
        $this->signUp('casher');
        $commerce = Commerce::factory()->create();
        $response = $this->deleteJson(route('api.v1.commerces.destroy', $commerce->id));
        $response->assertForbidden();

        $this->signUp('admin');
        $commerce = Commerce::factory()->create();
        $response = $this->deleteJson(route('api.v1.commerces.destroy', $commerce->id));
        $response->assertForbidden();
    }
}
