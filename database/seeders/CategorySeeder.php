<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'আকিদাহ', 'slug' => 'akidah'],
            ['name' => 'কুরআন', 'slug' => 'quran'],
            ['name' => 'সুন্নাহ', 'slug' => 'sunnah'],
            ['name' => 'ফিকহ', 'slug' => 'fiqh'],
            ['name' => 'আত্মশুদ্ধি ও শিষ্টাচার', 'slug' => 'atmashuddhi-o-shistachar'],
            ['name' => 'সিরাত', 'slug' => 'seerat'],
            ['name' => 'জীবনী ও ইতিহাস', 'slug' => 'jiboni-o-itihash'],
            ['name' => 'চিন্তালাপ ও সাম্প্রতিক', 'slug' => 'chintalap-o-samprotik'],
            ['name' => 'বাণী সম্ভার', 'slug' => 'bani-sambhar'],
            ['name' => 'পাঠ-পর্যালোচনা', 'slug' => 'path-poryalochona'],
            ['name' => 'ইবুক', 'slug' => 'ebook'],
            ['name' => 'অডিয়ো-ভিডিয়ো', 'slug' => 'audio-video'],
        ];

        foreach ($categories as $index => $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                [
                    'name' => $category['name'],
                    'is_active' => true,
                    'sort_order' => $index + 1,
                ]
            );
        }
    }
}
