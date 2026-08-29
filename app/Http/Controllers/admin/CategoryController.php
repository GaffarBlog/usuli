<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $parentId = $request->input('parent_id');
        $query = Category::withCount('children');

        if ($parentId) {
            $parent = Category::findOrFail($parentId);
            $query->where('parent_id', $parentId);
            $categories = $query->orderBy('sort_order')->orderBy('name')->get();

            return view('admin.categories.index', [
                'pageTitle' => $parent->name.' — উপবিষয়',
                'categories' => $categories,
                'parent' => $parent,
                'breadcrumbs' => $this->getBreadcrumbs($parent),
            ]);
        }

        $categories = $query->topLevel()->orderBy('sort_order')->orderBy('name')->get();

        return view('admin.categories.index', [
            'pageTitle' => 'বিষয়সমূহ',
            'categories' => $categories,
            'parent' => null,
            'breadcrumbs' => [],
        ]);
    }

    public function create(Request $request)
    {
        $parentId = $request->input('parent_id');
        $parent = $parentId ? Category::findOrFail($parentId) : null;

        return view('admin.categories.create', [
            'pageTitle' => 'নতুন বিষয়',
            'parent' => $parent,
            'parents' => Category::topLevel()->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        Category::create($validated);

        $redirect = $request->input('parent_id')
            ? route('admin.categories.index', ['parent_id' => $request->input('parent_id')])
            : route('admin.categories.index');

        return redirect($redirect)->with('success', 'বিষয় তৈরি হয়েছে।');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', [
            'pageTitle' => 'বিষয় সম্পাদনা',
            'category' => $category,
            'parent' => $category->parent,
            'parents' => Category::topLevel()->where('id', '!=', $category->id)->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $category->update($validated);

        $redirect = $category->parent_id
            ? route('admin.categories.index', ['parent_id' => $category->parent_id])
            : route('admin.categories.index');

        return redirect($redirect)->with('success', 'বিষয় আপডেট হয়েছে।');
    }

    public function destroy(Category $category)
    {
        $parentId = $category->parent_id;
        $category->delete();

        $redirect = $parentId
            ? route('admin.categories.index', ['parent_id' => $parentId])
            : route('admin.categories.index');

        return redirect($redirect)->with('success', 'বিষয় মুছে ফেলা হয়েছে।');
    }

    private function getBreadcrumbs(Category $category): array
    {
        $breadcrumbs = [];
        $current = $category;

        while ($current->parent) {
            $current = $current->parent;
            array_unshift($breadcrumbs, $current);
        }

        return $breadcrumbs;
    }
}
