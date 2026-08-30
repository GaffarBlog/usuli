<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with(['category', 'author']);

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $posts = $query->latest()->paginate(15)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('admin.posts.index', [
            'pageTitle' => 'সব লেখা',
            'posts' => $posts,
            'categories' => $categories,
        ]);
    }

    public function create()
    {
        return view('admin.posts.create', [
            'pageTitle' => 'নতুন লেখা',
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'image' => 'nullable|image|max:2048',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:draft,published',
            'is_featured' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['author_id'] = auth()->id() ?? 1;
        $validated['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('posts', 'public');
        }

        if ($validated['status'] === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        Post::create($validated);

        return redirect()->route('admin.posts.index')
            ->with('success', 'লেখা তৈরি হয়েছে।');
    }

    public function edit(Post $post)
    {
        return view('admin.posts.edit', [
            'pageTitle' => 'লেখা সম্পাদনা',
            'post' => $post,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'image' => 'nullable|image|max:2048',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:draft,published',
            'is_featured' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('image')) {
            if ($post->image && \Storage::disk('public')->exists($post->image)) {
                \Storage::disk('public')->delete($post->image);
            }
            $validated['image'] = $request->file('image')->store('posts', 'public');
        }

        if ($validated['status'] === 'published' && $post->status === 'draft' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        $post->update($validated);

        return redirect()->route('admin.posts.index')
            ->with('success', 'লেখা আপডেট হয়েছে।');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('success', 'লেখা মুছে ফেলা হয়েছে।');
    }
}
