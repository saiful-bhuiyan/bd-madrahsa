<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\menu;
use App\Models\nav_item;
use App\Models\sub_nav_item;
use App\Models\banner_image;
use App\Models\teacher_crud;
use App\Models\academic_detail;
use App\Models\sub_academic_detail;
use App\Models\sub_nav_information;
use App\Models\notice_board;
use App\Models\role;
use View;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*',function($view){

            $view->with('menu',menu::orderby('order_by','ASC')->where('status',1)->get());

            $view->with('nav_item',nav_item::orderby('order_by','ASC')->where('status',1)->get());

            $view->with('sub_nav_item',sub_nav_item::orderby('order_by','ASC')->where('status',1)->get());

            $view->with('teacher_crud',teacher_crud::orderby('order_by','ASC')->where('status',1)->get());

            $view->with('banner_image',banner_image::orderby('order_by','ASC')->where('status',1)->get());

            $view->with('academic_detail',academic_detail::orderby('order_by','ASC')->where('status',1)->get());

            $view->with('sub_academic_detail',sub_academic_detail::where('status',1)->get());

            $view->with('sub_nav_information',sub_nav_information::where('status',1)->get());

            $view->with('notice_board',notice_board::where('status',1)->orderBy('created_at','DESC')->take(10)->get());




            // $view->with('role',role::find(Auth::user()->role_id));

            // $view->with('url',Route::current());

            $view->with('lang',\Illuminate\Support\Facades\App::getLocale());
        });
    }
}
