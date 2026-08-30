<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\SettingService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request, SettingService $service)
    {
        $tab = $request->tab ?? 'site';

        if ($tab === 'site') {
            $request->validate([
                'site_name' => 'required|string|max:255',
                'site_description' => 'nullable|string|max:1000',
                'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'phone' => 'nullable|string|max:18',
                'email' => 'nullable|email|max:255',
                'address' => 'nullable|string|max:1000',
            ]);

            $service->set('site_name', $request->site_name, 'string');
            $service->set('site_description', $request->site_description, 'text');
            $service->set('phone', $request->phone, 'string');
            $service->set('email', $request->email, 'string');
            $service->set('address', $request->address, 'text');

            if ($request->file('site_logo')) {
                $service->set('site_logo', upload_file($request->file('site_logo'), 'settings', 'site-logo'), 'image');
            }
        }

        return redirect()->route('admin.settings.index', ['tab' => $tab])->with('success', 'সেটিংস সংরক্ষিত হয়েছে।');
    }
}
