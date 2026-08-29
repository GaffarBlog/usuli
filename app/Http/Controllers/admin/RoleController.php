<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $roles = Role::where(function ($query) use ($request) {
            if ($request->has('search')) {
                $query->where('name', 'like', '%'.$request->search.'%');
            }
            if ($request->has('status')) {
                $query->where('status', $request->status);
            }
        })->latest()->get();

        return view('admin.roles.index', compact('roles'));
    }

    public function create_page()
    {
        return view('admin.roles.create');
    }

    public function create(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'description' => 'nullable|string',
        ]);
        Role::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
        ]);

        return redirect()->route('admin.roles.view')->with('success', 'User role created successfully.');
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);

        return view('admin.roles.edit', compact('role'));
    }

    public function update(Request $request)
    {
        // Validate the request data
        $request->validate([
            'id' => 'required|exists:roles,id',
            'name' => 'required|string|max:255|unique:roles,name,'.$request->id,
            'description' => 'nullable|string',
            'status' => 'required|in:Active,Inactive',
        ]);
        $role = Role::findOrFail($request->id);
        $role->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.roles.view')->with('success', 'User role updated successfully.');
    }

    // Delete user role
    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:roles,id',
        ]);
        Role::findOrFail($request->id)->delete();

        return redirect()->route('admin.roles.view')->with('success', 'User role deleted successfully.');
    }

    // update status
    public function change_status(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:roles,id',
        ]);
        Role::where('id', $request->id)->update([
            'status' => $request->status,
        ]);

        return response()->json(['status' => true, 'message' => translate('User role status update successfully!')]);
    }
}
