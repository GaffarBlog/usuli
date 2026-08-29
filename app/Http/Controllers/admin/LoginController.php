<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function index()
    {
        $user = User::first();
        if (! $user) {
            User::create([
                'name' => 'Abdul Gaffar',
                'email' => 'admin@gmail.com',
                'username' => 'admin@gmail.com',
                'phone' => '0123456789',
                'date_of_birth' => fake()->date(),
                'gender' => 'Male',
                'country' => 'Bangladesh',
                'city' => 'Bogura',
                'zip' => '5830',
                'address' => 'Bogura, Bangladesh',
                'status' => 'Active',
                'role_id' => 1,
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('123456'),
                'remember_token' => Str::random(10),
                'locale' => 'bn',
            ]);
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request::only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->route('admin.dashboard.view');
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }
}
