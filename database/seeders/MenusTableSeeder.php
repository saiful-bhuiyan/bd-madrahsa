<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MenusTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('menus')->delete();

        \DB::table('menus')->insert(array (
            0 =>
            array (
                'id' => 1,
                'parent_id' => 0,
                'menu_name_en' => 'Dashboards',
                'menu_name_bn' => 'ড্যাশবোর্ড',
                'icon' => 'fa fa-home',
                'order_by' => 1,
                'route_name' => 'dashboard',
                'type' => 2,
                'status' => 1,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => '2023-06-12 16:13:28',
            ),
            1 =>
            array (
                'id' => 15,
                'parent_id' => 0,
                'menu_name_en' => 'Menu Management',
                'menu_name_bn' => 'মেনু ম্যানেজমেন্ট',
                'icon' => 'fa fa-bars',
                'order_by' => 2,
                'route_name' => NULL,
                'type' => 1,
                'status' => 1,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => '2023-06-08 09:32:24',
            ),
            2 =>
            array (
                'id' => 16,
                'parent_id' => 15,
                'menu_name_en' => 'Create Menu',
                'menu_name_bn' => 'মেনু তৈরী করুন',
                'icon' => NULL,
                'order_by' => 1,
                'route_name' => 'menu',
                'type' => 2,
                'status' => 1,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => '2023-06-07 15:37:40',
            ),
            3 =>
            array (
                'id' => 20,
                'parent_id' => 0,
                'menu_name_en' => 'Role Management',
                'menu_name_bn' => 'রোল ম্যানেজমেন্ট',
                'icon' => 'fa fa-user-md',
                'order_by' => 3,
                'route_name' => NULL,
                'type' => 1,
                'status' => 1,
                'deleted_at' => NULL,
                'created_at' => '2023-06-08 10:00:40',
                'updated_at' => '2023-06-08 10:00:40',
            ),
            4 =>
            array (
                'id' => 21,
                'parent_id' => 20,
                'menu_name_en' => 'Create Role',
                'menu_name_bn' => 'রোল তৈরি করুন',
                'icon' => NULL,
                'order_by' => 1,
                'route_name' => 'role',
                'type' => 2,
                'status' => 1,
                'deleted_at' => NULL,
                'created_at' => '2023-06-08 10:01:17',
                'updated_at' => '2023-06-08 10:01:17',
            ),
            5 =>
            array (
                'id' => 22,
                'parent_id' => 0,
                'menu_name_en' => 'Users',
                'menu_name_bn' => 'ইউজার',
                'icon' => 'fa fa-user',
                'order_by' => 3,
                'route_name' => NULL,
                'type' => 1,
                'status' => 1,
                'deleted_at' => NULL,
                'created_at' => '2023-06-11 04:44:20',
                'updated_at' => '2023-06-11 04:59:11',
            ),
            6 =>
            array (
                'id' => 23,
                'parent_id' => 22,
                'menu_name_en' => 'Create User',
                'menu_name_bn' => 'ইউজার তৈরি করুন',
                'icon' => 'fa-solid fa-user-plus',
                'order_by' => 1,
                'route_name' => 'user',
                'type' => 2,
                'status' => 1,
                'deleted_at' => NULL,
                'created_at' => '2023-06-11 04:47:15',
                'updated_at' => '2023-06-11 04:59:42',
            ),
            7 =>
            array (
                'id' => 24,
                'parent_id' => 0,
                'menu_name_en' => 'Product Setting',
                'menu_name_bn' => 'পণ্য সেটিং',
                'icon' => 'fa fa-gear',
                'order_by' => 5,
                'route_name' => NULL,
                'type' => 1,
                'status' => 1,
                'deleted_at' => NULL,
                'created_at' => '2023-06-13 11:23:09',
                'updated_at' => '2023-06-15 07:33:39',
            ),
            8 =>
            array (
                'id' => 25,
                'parent_id' => 24,
                'menu_name_en' => 'Categorie',
                'menu_name_bn' => 'ক্যাটাগরি',
                'icon' => NULL,
                'order_by' => 1,
                'route_name' => 'categorie',
                'type' => 2,
                'status' => 1,
                'deleted_at' => NULL,
                'created_at' => '2023-06-13 11:23:54',
                'updated_at' => '2023-06-15 07:41:18',
            ),
            9 =>
            array (
                'id' => 26,

                'parent_id' => 24,
                'menu_name_en' => 'Sub Categorie',
                'menu_name_bn' => 'সাব ক্যাটাগরি',
                'icon' => 'fa fa-diamond',
                'order_by' => 6,
                'route_name' => NULL,
                'type' => 1,
                'status' => 1,
                'deleted_at' => NULL,
                'created_at' => '2023-06-13 16:31:01',
                'updated_at' => '2023-06-13 16:40:01',
            ),
            10 =>
            array (
                'id' => 27,
                'parent_id' => 26,
                'menu_name_en' => 'Create Brand',
                'menu_name_bn' => 'ব্র্যান্ড তৈরি করুন',
                'icon' => 'fa fa-plus',
                'order_by' => 1,
                'route_name' => 'brand',
                'type' => 2,
                'status' => 1,
                'deleted_at' => NULL,
                'created_at' => '2023-06-13 16:41:51',
                'updated_at' => '2023-06-13 16:41:51',
            ),
            11 =>
            array (
                'id' => 28,
                'parent_id' => 24,
                'menu_name_en' => 'Sub Categorie',
                'menu_name_bn' => 'সাব ক্যাটগরি',
                'icon' => NULL,
                'order_by' => 2,
                'route_name' => 'sub_categorie',
                'type' => 2,
                'status' => 1,
                'deleted_at' => NULL,
                'created_at' => '2023-06-15 07:13:04',
                'updated_at' => '2023-06-15 07:13:04',
            ),
            12 =>
            array (
                'id' => 29,
                'parent_id' => 0,
                'menu_name_en' => 'Brand Setting',
                'menu_name_bn' => 'ব্রান্ড সেটিংস',
                'icon' => 'fa fa-diamond',
                'order_by' => 6,
                'route_name' => 'brand',
                'type' => 2,
                'status' => 1,
                'deleted_at' => NULL,
                'created_at' => '2023-06-15 07:14:00',
                'updated_at' => '2023-06-15 07:14:00',
            ),
            11 => 
            array (
                'id' => 30,
                'parent_id' => 24,
                'menu_name_en' => 'Size Setting',
                'menu_name_bn' => 'সাইজ সেটিংস',
                'icon' => NULL,
                'order_by' => 4,
                'route_name' => 'size_setting',
                'type' => 2,
                'status' => 1,
                'deleted_at' => NULL,
                'created_at' => '2023-06-15 07:44:25',
                'updated_at' => '2023-06-15 07:58:42',
            ),
        ));


    }
}
