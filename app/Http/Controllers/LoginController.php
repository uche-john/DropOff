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
        $user -> notify(new \App\Notifications\LoginNeedsVerification());

        //return back a response
        return response()->json(['message' => 'OTP sent successfully.'], 200);
    }

    public function verify(Request $request){
        //validate the incoming request

        $request->validate([
            'phone' => 'required|numeric|min:11',
            'login_code' => 'required|numeric|between:100000,999999',
        ]);

        //find the user by phone number
        $user = User::where('phone', $request->phone)
        -> where('login_code', $request->login_code)
        ->first();

        //is the code valid?

        //if yes, log the user in and return a response
        if($user){
            $user->update(['login_code' => null]); // Clear the login code after successful verification
            return $user->createToken($request->login_code)->plainTextToken;
        }

        //if not , return an error response
        return response()->json(['message' => 'Invalid OTP or phone number.'], 401);


    }
}
