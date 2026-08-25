<?php

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

$articles = [
    [
        'category' => 'ভ্রমণ',
        'title' => 'বৃষ্টিভেজা বিকেলে ঢাকার অন্য এক শহর',
        'excerpt' => 'বৃষ্টি নামলেই শহরের চেনা রাস্তাগুলো যেন অন্য এক ভাষায় কথা বলে ওঠে।',
        'date' => '২৩ আগস্ট ২০২৬',
        'minutes' => '৫ মিনিট',
        'image' => 'https://images.unsplash.com/photo-1501691223387-dd0500403074?auto=format&fit=crop&w=800&q=70',
        'mediaClass' => 'bg-[linear-gradient(150deg,#2f8fa6,#1c525f)]',
    ],
    [
        'category' => 'সংস্কৃতি',
        'title' => 'বাংলার বইয়ের ঘ্রাণ এখনো কেন এত আপন',
        'excerpt' => 'পুরনো পাতার গন্ধে লুকিয়ে থাকে সময়, স্মৃতি আর অসংখ্য নিঃশব্দ বিকেল।',
        'date' => '২১ আগস্ট ২০২৬',
        'minutes' => '৭ মিনিট',
        'image' => 'https://images.unsplash.com/photo-1524578271613-d550eacf6090?auto=format&fit=crop&w=800&q=70',
        'mediaClass' => 'bg-[linear-gradient(150deg,#35707f,#21343a)]',
    ],
    [
        'category' => 'প্রযুক্তি',
        'title' => 'প্রযুক্তির ভেতরেও মানুষ খুঁজে ফেরে মানুষকে',
        'excerpt' => 'যন্ত্রের ভিড়ে দাঁড়িয়েও আমরা খুঁজি একটুখানি উষ্ণতা, একটুখানি সংযোগ।',
        'date' => '১৯ আগস্ট ২০২৬',
        'minutes' => '৪ মিনিট',
        'image' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=800&q=70',
        'mediaClass' => 'bg-[linear-gradient(150deg,#3a94a8,#244b52)]',
    ],
    [
        'category' => 'জীবনযাপন',
        'title' => 'এক কাপ চায়ের সঙ্গে কিছু অসমাপ্ত গল্প',
        'excerpt' => 'ধোঁয়া ওঠা কাপের পাশে বসে থাকে যত অসমাপ্ত কথা আর অলস দুপুর।',
        'date' => '১৭ আগস্ট ২০২৬',
        'minutes' => '৬ মিনিট',
        'image' => 'https://images.unsplash.com/photo-1447933601403-0c6688de566e?auto=format&fit=crop&w=800&q=70',
        'mediaClass' => 'bg-[linear-gradient(150deg,#297f96,#163f49)]',
    ],
    [
        'category' => 'গল্প',
        'title' => 'পুরনো রেডিওর গান আর একটি নিঃশব্দ দুপুর',
        'excerpt' => 'ভাঙা রেডিওর সুরে ফিরে আসে হারিয়ে যাওয়া এক শান্ত সময়ের ছবি।',
        'date' => '১৫ আগস্ট ২০২৬',
        'minutes' => '৮ মিনিট',
        'image' => 'https://images.unsplash.com/photo-1483412033650-1015ddeb83d1?auto=format&fit=crop&w=800&q=70',
        'mediaClass' => 'bg-[linear-gradient(150deg,#40899a,#223c42)]',
    ],
    [
        'category' => 'মতামত',
        'title' => 'শহরের আলো নিভে গেলে জেগে ওঠে যে জীবন',
        'excerpt' => 'রাত গভীর হলে শহরের আরেকটি রূপ ধীরে ধীরে চোখের সামনে খুলে যায়।',
        'date' => '১২ আগস্ট ২০২৬',
        'minutes' => '৫ মিনিট',
        'image' => 'https://images.unsplash.com/photo-1519501025264-65ba15a82390?auto=format&fit=crop&w=800&q=70',
        'mediaClass' => 'bg-[linear-gradient(150deg,#2c8397,#1a4a55)]',
    ],
    [
        'category' => 'বই',
        'title' => 'লাইব্রেরির নীরব বিকেলে হারিয়ে যাওয়া সময়',
        'excerpt' => 'আলমারির সারির ফাঁকে লুকিয়ে থাকে অজানা গল্প, অগোছালো স্মৃতি আর শান্ত একাকীত্ব।',
        'date' => '১০ আগস্ট ২০২৬',
        'minutes' => '৬ মিনিট',
        'image' => 'https://images.unsplash.com/photo-1507842217343-583bb7270b66?auto=format&fit=crop&w=800&q=70',
        'mediaClass' => 'bg-[linear-gradient(150deg,#35859a,#1e4550)]',
    ],
    [
        'category' => 'ভ্রমণ',
        'title' => 'নদীর চরে জেগে ওঠা এক রঙিন ভোর',
        'excerpt' => 'ভোরের আলোয় চরের বালু যেন সোনালি রূপ ধরে; জেগে ওঠে এক নতুন দিনের গল্প।',
        'date' => '৭ আগস্ট ২০২৬',
        'minutes' => '৫ মিনিট',
        'image' => 'https://images.unsplash.com/photo-1439066615861-d1af74d74000?auto=format&fit=crop&w=800&q=70',
        'mediaClass' => 'bg-[linear-gradient(150deg,#2f8fa6,#173e49)]',
    ],
    [
        'category' => 'প্রকৃতি',
        'title' => 'শীতের কুয়াশায় মোড়া গ্রামবাংলার সকাল',
        'excerpt' => 'কুয়াশার চাদরে মোড়া গ্রাম যেন থমকে থাকা এক নীরব ছবি, যেখানে সময় হাঁটে ধীরে।',
        'date' => '৩ আগস্ট ২০২৬',
        'minutes' => '৭ মিনিট',
        'image' => 'https://images.unsplash.com/photo-1470071459604-3b5ec3a7fe05?auto=format&fit=crop&w=800&q=70',
        'mediaClass' => 'bg-[linear-gradient(150deg,#40899a,#20343a)]',
    ],
];

