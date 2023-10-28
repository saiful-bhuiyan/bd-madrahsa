<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('roles')->delete();

        \DB::table('roles')->insert(array (
            0 =>
            array (
                'id' => 2,
                'sl' => 1,
                'role_name_en' => 'Super Admin',
                'role_name_bn' => 'সুপার এডমিন',
                'status' => 1,
                'created_at' => '2023-06-10 09:50:14',
                'updated_at' => '2023-06-12 16:18:08',
            ),
            1 =>
            array (
                'id' => 3,
                'sl' => 2,
                'role_name_en' => 'Main Admin',
                'role_name_bn' => NULL,
                'status' => 1,
                'created_at' => '2023-06-10 10:46:53',
                'updated_at' => '2023-06-10 10:46:53',
            ),
        ));


    }
}
