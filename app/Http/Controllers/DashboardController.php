<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    private array $navItems = [
        ['label' => 'প্রচ্ছদ', 'href' => '/'],
        ['label' => 'গল্প', 'href' => '/blog'],
        ['label' => 'মতামত'],
        ['label' => 'জীবনযাপন'],
        ['label' => 'সংস্কৃতি'],
        ['label' => 'প্রযুক্তি'],
        ['label' => 'ভ্রমণ'],
    ];

    public function index(): Response
    {
        $user = Auth::guard('frontend')->user();

        return response()->view('frontend.dashboard.index', [
            'navItems' => $this->navItems,
            'user' => $user,
            'activeNav' => 'ড্যাশবোর্ড',
        ]);
    }

    public function editProfile(): Response
    {
        $user = Auth::guard('frontend')->user();

        return response()->view('frontend.dashboard.profile', [
            'navItems' => $this->navItems,
            'user' => $user,
            'activeNav' => 'প্রোফাইল',
        ]);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $user = Auth::guard('frontend')->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:frontend_users,email,'.$user->id,
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
        ];

        if ($request->file('avatar')) {
            $data['images'] = upload_file($request->file('avatar'), 'frontend_users', $user->name);
        }

        $user->update($data);

        return redirect()->route('frontend.dashboard.profile')->with('success', 'প্রোফাইল আপডেট হয়েছে।');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $user = Auth::guard('frontend')->user();

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if (! Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'বর্তমান পাসওয়ার্ড সঠিক নয়।']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('frontend.dashboard.profile')->with('success', 'পাসওয়ার্ড পরিবর্তন হয়েছে।');
    }

    public function writerRequest(): Response
    {
        $user = Auth::guard('frontend')->user();

        return response()->view('frontend.dashboard.writer', [
            'navItems' => $this->navItems,
            'user' => $user,
            'activeNav' => 'লেখক অনুরোধ',
        ]);
    }

    public function submitWriterRequest(Request $request): RedirectResponse
    {
        $user = Auth::guard('frontend')->user();

        if ($user->writer_request_status === 'pending') {
            return back()->withErrors(['reason' => 'আপনার আবেদন ইতিমধ্যে পর্যালোচনাধীন রয়েছে।']);
        }

        $validated = $request->validate([
            'reason' => 'required|string|min:20|max:1000',
        ]);

        $user->update([
            'writer_request_status' => 'pending',
            'writer_request_reason' => $validated['reason'],
            'writer_requested_at' => now(),
        ]);

        return redirect()->route('frontend.dashboard.writer')->with('success', 'আপনার লেখক অনুরোধ জমা দেওয়া হয়েছে। অ্যাডমিন শীঘ্রই পর্যালোচনা করবেন।');
    }
}
