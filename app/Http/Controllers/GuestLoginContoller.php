<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class GuestLoginContoller extends Controller
{
    public function guestLoginAttempt(Request $request)
    {
        // dd($request->all());
        if(Auth::guard('guest')->attempt(['email'=>$request->email,'password'=>$request->password]))
        {
            return redirect('/guest_dashboard');
        }
        else
        {
            return redirect()->back();
        }
    }

    public function guestLogout()
    {
        Auth::guard('guest')->logout();
        return redirect('/');
    }
}
