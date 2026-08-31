<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $default = json_encode([
            ['type' => 'home', 'label' => 'প্রচ্ছদ', 'url' => '/'],
            ['type' => 'blog', 'label' => 'গল্প', 'url' => '/blog'],
        ]);

        DB::table('settings')->insert([
            'key' => 'navbar_items',
            'value' => $default,
            'type' => 'text',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        DB::table('settings')->where('key', 'navbar_items')->delete();
    }
};
