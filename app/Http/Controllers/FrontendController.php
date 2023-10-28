<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\sub_nav_information;
use App\Models\guest_user;
use App\Models\notice_board;
use Session;
use Hash;
use Auth;
use DB;
use GuzzleHttp\Promise\Create;

class FrontendController extends Controller
{
    public function index()
    {
        return view('frontend.layout.home');
    }

    public function informations($sub_nav_id)
    {
        $sub_nav_info = sub_nav_information::where('sub_nav_id',$sub_nav_id)->first();
        return view('frontend.informations',compact('sub_nav_info'));
    }

    public function notice_view($notice_id)
    {
        $notice = notice_board::where('id',$notice_id)->first();
        
        return view('frontend.notice_board',compact('notice'));
    }


    public function registration()
    {
        return view('frontend.auth.registration');
    }

    public function login_guest()
    {
        if(Auth::guard('guest')->check())
        {
            return view('frontend.auth.guest.home');
        }
        else{

            return view('frontend.auth.login');
        }
    }


   
}
