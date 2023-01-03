<?php

namespace Tests\Feature\Auth;

// use App\Models\Permission;

use App\Models\Company;
use App\Models\SpatiePermissions;
use App\Models\User;
use Database\Seeders\RolesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\PersonalAccessToken;
use Tests\TestCase;

class LoginTest extends TestCase
{
  use RefreshDatabase;

  /**
   * @test
   */
  public function can_login_with_valid_credentials()
  {
    $user = User::factory()->create([]);

    $response = $this->postJson(route('api.v1.login'), [
      'email' => $user->email,
      'password' => 'password',
      'device_name' => 'iPhone of ' . $user->name
    ]);

    $token = $response->json('token');
    $this->assertNotNull(
      $dbToken = PersonalAccessToken::findToken($token),
      'the palin text token is invalid'
    );

    // $this->assertTrue($dbToken->can(''));
  }

  /**
   * @test
   */
  public function can_view_user_loged_with_their_role()
  {
    $this->seed(RolesSeeder::class);

    $user = User::factory()->create([]);
    $permissions = SpatiePermissions::factory()->count(5)->create();

    $user->assignRole(['admin', 'superadmin']);

    $role = $user->roles[0];
    $role2 = $user->roles[1];

    $role->givePermissionTo($permissions[0]->name);
    $role->givePermissionTo($permissions[1]->name);
    $role->givePermissionTo($permissions[2]->name);
    $role->givePermissionTo($permissions[3]->name);
    $role2->givePermissionTo($permissions[4]->name);


    $response = $this->postJson(route('api.v1.login'), [
      'email' => $user->email,
      'password' => 'password',
      'device_name' => 'iPhone of ' . $user->name
    ]);

    $response->assertSee($user->name)
    ->assertSee($user->email)
    ->assertJsonCount(2, 'user.roles')
    ->assertOk();

    $this->assertEquals(count($response->json()['user']['roles'][0]['permissions']), 4);
    $this->assertEquals(count($response->json()['user']['roles'][1]['permissions']), 1);
  }

  /**
   * @test
   */
  public function can_view_user_loged_with_their_company()
  {
    $this->seed(RolesSeeder::class);
    $company = Company::factory()->create();

    $user = User::factory()->create([
      'company_id' => $company->id,
    ]);

    $response = $this->postJson(route('api.v1.login'), [
      'email' => $user->email,
      'password' => 'password',
      'device_name' => 'iPhone of ' . $user->name
    ]);

    $response->assertSee($company->name)
    ->assertSee($company->description)
    ->assertOk();

    $this->assertArrayHasKey('company', $response->json());
  }

  /**
   * @test
   */
  public function cannot_login_with_invalid_credentials()
  {
    $response = $this->postJson(route('api.v1.login'), [
      'email' => 'kevin@dev.io',
      'password' => 'another password',
      'device_name' => 'iPhone'
    ]);

    $response->assertJsonValidationErrors('email');
  }

  /**
   * @test
   */
  public function email_is_required()
  {
    $this->postJson(route('api.v1.login'), [
      'email' => '',
      'password' => 'another password',
      'device_name' => 'iPhone'
    ])->assertSee(__('validation.required', ['attribute' => 'email']))
      ->assertStatus(422);
  }

  /**
   * @test
   */
  public function email_must_be_email()
  {
    $this->postJson(route('api.v1.login'), [
      'email' => 'a-new-email',
      'password' => 'another password',
      'device_name' => 'iPhone'
    ])->assertSee(__('validation.email', ['attribute' => 'email']))
      ->assertStatus(422);
  }

  /**
   * @test
   */
  public function password_is_required()
  {
    $this->postJson(route('api.v1.login'), [
      'email' => 'a-new-email',
      'password' => '',
      'device_name' => 'iPhone'
    ])->assertSee(__('validation.required', ['attribute' => 'password']))
      ->assertStatus(422);
  }

  /**
   * @test
   */
  public function device_name_is_required()
  {
    $this->postJson(route('api.v1.login'), [
      'email' => 'kevin@dev.io',
      'password' => 'password',
      'device_name' => ''
    ])->assertSee(__('validation.required', ['attribute' => 'device name']))
      ->assertStatus(422);
  }
}
