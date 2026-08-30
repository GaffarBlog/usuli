<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Setting;
use App\Services\SettingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();

        $heroPost = null;
        $featurePost = null;

        if (! empty($settings['home_hero_post_id'])) {
            $heroPost = Post::find($settings['home_hero_post_id']);
        }
        if (! empty($settings['home_feature_post_id'])) {
            $featurePost = Post::find($settings['home_feature_post_id']);
        }

        return view('admin.settings.index', compact('settings', 'heroPost', 'featurePost'));
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

        if ($tab === 'home') {
            $request->validate([
                'home_hero_post_id' => 'nullable|exists:posts,id',
                'home_feature_post_id' => 'nullable|exists:posts,id',
                'home_banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            ]);

            $service->set('home_hero_post_id', $request->home_hero_post_id, 'string');
            $service->set('home_feature_post_id', $request->home_feature_post_id, 'string');

            if ($request->file('home_banner')) {
                $service->set('home_banner', upload_file($request->file('home_banner'), 'settings', 'home-banner'), 'image');
            }
        }

        return redirect()->route('admin.settings.index', ['tab' => $tab])->with('success', 'সেটিংস সংরক্ষিত হয়েছে।');
    }

    public function searchPosts(Request $request): JsonResponse
    {
        $query = $request->input('q', '');

        $posts = Post::published()
            ->where('title', 'like', "%{$query}%")
            ->orWhere('slug', 'like', "%{$query}%")
            ->limit(10)
            ->get(['id', 'title', 'slug', 'image', 'excerpt']);

        return response()->json($posts);
    }
}
