<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Tzsk\Otp\Facades\Otp;

class OTPController extends Controller
{
    public $user;
    public function __construct()
    {
        $this->user = auth()->user() ?? auth()->guard('admin')->user();
    }
    public function test()
    {
        return inertia('OTP/Test');
    }
    public function send()
    {
        $otp = Otp::generate($this->user->email);

        Mail::to($this->user->email)->send(new \App\Mail\SendOTP($otp));

        return inertia('OTP/Test', [ 'isSent' => true ]);
    }

    public function check(Request $request)
    {
        $validated = $request->validate([
            'otp' => 'required|string|min:4|max:8',
        ]);

        $bool = Otp::match( $validated['otp'], $this->user->email);
        
        if ( $bool ) return inertia('OTP/Success');
        if ( !$bool ) return redirect()->back()->withInput()->withErrors('otp', 'Wrong OTP code');
    }
}
