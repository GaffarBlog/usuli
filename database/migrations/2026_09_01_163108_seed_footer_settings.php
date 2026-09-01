<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $settings = [
            [
                'key' => 'footer_slogan',
                'value' => 'বাংলায় গল্প, ভাবনা ও মানুষের কথা।',
                'type' => 'text',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'footer_copyright',
                'value' => '© ২০২৬ উসুলি। সর্বস্বত্ব সংরক্ষিত।',
                'type' => 'text',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'footer_menu_items',
                'value' => json_encode([
                    ['label' => 'প্রচ্ছদ', 'url' => '/'],
                    ['label' => 'গল্প', 'url' => '/blog'],
                    ['label' => 'যোগাযোগ', 'url' => '/contact'],
                ]),
                'type' => 'text',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('settings')->insert($settings);
    }

    public function down(): void
    {
        DB::table('settings')->whereIn('key', [
            'footer_slogan',
            'footer_copyright',
            'footer_menu_items',
        ])->delete();
    }
};
