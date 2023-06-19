<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json('Invalid Credentials');
        }

        $token = $user->createToken($user->email)->plainTextToken;
        return ['token' => $token, 'token_type' => 'Bearer'];
    }
}
