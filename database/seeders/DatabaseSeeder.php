<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(MenusTableSeeder::class);
        $this->call(ParentHasPermissionsTableSeeder::class);
        $this->call(ModuleHasPermissionsTableSeeder::class);
        $this->call(CountryInformationsTableSeeder::class);
        $this->call(DivisionInformationsTableSeeder::class);
        $this->call(DistrictInformationsTableSeeder::class);
        $this->call(UpazilaInformationsTableSeeder::class);
    }
}
