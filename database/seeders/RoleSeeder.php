<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\RouteList;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = RouteList::select('id', 'route')
            ->get()
            ->map(function ($item) {
                return $item->route ?? $item->id;
            })
            ->toArray();
        $data = [
            [
                'name' => 'Super Admin',
                'slug' => 'super-admin',
                'description' => 'Super Admin role with all permissions',
                'permissions' => implode(',', $permissions),
            ],
            [
                'name' => 'Admin',
                'slug' => 'admin',
                'description' => 'Admin role with most permissions',
                'permissions' => 'admin.dashboard.view',
            ],
            [
                'name' => 'Editor',
                'slug' => 'editor',
                'description' => 'Editor role with limited permissions',
                'permissions' => 'admin.dashboard.view',
            ],
        ];

        foreach ($data as $item) {
            Role::create($item);
        }
    }
}
