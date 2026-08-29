<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RouteListSeeder::class,
            RoleSeeder::class,
            // UserSeeder::class,
            // HomeSettingsSeeder::class,
            // AboutSettingsSeeder::class,
            // CategorySeeder::class,
            // UnitSeeder::class,
            // LanguageSeeder::class,
            // AttributeSeeder::class,
            // ProductSeeder::class,
            // BlogCategorySeeder::class,
            // BlogPostSeeder::class,
            // StaticPageSettingsSeeder::class,
            // FaqSettingsSeeder::class,
        ]);
    }
}
