<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class LoginController extends Controller
{
    public function submit(Request $request){
        //validate the phone number
        $request-> validate([
            'phone'=> 'required|numeric|min:11',
        ]);

        //find or create a user model
        $user = User::firstOrCreate([
            'phone' => $request -> phone
        ]);

        if(!$user){
            return response()->json(['message' => 'could not process a user with that phone number.'], 401);

        };

        // send an  OTP

        //return back a response
    }
}
