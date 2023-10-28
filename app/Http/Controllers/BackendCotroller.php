<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\change_pass_otp;
use App\Models\menu;
use Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
Use App;

class BackendCotroller extends Controller
{

    public function index()
    {

        return view('backend.layouts.home');
    }

    public function change_pass()
    {
        return view('backend.layouts.change_pass');
    }

    public function submitChangeEmail(Request $request)
    {

        $check = User::where('email',$request->email)->count();

        if($check > 0)
        {
            $otp = rand(1000,9999);

            change_pass_otp::where('email',$request->email)->delete();

            change_pass_otp::create([
                'email'=>$request->email,
                'otp'=>$otp,
            ]);

            $data = array('name'=>"Virat Gandhi");

            // $reciver = $request->email;

            // $message = $otp;

            $mailData = array(
                'name'=>"Virat Gandhi",
                'subject'=>'Change Password',
                'reciver'=>$request->email,
                'sender'=>'supersaiful32@gmail.com',
                'body'=>'<center>
                <img src="https://sbit.com.bd/setting/1696451508034923.png" style="height:100px;width:100%;">
                <h2>Hello!</h2>
                    <b style="font-size:30px;">'.$otp.'</b><br>

                    <p>Heres Is Your OTP To Change Your Admin Password.</p>
                </center>',
            );

            Mail::send('mail', $mailData, function($message) use ($mailData) {
                $message->to($mailData['reciver'])->subject
                   ($mailData['subject']);
                $message->from($mailData['sender']);
             });

            Toastr::success('Check Your Email', 'Success');
            return redirect('/otp/'.$request->email);

        }
        else
        {
            Toastr::warning('Your Email Is Invalid', 'Warning');
            return redirect()->back();
        }
    }


    public function otp($email)
    {
        $otp = change_pass_otp::where('email',$email)->first();
        return view('backend.layouts.otp',compact('email','otp'));
    }

    public function submitOtp(Request $request)
    {
        // dd($request->all());

        $check = change_pass_otp::where('email',$request->email)->where('otp',$request->otp)->count();

        if($check > 0)
        {
            return redirect('/new_password/'.$request->email);
        }
        else
        {
            return redirect()->back();
        }
    }

    public function new_password($email)
    {
        return view('backend.layouts.new_password',compact(('email')));
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => 'min:3',
        ],[
            'password.min'=>'Password Must Be At Least 3 Character',
        ]);


        User::where('email',$request->email)->update([
            'password'=> Hash::make($request->password),
        ]);

        $this->guard()->logout();


        return redirect('/login');

    }

    protected function guard()
    {
        return Auth::guard();
    }

    protected function adminLogout()
    {
        Auth::guard()->logout();

        return redirect('/login');
    }


    public function change_lang(Request $request)
    {
        // return $request->lang;
        App::setLocale($request->lang);
        session()->put('locale', $request->lang);

        return redirect()->back();
    }
}
