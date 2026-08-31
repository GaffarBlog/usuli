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

        return response()->view('post', [
            'navItems' => buildNavbarItems(),
            'activeNav' => $post->category?->name ?? 'গল্প',
            'post' => $post,
            'related' => $related,
        ]);
    }

    public function contact(): Response
    {
        return response()->view('contact', [
            'navItems' => buildNavbarItems(),
            'activeNav' => 'যোগাযোগ',
        ]);
    }
}