$topics = ['গল্প', 'মতামত', 'সংস্কৃতি', 'জীবনযাপন', 'প্রযুক্তি', 'ভ্রমণ', 'বই', 'প্রকৃতি'];

$popular = [
    ['num' => '০১', 'title' => 'শহরের ভেতরে হারিয়ে যাওয়া কিছু বিকেল'],
    ['num' => '০২', 'title' => 'কেন আমরা এখনো চিঠি লিখতে ভালোবাসি'],
    ['num' => '০৩', 'title' => 'বাংলাদেশের ছোট শহরের বড় গল্প'],
    ['num' => '০৪', 'title' => 'বই পড়ার অভ্যাস কীভাবে বদলে যাচ্ছে'],
];

$picks = [
    ['num' => '০১', 'title' => 'মেঘের শহরে এক ভবঘুরে বিকেল'],
    ['num' => '০২', 'title' => 'ভাষার ভেতরে লুকিয়ে থাকা মানুষ'],
    ['num' => '০৩', 'title' => 'যে চিঠিগুলো কখনো পাঠানো হয়নি'],
    ['num' => '০৪', 'title' => 'সময়ের স্রোতে ভেসে যাওয়া নাম'],
];

$bnDigits = [
    '0' => '০', '1' => '১', '2' => '২', '3' => '৩', '4' => '৪',
    '5' => '৫', '6' => '৬', '7' => '৭', '8' => '৮', '9' => '৯',
];

$navItems = [
    ['label' => 'প্রচ্ছদ', 'href' => url('/')],
    ['label' => 'গল্প', 'href' => url('/blog')],
    ['label' => 'মতামত'],
    ['label' => 'জীবনযাপন'],
    ['label' => 'সংস্কৃতি'],
    ['label' => 'প্রযুক্তি'],
    ['label' => 'ভ্রমণ'],
];

Route::get('/', function () use ($articles, $topics, $popular, $picks, $navItems) {
    return view('home', [
        'navItems' => $navItems,
        'activeNav' => 'প্রচ্ছদ',
        'articles' => array_slice($articles, 0, 6),
        'topics' => $topics,
        'popular' => $popular,
        'picks' => $picks,
    ]);
})->name('home');

Route::get('/blog', function () use ($articles, $bnDigits, $navItems) {
    $filters = collect([['value' => 'all', 'label' => 'সব']])
        ->merge(collect($articles)->pluck('category')->unique()->values()
            ->map(fn ($category) => ['value' => $category, 'label' => $category]))
        ->map(fn ($filter, $index) => $filter + ['active' => $index === 0])
        ->all();

    return view('blog', [
        'navItems' => $navItems,
        'activeNav' => 'গল্প',
        'totalBn' => strtr((string) count($articles), $bnDigits),
        'filters' => $filters,
        'visibleArticles' => array_slice($articles, 0, 6),
        'extraArticles' => array_slice($articles, 6),
    ]);
})->name('blog');

Route::get('/admin', DashboardController::class)->name('admin.dashboard');
