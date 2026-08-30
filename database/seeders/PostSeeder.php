<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::withoutGlobalScope('superAdmin')->where('slug', 'super-admin')->first();

        $author = User::create([
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

        $posts = [
            // আকিদাহ
            ['category_slug' => 'akidah', 'title' => 'তাওহীদের মূলনীতি', 'content' => 'ইসলামে আল্লাহ একক, তিনিই একমাত্র উপাস্য। এটিই আকিদাহর ভিত্তি।'],
            ['category_slug' => 'akidah', 'title' => 'ইমানের শানাত', 'content' => 'ইমানের ছয়টি শানাত হলো: আল্লাহ, ফেরেশতা, কিতাব, রাসূল, আখেরাত ও তাকদীর।'],
            // কুরআন
            ['category_slug' => 'quran', 'title' => 'সূরা ফাতিহা তাৎপর্য', 'content' => 'সূরা ফাতিহা কুরআনের সূরা। এটি প্রতিদিনের নামাজে পড়া হয়।'],
            ['category_slug' => 'quran', 'title' => 'পারা সমূহের সংক্ষিপ্ত বর্ণনা', 'content' => 'কুরআন ৩০ পারায় বিভক্ত। প্রতিটি পারায় অনেকগুলো সূরা রয়েছে।'],
            // সুন্নাহ
            ['category_slug' => 'sunnah', 'title' => 'রাসূলুল্লাহ (সা.) এর সুন্নাহ', 'content' => 'রাসূলুল্লাহ (সা.) এর কথা ও কাজের প্রতিবন্ধক। এটি ইসলামের দ্বিতীয় উৎস।'],
            ['category_slug' => 'sunnah', 'title' => 'খাওয়ার সুন্নাহ', 'content' => 'খাওয়ার আগে বিসমিল্লাহ পড়া ও ডান হাতে খাওয়া রাসূলুল্লাহ (সা.) এর সুন্নাহ।'],
            // ফিকহ
            ['category_slug' => 'fiqh', 'title' => 'নামাজের পালনের নিয়ম', 'content' => 'নামাজ ইসলামের পাঁচটি স্তম্ভের একটি। এর নির্দিষ্ট কিছু শর্ত ও ফরজ রয়েছে।'],
            ['category_slug' => 'fiqh', 'title' => 'রোজার হুকুম', 'content' => 'রমজান মাসে সকাল থেকে সন্ধ্যা পর্যন্ত রোজা রাখা ফরজ।'],
            // আত্মশুদ্ধি ও শিষ্টাচার
            ['category_slug' => 'atmashuddhi-o-shistachar', 'title' => 'ধৈর্যের গুরুত্ব', 'content' => 'ইসলামে ধৈর্য একটি গুরুত্বপূর্ণ গুণ। সকল পরীক্ষায় ধৈর্য ধরা উচিত।'],
            ['category_slug' => 'atmashuddhi-o-shistachar', 'title' => 'সততা ও সৎকাজ', 'content' => 'সততা মানুষের শ্রেষ্ঠ গুণ। সৎকাজ করাটাই আত্মশুদ্ধির পথ।'],
            // সিরাত
            ['category_slug' => 'seerat', 'title' => 'রাসূলুল্লাহ (সা.) এর জন্ম', 'content' => 'রাসূলুল্লাহ (সা.) ৫৭০ খ্রিস্টাব্দে মক্কায় জন্মগ্রহণ করেন।'],
            ['category_slug' => 'seerat', 'title' => 'হিজরতের ঘটনা', 'content' => 'রাসূলুল্লাহ (সা.) ৬২২ খ্রিস্টাব্দে মক্কা থেকে মদিনায় হিজরত করেন।'],
            // জীবনী ও ইতিহাস
            ['category_slug' => 'jiboni-o-itihash', 'title' => 'হযরত আবু বকর (রা.) এর জীবনী', 'content' => 'হযরত আবু বকর (রা.) ছিলেন রাসূলুল্লাহ (সা.) এর নিকটতম সাহাবী ও প্রথম খলিফা।'],
            ['category_slug' => 'jiboni-o-itihash', 'title' => 'ইসলামের প্রাথমিক ইতিহাস', 'content' => 'ইসলামের প্রাথমিক ইতিহাস মক্কা ও মদিনার সাথে সম্পর্কিত।'],
            // চিন্তালাপ ও সাম্প্রতিক
            ['category_slug' => 'chintalap-o-samprotik', 'title' => 'আধুনিক সময়ের চ্যালেঞ্জ', 'content' => 'আধুনিক সময়ে মুসলিমদের সামনে অনেক চ্যালেঞ্জ রয়েছে।'],
            ['category_slug' => 'chintalap-o-samprotik', 'title' => 'সাম্প্রতিক ইসলামিক গবেষণা', 'content' => 'বর্তমান সময়ে ইসলামিক গবেষণা নতুন দিগন্ত উন্মোচন করছে।'],
            // বাণী সম্ভার
            ['category_slug' => 'bani-sambhar', 'title' => 'কুরআনের সুন্দর আয়াত', 'content' => 'কুরআনে অনেক সুন্দর আয়াত রয়েছে যা মানুষকে অনুপ্রাণিত করে।'],
            ['category_slug' => 'bani-sambhar', 'title' => 'হাদিসের মন্ত্রণা', 'content' => 'রাসূলুল্লাহ (সা.) এর হাদিস সমূহ মানুষের জন্য অনুপ্রেরণা।'],
            // পাঠ-পর্যালোচনা
            ['category_slug' => 'path-poryalochona', 'title' => 'ইসলামের মূলনীতি পুস্তক পর্যালোচনা', 'content' => 'ইসলামের মূলনীতি বইটি ইসলামের মৌলিক বিষয়গুলো নিয়ে আলোচনা করে।'],
            ['category_slug' => 'path-poryalochona', 'title' => 'সিরাতের গুরুত্ব', 'content' => 'সিরাত পাঠ করা মুসলিমদের জন্য অত্যন্ত গুরুত্বপূর্ণ।'],
            // ইবুক
            ['category_slug' => 'ebook', 'title' => 'ইসলামিক ইবুক সমূহ', 'content' => 'ইসলামিক ইবুক পড়া জ্ঞান বৃদ্ধির একটি উত্তম উপায়।'],
            ['category_slug' => 'ebook', 'title' => 'ডিজিটাল যুগে ইসলামিক বই', 'content' => 'ডিজিটাল যুগে অনলাইনে ইসলামিক বই পাওয়া সহজ হয়েছে।'],
            // অডিয়ো-ভিডিয়ো
            ['category_slug' => 'audio-video', 'title' => 'কুরআন তিলাওয়াত অডিয়ো', 'content' => 'কুরআন তিলাওয়াতের অডিয়ো শুনে মন শান্তি পাওয়া যায়।'],
            ['category_slug' => 'audio-video', 'title' => 'ইসলামিক ভিডিয়ো লেকচার', 'content' => 'ইসলামিক ভিডিয়ো লেকচার দেখে ইসলামের বিষয়ে জ্ঞান অর্জন করা যায়।'],
        ];

        foreach ($posts as $index => $post) {
            $category = Category::where('slug', $post['category_slug'])->first();
            if ($category) {
                Post::updateOrCreate(
                    ['slug' => Str::slug($post['title'])],
                    [
                        'title' => $post['title'],
                        'content' => $post['content'],
                        'excerpt' => Str::limit($post['content'], 100),
                        'category_id' => $category->id,
                        'author_id' => $author->id,
                        'status' => 'published',
                        'is_featured' => $index % 5 === 0,
                        'published_at' => now()->subDays(rand(0, 30)),
                    ]
                );
            }
        }
    }
}
