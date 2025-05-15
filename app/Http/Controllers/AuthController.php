<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    public function showLoginForm()
    {
        return view('login');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:3|confirmed',
            'role' => 'sometimes|in:anggota,petugas'
        ]);
        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role ?? 'anggota'
        ]);
        return response()->json([
            'token' => $user->createToken('auth_token')->plainTextToken,
            'user' => $user
        ],201);
    }

    public function login(Request $request)
    {

        $request->validate([
            'email'=>'required|email',
            'password'=> 'required'
        ]);


        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Login gagal'], 401);
        }

        $token = $user->createToken('api-token')->plainTextToken;
        // dd($request->user());


        return response()->json([
            'user' => $user,
            'token' => $token
        ]);


    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Berhasil logout']);
    }
}

