<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'pageTitle' => 'ড্যাশবোর্ড',
        ]);
    }

    // logout
    public function logout()
    {
        Auth::logout();

        return redirect()->route('admin.login.index');
    }
}
