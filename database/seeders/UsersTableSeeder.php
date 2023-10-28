<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Sumsul Karim',
                'email' => 'tanimchy417@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$glT0BuzWPY7fN8p90GVJmOS7eWLE3IQLEUI8YZx57csb9lIZIDfnW',
                'mobile' => NULL,
                'role_id' => 2,
                'image' => '919843015.png',
                'status' => 1,
                'remember_token' => NULL,
                'created_at' => '2023-05-31 09:49:45',
                'updated_at' => '2023-05-31 09:51:21',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Saiful',
                'email' => 'supersaiful18@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$yfQHX8hq1UyoHdDc1f45EuU9dk5IW7sFSc33pcSHe3DXSBzTPyr2u',
                'mobile' => '01856962458',
                'role_id' => 2,
                'image' => '919843015.png',
                'status' => 1,
                'remember_token' => NULL,
                'created_at' => '2023-06-11 10:25:56',
                'updated_at' => '2023-06-11 10:25:56',
            ),
        ));
        
        
    }
}