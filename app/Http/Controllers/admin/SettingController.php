<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
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

        $navbarItems = json_decode($settings['navbar_items'] ?? '[]', true);
        $footerMenuItems = json_decode($settings['footer_menu_items'] ?? '[]', true);
        $categories = Category::active()->topLevel()->orderBy('name')->get();

        return view('admin.settings.index', compact('settings', 'heroPost', 'featurePost', 'navbarItems', 'footerMenuItems', 'categories'));
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

        if ($tab === 'navbar') {
            $items = $request->input('navbar_items', []);

            $validated = collect($items)->map(function ($item) {
                $type = $item['type'] ?? '';

                return [
                    'type' => in_array($type, ['home', 'blog', 'category', 'about', 'contact']) ? $type : 'category',
                    'label' => $item['label'] ?? '',
                    'url' => $item['url'] ?? null,
                    'category_id' => isset($item['category_id']) ? (int) $item['category_id'] : null,
                    'enabled' => $type === 'category' ? true : ($item['enabled'] ?? true),
                ];
            })->toArray();

            $service->set('navbar_items', json_encode($validated), 'text');

            return redirect()->route('admin.settings.index', ['tab' => 'navbar'])->with('success', 'নেভার মেনু সংরক্ষিত হয়েছে।');
        }

        if ($tab === 'footer') {
            $request->validate([
                'footer_slogan' => 'nullable|string|max:500',
                'footer_copyright' => 'nullable|string|max:500',
            ]);

            $service->set('footer_slogan', $request->footer_slogan, 'text');
            $service->set('footer_copyright', $request->footer_copyright, 'text');

            $items = $request->input('footer_menu_items', []);

            $validated = collect($items)->map(function ($item) {
                return [
                    'label' => $item['label'] ?? '',
                    'url' => $item['url'] ?? '/',
                ];
            })->toArray();

            $service->set('footer_menu_items', json_encode($validated), 'text');

            return redirect()->route('admin.settings.index', ['tab' => 'footer'])->with('success', 'ফুটার সেটিংস সংরক্ষিত হয়েছে।');
        }

        if ($tab === 'social') {
            $request->validate([
                'social_facebook' => 'nullable|url|max:500',
                'social_twitter' => 'nullable|url|max:500',
                'social_instagram' => 'nullable|url|max:500',
                'social_youtube' => 'nullable|url|max:500',
                'social_telegram' => 'nullable|url|max:500',
            ]);

            $service->set('social_facebook', $request->social_facebook, 'string');
            $service->set('social_twitter', $request->social_twitter, 'string');
            $service->set('social_instagram', $request->social_instagram, 'string');
            $service->set('social_youtube', $request->social_youtube, 'string');
            $service->set('social_telegram', $request->social_telegram, 'string');
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

    public function searchCategories(Request $request): JsonResponse
    {
        $query = $request->input('q', '');
        $existing = $request->input('existing', []);

        $categories = Category::active()
            ->topLevel()
            ->whereNotIn('id', $existing)
            ->where('name', 'like', "%{$query}%")
            ->limit(10)
            ->get(['id', 'name', 'slug']);

        return response()->json($categories);
    }
}
