<?php

namespace Database\Seeders;

use App\Models\AppPermission;
use Illuminate\Database\Seeder;

class AppPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = AppPermission::getDefaultPermissions();

        foreach ($permissions as $perm) {
            AppPermission::updateOrCreate(
                ['code' => $perm['code']],
                $perm
            );
        }
    }
}
