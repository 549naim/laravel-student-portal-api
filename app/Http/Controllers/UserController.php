<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' =>  'required|email|max:255',
            'password' => 'required| min:4| max:17 |confirmed',
            'tc' => 'required'

        ]);

        if (User::where('email', $request->email)->first()) {
            return response([
                'message' => "Email already exixts",
                'success' => false,
            ]);
        }


        // $data = new User;
        // $data->name = $request->name;
        // $data->email = $request->email;
        // $data->password = Hash::make($request->password);
        // $data->tc = json_decode($request->tc);
        // $data->save();
        // return response([
        //     'message' => "Registration Successful",
        //     'status' => 'Success',
        // ], 201);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'tc' => json_decode($request->tc)
        ]);

        $token  = $user->createToken($request->email)->plainTextToken;


        return response([
            'user_data'=>$user,
            'token' => $token,
            'message' => "Registration Successful",
            'success' => true,
        ]);
    }


    public function login(Request $request)
    {
        $request->validate([
           
            'email' =>  'required|email|max:255',
            'password' => 'required| min:4| max:17',

        ]);
        

        $user = User::where(['email' => $request->email])->first();
        if ($user && Hash::check($request->password, $user->password)) {
            $token  = $user->createToken($request->email)->plainTextToken;

            return response([
                'user_data'=>$user,
                'token' => $token,
                'message' => "Login Successful",
                'success' => true,
            ]);
        }
        return response([

            'message' => "Provided Credintians are incorrect",
            'success' => false,
        ]);
    }

    public function logout(){
        
        return response ([
            'message' => 'user logged out',
            'success' => true,
        ]);
    }

    public function change_password(Request $request ){
        $request->validate([      
            'old_password'=>'required',   
            'password' => 'required| min:4| max:17|confirmed',
        ]);
        $loggedUser = auth()->user();
        if ( Hash::check($request->old_password, $loggedUser->password)){
            $loggedUser->password =Hash::make($request->password);
            $loggedUser->save();
            return response ([
                'message' => 'password changeed succesfully',
                'status' => 'success',
            ]);
        }
        return response ([
            'message' => 'old password doesnot match',
            'status' => 'failed',
        ],404);

        
    }





}
