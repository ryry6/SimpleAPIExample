<?php

namespace App\Http\Controllers\API;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $validated_data = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(auth()->attempt($validated_data))
        { 
            $user = auth()->user(); 
            $success['token'] =  $user->createToken('ExampleAPI')->accessToken; 
            return response()->json(['success' => $success], 200); 
        } 
        else 
        { 
            return response()->json(['error'=>'Unauthorised credentials'], 401); 
        } 
    }

    /** 
    * Register api 
    * 
    * @return \Illuminate\Http\Response 
    */ 
    public function register(Request $request) 
    { 
        $validated_data = $request->validate([ 
            'name' => 'required', 
            'email' => 'required|email', 
            'password' => 'required', 
            'confirm_password' => 'required|same:password', 
        ]);

        $validated_data['password'] = bcrypt($validated_data['password']); 
        $user = User::create($validated_data); 
        $success['token'] =  $user->createToken('ExampleAPI')->accessToken; 
        $success['name'] =  $user->name;

        return response()->json(['success'=>$success], 200); 
    }
}
