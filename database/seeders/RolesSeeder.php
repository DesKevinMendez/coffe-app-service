<?php

namespace Database\Seeders;

use App\Utils\Role as UtilsRole;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new UtilsRole;
        $roles = $role->getRoles();

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }
    }
}
