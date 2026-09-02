<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $settings = [
            ['key' => 'about_hero_label', 'value' => 'আমাদের সম্পর্কে', 'type' => 'string', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'about_hero_title', 'value' => 'উসুলি কী?', 'type' => 'string', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'about_hero_subtitle', 'value' => 'উসুলি হলো বাংলা সাহিত্যের একটি অনলাইন জার্নাল, যেখানে গল্প, ভাবনা ও মানুষের কথা একত্রিত হয়।', 'type' => 'text', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'about_mission_title', 'value' => 'আমাদের লক্ষ্য', 'type' => 'string', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'about_mission_p1', 'value' => 'উসুলির জন্ম হয়েছে বাংলা সাহিত্যকে সমৃদ্ধ করার একটি সাধারণ কামনা থেকে। আমরা বিশ্বাস করি, বাংলা ভাষায় লেখালেখির একটি সমৃদ্ধ ঐতিহ্য রয়েছে, এবং ডিজিটাল যুগে সেই ঐতিহ্যকে নতুন মানুষের কাছে পৌঁছে দেওয়া আমাদের দায়িত্ব।', 'type' => 'text', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'about_mission_p2', 'value' => 'আমরা চাই যেন নতুন ও পুরনো লেখক, পাঠক ও সাহিত্যঅনুরাগীরা একটি জায়গায় একত্রিত হতে পারেন। গল্প পড়তে, লিখতে, এবং সাহিত্য নিয়ে কথা বলতে পারেন।', 'type' => 'text', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'about_values_title', 'value' => 'আমাদের মূল্যবোধ', 'type' => 'string', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'about_values', 'value' => json_encode([
                ['title' => 'সাহিত্যচর্চা', 'description' => 'গল্প, কবিতা, প্রবন্ধ ও বিভিন্ন ধরনের সাহিত্যকর্মকে একটি একক মঞ্চে এনে তোলা।', 'icon' => 'book'],
                ['title' => 'সম্প্রদায়', 'description' => 'পাঠক ও লেখকদের মধ্যে সংলাপ ও সম্পর্ক গড়ে তোলা।', 'icon' => 'users'],
                ['title' => 'সর্বজনীনতা', 'description' => 'সকলের জন্য উন্মুক্ত, যে কেউ পড়তে ও লিখতে পারবেন।', 'icon' => 'globe'],
            ]), 'type' => 'text', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'about_story_title', 'value' => 'আমাদের গল্প', 'type' => 'string', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'about_story_p1', 'value' => 'উসুলি শুরু হয়েছিল একটি ছোট প্রকল্প হিসেবে। কয়েকজন লেখক ও সাহিত্যানুরাগী মিলে একটি এমন প্ল্যাটফর্ম তৈরি করার স্বপ্ন দেখেছিলেন, যেখানে বাংলা সাহিত্য নতুন উচ্চতায় পৌঁছাতে পারে।', 'type' => 'text', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'about_story_p2', 'value' => 'আজ উসুলি একটি ক্রমবর্ধমান সাহিত্যিক সম্প্রদায়ে রূপান্তরিত হয়েছে। এখানে অভিজ্ঞ লেখকদের পাশাপাশি নতুন লেখকরাও তাদের সৃষ্টি পাঠকের কাছে পৌঁছে দিতে পারেন।', 'type' => 'text', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'about_story_p3', 'value' => 'আমাদের বিশ্বাস — ভালো সাহিত্য সীমানা ভেঙে যায়, এবং উসুলি সেই সীমানা ভাঙতে সাহায্য করতে চায়।', 'type' => 'text', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'about_cta_title', 'value' => 'সাহিত্য কি আপনার প্রাণ?', 'type' => 'string', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'about_cta_subtitle', 'value' => 'আমাদের সঙ্গে যুক্ত হতে চাইলে এখনই নিবন্ধন করুন অথবা যোগাযোগ করুন।', 'type' => 'text', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'about_cta_register_btn', 'value' => 'নিবন্ধন করুন', 'type' => 'string', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'about_cta_contact_btn', 'value' => 'যোগাযোগ করুন', 'type' => 'string', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('settings')->insert($settings);
    }

    public function down(): void
    {
        DB::table('settings')->whereIn('key', [
            'about_hero_label', 'about_hero_title', 'about_hero_subtitle',
            'about_mission_title', 'about_mission_p1', 'about_mission_p2',
            'about_values_title', 'about_values',
            'about_story_title', 'about_story_p1', 'about_story_p2', 'about_story_p3',
            'about_cta_title', 'about_cta_subtitle', 'about_cta_register_btn', 'about_cta_contact_btn',
        ])->delete();
    }
};
