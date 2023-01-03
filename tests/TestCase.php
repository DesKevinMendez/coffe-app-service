<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function signUp($role = 'superadmin') {
        $this->user = User::factory()->create();
        $this->user->assignRole($role);

        Sanctum::actingAs(
            $this->user
        );
    }

    protected function assertClassUsesTrait($class, $trait)
    {
        $this->assertArrayHasKey(
            $trait,
            class_uses($class),
            "{$class} must use {$trait} trait"
        );
    }
}
