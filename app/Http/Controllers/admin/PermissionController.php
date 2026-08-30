<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\RouteList;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index($role_id)
    {
        $role = Role::findOrFail($role_id);
        $permissions = explode(',', $role->permissions);
        $routes = RouteList::select('id', 'name', 'route')->whereNull('parent_id')->with('Childrens')->get();

        return view('admin.permissions.index', compact('role', 'routes', 'permissions'));
    }

    // update permissions for a role
    public function update(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'permissions' => 'array',
        ]);
        $role = Role::findOrFail($request->role_id);
        $role->update([
            'permissions' => implode(',', $request->permissions ?? []),
        ]);

        return redirect()->route('admin.permissions.view', $role->id)->with('success', 'Permissions updated successfully.');
    }

    public function update_routes()
    {
        // return get_route_lists();
        foreach (get_route_lists() as $parent_name => $items) {
            $parent_route = RouteList::updateOrCreate([
                'name' => $parent_name,
            ]);
            foreach ($items as $name => $route) {
                $exists = RouteList::where('route', $route)->exists();
                if (! $exists) {
                    RouteList::updateOrCreate([
                        'name' => $name,
                        'route' => $route,
                        'parent_id' => $parent_route->id,
                    ]);
                }
            }
        }

        return redirect()->route('admin.permissions.view', 1)->with('success', 'Permissions routes updated successfully.');
    }
}
