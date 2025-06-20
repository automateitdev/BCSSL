<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\RolePermissionSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            SystemUserSeeder::class,
            RolePermissionSeeder::class,
            DistictSeeder::class,
        ]);
        // \App\Models\User::factory(10)->create();
    }
}
