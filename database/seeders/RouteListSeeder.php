<?php

namespace Database\Seeders;

use App\Models\RouteList;
use Illuminate\Database\Seeder;

class RouteListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        foreach (get_route_lists() as $parent_name => $items) {
            $parent_route = RouteList::create([
                'name' => $parent_name,
            ]);
            foreach ($items as $name => $route) {
                RouteList::create([
                    'name' => $name,
                    'route' => $route,
                    'parent_id' => $parent_route->id,
                ]);
            }
        }
    }
}
