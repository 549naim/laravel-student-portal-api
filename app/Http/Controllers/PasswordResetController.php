<?php

namespace App\Http\Controllers;


use App\Models\PasswordResetToken;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class PasswordResetController extends Controller
{

    public function password_reset_email(Request $request){
        $request->validate([               
            'email' => 'required|email',
        ]);
        $email = $request->email;
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response([
                'message' => "Email doesnt exista",
                'status' => 'Failed',
            ], 404);       
        }

        $token = Str::random(60);
        PasswordResetToken::create([
            'email' => $request->email,
            'token' => $token,
            'created_at' =>Carbon::now()
        ]);

        // dump("http://127.0.0.1:3000/api/reset".$token);

        Mail::send('reset',['token' => $token] , function (Message $message)use($email){
            $message->subject("Reset your Password");
            $message->to($email);
        });

        return response([
            'message' => "Password reset email sent .....  Check your Email",
            'status' => 'Success',
        ], 401); 
    }

    public function reset(Request $request , $token){

        $expireToken = Carbon::now()->subMinutes(2)->toDateTimeString();
        PasswordResetToken::where('created_at', '<=' , $expireToken)->delete();
 
           
        $request->validate([               
            'password' => 'required|confirmed',
        ]);

        $passwordReset = PasswordResetToken::where('token' , $token)->first();
        if (!$passwordReset) {
            return response([
                'message' => "Token is invalid or expired",
                'status' => 'Failed',
            ], 404);       
        }
        $user = User::where('email', $passwordReset->email)->first();
        $user->password =Hash::make($request->password);
        $user->save();

        PasswordResetToken::where('email', $user->email)->delete();

        return response([
            'message' => "password changes successfully !!",
            'status' => 'success',
        ], 200); 

    }
    
}
