<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->enum('type', ['string', 'text', 'image'])->default('string');
            $table->timestamps();
        });

        DB::table('settings')->insert([
            ['key' => 'site_name', 'value' => 'উসুলি', 'type' => 'string', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'site_description', 'value' => 'বাংলা সাহিত্য পত্রিকা', 'type' => 'text', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'site_logo', 'value' => null, 'type' => 'image', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'phone', 'value' => null, 'type' => 'string', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'email', 'value' => null, 'type' => 'string', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'address', 'value' => null, 'type' => 'text', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
