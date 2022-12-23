<?php

namespace Database\Seeders;

use App\Utils\Role as UtilsRole;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\{Permission};

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new UtilsRole;
        $permissions = $role->getPermissions();

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
