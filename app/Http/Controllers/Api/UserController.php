<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::select('id', 'nama', 'email','alamat','nomor_telepon', 'role')->get();
        return response()->json($users);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'nullable|string|min:3', // optional password
            'alamat'=> 'required',
            'nomor_telepon' => 'required|digits_between:10,15',
            'role' => ['required', Rule::in(['Anggota', 'Petugas'])],
        ]);

        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password ?? 'password123'), // default password
            'alamat' => $request->alamat,
            'nomor_telepon'=> $request->nomor_telepon,
            'role' => $request->role,
        ]);

        return response()->json($user, 201);
    }

    public function show($id)
    {
        $user = User::select('id', 'nama', 'email','alamat','nomor_telepon', 'role')->findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:6',
            'alamat' => 'required',
            'nomor_telepon' => 'required|digits_between:10,15',
            'role' => ['required', Rule::in(['Anggota', 'Petugas'])],
        ]);

        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->alamat = $request->alamat;
        $user->nomor_telepon = $request->nomor_telepon;
        $user->role = $request->role;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return response()->json($user);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
}
