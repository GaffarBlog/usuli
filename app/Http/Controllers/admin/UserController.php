<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::orderBy('id', 'Desc')
            ->where('role_id', '!=', 1)
            ->where(function ($query) use ($request) {
                if ($request->has('user_role') && $request->user_role != null) {
                    $query->where('role_id', $request->user_role);
                }
                if ($request->has('status') && $request->status != null) {
                    $query->where('status', $request->status);
                }
            })
            ->where(function ($query) use ($request) {
                if ($request->has('search') && $request->search != null) {
                    $query->where('name', 'like', '%'.$request->search.'%')
                        ->orWhere('email', 'like', '%'.$request->search.'%')
                        ->orWhere('username', 'like', '%'.$request->search.'%');
                }

            })
            ->paginate(20);
        $roles = Role::select('id', 'name', 'slug')->get();

        return view('admin.users.index', compact('users', 'roles'));
    }

    public function create()
    {
        $roles = Role::select('id', 'name')->where('id', '!=', 1)->get();

        return view('admin.users.create', compact('roles'));
    }

    public function create_user(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|unique:users,username',
            'password' => 'nullable|string|min:6|confirmed',
            'role_id' => 'required|exists:roles,id',
            'status' => 'required|in:Active,Inactive,Banned',
            'address' => 'nullable|string|max:1000',
            'country' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'zip' => 'nullable|string|max:10',
            'phone' => 'nullable|string|max:16',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:Male,Female,Third Gender',

        ]);
        $userdata = [
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'status' => $request->status,
            'address' => $request->address,
            'country' => $request->country,
            'city' => $request->city,
            'zip' => $request->zip,
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,

        ];
        if ($request->file('avatar')) {
            $userdata['images'] = upload_file($request->file('avatar'), 'users');
        }
        User::updateOrCreate($userdata);

        return redirect()->route('admin.users.view')->with('success', 'User created successfully.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::select('id', 'name')->get();

        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$request->id,
            'username' => 'required|string|unique:users,username,'.$request->id,
            'password' => 'nullable|string|min:6|confirmed',
            'role_id' => 'required|exists:roles,id',
            'status' => 'required|in:Active,Inactive,Banned',
            'address' => 'nullable|string|max:1000',
            'country' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'zip' => 'nullable|string|max:10',
            'phone' => 'nullable|string|max:18|min:10',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:Male,Female,Third Gender',

        ]);
        $user = User::findOrFail($request->id);
        $images = $user->images;
        if ($request->file('avatar')) {
            $images = upload_file($request->file('avatar'), 'users');
            dd($images);
        }
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'role_id' => $request->role_id,
            'status' => $request->status,
            'address' => $request->address,
            'country' => $request->country,
            'city' => $request->city,
            'zip' => $request->zip,
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'images' => $images,
        ]);

        return redirect()->route('admin.users.view')->with('success', 'User updated successfully.');
    }

    // Delete user role
    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id',
        ]);
        $user = User::where('id', $request->id)->where('role_id', '!=', 1)->first();
        if ($user) {
            if (! empty($user->images)) {
                $images = $user->images;
                if (! empty($images) && is_array($images)) {
                    foreach ($images as $key => $image) {
                        if (is_string($image) && Str::startsWith($image, asset(''))) {
                            $imagePath = str_replace(asset(''), public_path('/'), $image);
                            if (File::exists($imagePath)) {
                                File::delete($imagePath);
                            }
                        }
                    }
                }
            }
            $user->delete();
        }

        return redirect()->back()->with('success', 'User deleted successfully.');
    }

    // Bulk delete users
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required',
            'ids.*' => 'exists:users,id',
        ]);
        $users = User::whereIn('id', explode(',', $request->ids))
            ->where('role_id', '!=', 1)
            ->get();

        foreach ($users as $user) {
            // Delete user images if they exist
            if (! empty($user->images)) {
                $images = $user->images;
                if (! empty($images) && is_array($images)) {
                    foreach ($images as $key => $image) {
                        if (is_string($image) && Str::startsWith($image, asset(''))) {
                            $imagePath = str_replace(asset(''), public_path('/'), $image);
                            if (File::exists($imagePath)) {
                                File::delete($imagePath);
                            }
                        }
                    }
                }
            }
            $user->delete();
        }

        return redirect()->back()->with('success', 'Users deleted successfully.');
    }
}
