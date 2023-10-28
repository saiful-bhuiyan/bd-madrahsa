<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ParentHasPermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('parent_has_permissions')->delete();
        
        \DB::table('parent_has_permissions')->insert(array (
            0 => 
            array (
                'id' => 70,
                'role_id' => 2,
                'parent_id' => 15,
                'created_at' => '2023-08-09 11:05:55',
                'updated_at' => '2023-08-09 11:05:55',
            ),
            1 => 
            array (
                'id' => 71,
                'role_id' => 2,
                'parent_id' => 20,
                'created_at' => '2023-08-09 11:05:55',
                'updated_at' => '2023-08-09 11:05:55',
            ),
            2 => 
            array (
                'id' => 72,
                'role_id' => 2,
                'parent_id' => 22,
                'created_at' => '2023-08-09 11:05:55',
                'updated_at' => '2023-08-09 11:05:55',
            ),
            3 => 
            array (
                'id' => 73,
                'role_id' => 2,
                'parent_id' => 24,
                'created_at' => '2023-08-09 11:05:55',
                'updated_at' => '2023-08-09 11:05:55',
            ),
            4 => 
            array (
                'id' => 74,
                'role_id' => 2,
                'parent_id' => 31,
                'created_at' => '2023-08-09 11:05:55',
                'updated_at' => '2023-08-09 11:05:55',
            ),
            5 => 
            array (
                'id' => 75,
                'role_id' => 2,
                'parent_id' => 36,
                'created_at' => '2023-08-09 11:05:55',
                'updated_at' => '2023-08-09 11:05:55',
            ),
        ));
        
        
    }
}