<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\user;

use Illuminate\Validation\ValidationException;

use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login (Request $request){
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Incorrect']
            ]);
        }

        return $user->createToken('Auth Token')->accessToken;
    }

    public function register(Request $request) {
        $this->validate($request, [
            "name" => "required|min:10",
            "email" => "required|email|unique:users",
            "password" => "required|min:6"
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $token = $user->createToken('FoodQoTodoUser')->accessToken;
        return response()->json(['token' => $token], 200);
    }
}
