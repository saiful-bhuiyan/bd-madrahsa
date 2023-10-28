<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BackendCotroller;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\NavItemController;
use App\Http\Controllers\SubNavItemController;
use App\Http\Controllers\BannerImageController;
use App\Http\Controllers\TeacherCrudController;
use App\Http\Controllers\AcademicDetailController;
use App\Http\Controllers\SubAcademicDetailController;
use App\Http\Controllers\SubNavInfoController;
use App\Http\Controllers\NoticeBoardController;
use App\Http\Controllers\BoardFinalResultController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\GuestLoginContoller;





/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });



Route::get('/',[FrontendController::class,'index']);
Route::get('/registration',[FrontendController::class,'registration']);
Route::get('/login_guest',[FrontendController::class,'login_guest']);
Route::post('/guestLoginAttempt',[GuestLoginContoller::class,'guestLoginAttempt']);
Route::get('/guestLogout',[GuestLoginContoller::class,'guestLogout']);

Route::post('/change_lang',[BackendCotroller::class,'change_lang']);

Route::get('/informations/{sub_nav_id}',[FrontendController::class,'informations']);

Route::get('/notice_view/{notice_id}',[FrontendController::class,'notice_view']);






Auth::routes();

Route::get('/change_pass',[BackendCotroller::class,'change_pass']);
Route::post('/submitChangeEmail',[BackendCotroller::class,'submitChangeEmail']);

Route::get('otp/{email}',[BackendCotroller::class,'otp']);
Route::post('submitOtp',[BackendCotroller::class,'submitOtp']);
Route::get('new_password/{email}',[BackendCotroller::class,'new_password']);
Route::post('changePassword',[BackendCotroller::class,'changePassword']);
Route::get('adminLogout',[BackendCotroller::class,'adminLogout']);


Route::group(['middleware' => 'auth'], function (){

    Route::get('/dashboard',[BackendCotroller::class,'index'])->middleware('auth');

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::resources([
        'menu'=>MenuController::class,
        'role'=>RoleController::class,
        'user'=>UserController::class,
        'color'=>ColorController::class,
        'nav_item'=>NavItemController::class,
        'sub_nav_item'=>SubNavItemController::class,
        'banner_image'=>BannerImageController::class,
        'teacher_crud'=>TeacherCrudController::class,
        'academic_detail'=>AcademicDetailController::class,
        'sub_academic_detail'=>SubAcademicDetailController::class,
        'sub_nav_information'=>SubNavInfoController::class,
        'notice_board'=>NoticeBoardController::class,
        'board_final_result'=>BoardFinalResultController::class,

    ]);



    Route::get('menuStatusChange/{id}',[MenuController::class,'menuStatusChange']);
    Route::get('retrive_menu/{id}',[MenuController::class,'retrive_menu']);
    Route::get('menu_per_delete/{id}',[MenuController::class,'menu_per_delete']);

    Route::get('roleStatusChange/{id}',[RoleController::class,'roleStatusChange']);
    Route::get('/permissions/{id}',[RoleController::class,'permissions']);
    Route::post('/setPermission',[RoleController::class,'setPermission']);

    Route::get('userStatusChange/{id}',[UserController::class,'userStatusChange']);

    Route::get('navItemStatusChange/{id}',[NavItemController::class,'navItemStatusChange']);
    Route::get('retrive_nav_item/{id}',[NavItemController::class,'retrive_nav_item']);
    Route::get('nav_item_per_delete/{id}',[NavItemController::class,'nav_item_per_delete']);

    Route::get('subNavItemStatusChange/{id}',[SubNavItemController::class,'subNavItemStatusChange']);
    Route::get('retrive_sub_nav_item/{id}',[SubNavItemController::class,'retrive_sub_nav_item']);
    Route::get('sub_nav_item_per_delete/{id}',[SubNavItemController::class,'sub_nav_item_per_delete']);

    Route::get('bannerImageStatusChange/{id}',[BannerImageController::class,'bannerImageStatusChange']);
    Route::get('retrive_banner_image/{id}',[BannerImageController::class,'retrive_banner_image']);
    Route::get('banner_image_per_delete/{id}',[BannerImageController::class,'banner_image_per_delete']);

    Route::get('teacherCrudStatusChange/{id}',[TeacherCrudController::class,'teacherCrudStatusChange']);
    Route::get('retrive_teacher_crud/{id}',[TeacherCrudController::class,'retrive_teacher_crud']);
    Route::get('teacher_crud_per_delete/{id}',[TeacherCrudController::class,'teacher_crud_per_delete']);

    Route::get('academicDetailStatusChange/{id}',[AcademicDetailController::class,'academicDetailStatusChange']);
    Route::get('retrive_academic_detail/{id}',[AcademicDetailController::class,'retrive_academic_detail']);
    Route::get('academic_detail_per_delete/{id}',[AcademicDetailController::class,'academic_detail_per_delete']);

    Route::get('subAcademicDetailStatusChange/{id}',[SubAcademicDetailController::class,'subAcademicDetailStatusChange']);
    Route::get('retrive_sub_academic_detail/{id}',[SubAcademicDetailController::class,'retrive_sub_academic_detail']);
    Route::get('sub_academic_detail_per_delete/{id}',[SubAcademicDetailController::class,'sub_academic_detail_per_delete']);

    Route::get('subNavInfoStatusChange/{id}',[SubNavInfoController::class,'subNavInfoStatusChange']);
    Route::get('/loadSubNavItem/{nav_id}',[SubNavInfoController::class,'loadSubNavItem']);

    Route::get('noticeBoardStatusChange/{id}',[NoticeBoardController::class,'noticeBoardStatusChange']);
    Route::get('retrive_notice_board/{id}',[NoticeBoardController::class,'retrive_notice_board']);
    Route::get('notice_board_per_delete/{id}',[NoticeBoardController::class,'notice_board_per_delete']);

    Route::get('boardFinalResultStatusChange/{id}',[BoardFinalResultController::class,'boardFinalResultStatusChange']);


    Route::get('colorStatusChange/{id}',[ColorController::class,'colorStatusChange']);
    Route::get('retrive_color/{id}',[ColorController::class,'retrive_color']);
    Route::get('color_per_delete/{id}',[ColorController::class,'color_per_delete']);



});

