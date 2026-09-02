<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HomeController extends Controller
{
    private array $bnDigits = [
        '0' => '০', '1' => '১', '2' => '২', '3' => '৩', '4' => '৪',
        '5' => '৫', '6' => '৬', '7' => '৭', '8' => '৮', '9' => '৯',
    ];

    public function index(): Response
    {
        $navItems = buildNavbarItems();
        $posts = Post::published()
            ->with('category')
            ->latest('published_at')
            ->limit(6)
            ->get();
        $popularPosts = Post::published()->latest('published_at')->limit(4)->get();
        $topics = Category::active()->topLevel()->orderBy('name')->pluck('name')->toArray();

        $heroPost = null;
        $featurePost = null;
        $homeBanner = GetSetting('home_banner');

        $heroPostId = GetSetting('home_hero_post_id');
        if ($heroPostId) {
            $heroPost = Post::published()->with('category')->find($heroPostId);
        }

        $featurePostId = GetSetting('home_feature_post_id');
        if ($featurePostId) {
            $featurePost = Post::published()->with('category')->find($featurePostId);
        }

        return response()->view('home', [
            'navItems' => $navItems,
            'activeNav' => 'প্রচ্ছদ',
            'articles' => $posts,
            'topics' => $topics,
            'popularPosts' => $popularPosts,
            'heroPost' => $heroPost,
            'featurePost' => $featurePost,
            'homeBanner' => $homeBanner,
        ]);
    }

    public function about(): Response
    {
        $aboutValues = json_decode(GetSetting('about_values') ?? '[]', true) ?: [
            ['title' => 'সাহিত্যচর্চা', 'description' => 'গল্প, কবিতা, প্রবন্ধ ও বিভিন্ন ধরনের সাহিত্যকর্মকে একটি একক মঞ্চে এনে তোলা।', 'icon' => 'book'],
            ['title' => 'সম্প্রদায়', 'description' => 'পাঠক ও লেখকদের মধ্যে সংলাপ ও সম্পর্ক গড়ে তোলা।', 'icon' => 'users'],
            ['title' => 'সর্বজনীনতা', 'description' => 'সকলের জন্য উন্মুক্ত, যে কেউ পড়তে ও লিখতে পারবেন।', 'icon' => 'globe'],
        ];

        return response()->view('about', [
            'navItems' => buildNavbarItems(),
            'activeNav' => 'আমাদের সম্পর্কে',
            'about' => [
                'hero_label' => GetSetting('about_hero_label') ?: 'আমাদের সম্পর্কে',
                'hero_title' => GetSetting('about_hero_title') ?: 'উসুলি কী?',
                'hero_subtitle' => GetSetting('about_hero_subtitle') ?: 'উসুলি হলো বাংলা সাহিত্যের একটি অনলাইন জার্নাল, যেখানে গল্প, ভাবনা ও মানুষের কথা একত্রিত হয়।',
                'mission_title' => GetSetting('about_mission_title') ?: 'আমাদের লক্ষ্য',
                'mission_p1' => GetSetting('about_mission_p1') ?: 'উসুলির জন্ম হয়েছে বাংলা সাহিত্যকে সমৃদ্ধ করার একটি সাধারণ কামনা থেকে। আমরা বিশ্বাস করি, বাংলা ভাষায় লেখালেখির একটি সমৃদ্ধ ঐতিহ্য রয়েছে, এবং ডিজিটাল যুগে সেই ঐতিহ্যকে নতুন মানুষের কাছে পৌঁছে দেওয়া আমাদের দায়িত্ব।',
                'mission_p2' => GetSetting('about_mission_p2') ?: 'আমরা চাই যেন নতুন ও পুরনো লেখক, পাঠক ও সাহিত্যঅনুরাগীরা একটি জায়গায় একত্রিত হতে পারেন। গল্প পড়তে, লিখতে, এবং সাহিত্য নিয়ে কথা বলতে পারেন।',
                'values_title' => GetSetting('about_values_title') ?: 'আমাদের মূল্যবোধ',
                'values' => $aboutValues,
                'story_title' => GetSetting('about_story_title') ?: 'আমাদের গল্প',
                'story_p1' => GetSetting('about_story_p1') ?: 'উসুলি শুরু হয়েছিল একটি ছোট প্রকল্প হিসেবে। কয়েকজন লেখক ও সাহিত্যানুরাগী মিলে একটি এমন প্ল্যাটফর্ম তৈরি করার স্বপ্ন দেখেছিলেন, যেখানে বাংলা সাহিত্য নতুন উচ্চতায় পৌঁছাতে পারে।',
                'story_p2' => GetSetting('about_story_p2') ?: 'আজ উসুলি একটি ক্রমবর্ধমান সাহিত্যিক সম্প্রদায়ে রূপান্তরিত হয়েছে। এখানে অভিজ্ঞ লেখকদের পাশাপাশি নতুন লেখকরাও তাদের সৃষ্টি পাঠকের কাছে পৌঁছে দিতে পারেন।',
                'story_p3' => GetSetting('about_story_p3') ?: 'আমাদের বিশ্বাস — ভালো সাহিত্য সীমানা ভেঙে যায়, এবং উসুলি সেই সীমানা ভাঙতে সাহায্য করতে চায়।',
                'cta_title' => GetSetting('about_cta_title') ?: 'সাহিত্য কি আপনার প্রাণ?',
                'cta_subtitle' => GetSetting('about_cta_subtitle') ?: 'আমাদের সঙ্গে যুক্ত হতে চাইলে এখনই নিবন্ধন করুন অথবা যোগাযোগ করুন।',
                'cta_register_btn' => GetSetting('about_cta_register_btn') ?: 'নিবন্ধন করুন',
                'cta_contact_btn' => GetSetting('about_cta_contact_btn') ?: 'যোগাযোগ করুন',
            ],
        ]);
    }

    public function blog(Request $request): Response
    {
        $categorySlug = $request->input('category');

        $query = Post::published()->with('category');

        if ($categorySlug && $categorySlug !== 'all') {
            $query->whereHas('category', fn ($q) => $q->where('slug', $categorySlug));
        }

        $posts = $query->latest('published_at')->paginate(9)->withQueryString();

        $filters = Category::active()
            ->topLevel()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get()
            ->map(fn ($cat) => [
                'value' => $cat->slug,
                'label' => $cat->name,
                'active' => $categorySlug === $cat->slug,
            ])
            ->prepend(['value' => 'all', 'label' => 'সব', 'active' => ! $categorySlug || $categorySlug === 'all'])
            ->values()
            ->all();

        $totalBn = strtr((string) $posts->total(), $this->bnDigits);

        return response()->view('blog', [
            'navItems' => buildNavbarItems(),
            'activeNav' => 'গল্প',
            'totalBn' => $totalBn,
            'filters' => $filters,
            'posts' => $posts,
        ]);
    }

    public function show(Post $post): Response
    {
        $post->load('category', 'author');

        $related = Post::published()
            ->where('id', '!=', $post->id)
            ->when($post->category_id, fn ($q) => $q->where('category_id', $post->category_id))
            ->latest('published_at')
            ->limit(3)
            ->get();

        $comments = $post->comments()
            ->whereNull('parent_id')
            ->with(['user', 'replies.user', 'replies.admin'])
            ->latest()
            ->get();

        return response()->view('post', [
            'navItems' => buildNavbarItems(),
            'activeNav' => $post->category?->name ?? 'গল্প',
            'post' => $post,
            'related' => $related,
            'comments' => $comments,
        ]);
    }
}
