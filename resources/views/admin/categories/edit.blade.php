@extends('admin.layouts.app')

@section('title', $pageTitle . ' — উসুলি অ্যাডমিন')

@section('content')
    <div>

        {{-- Breadcrumbs --}}
        <nav class="mb-4 text-sm text-faint">
            <a href="{{ route('admin.categories.index') }}" class="hover:text-brand">বিষয়সমূহ</a>
            @if ($parent)
                <span class="mx-1.5">/</span>
                <a href="{{ route('admin.categories.index', ['parent_id' => $parent->id]) }}" class="hover:text-brand">{{ $parent->name }}</a>
            @endif
            <span class="mx-1.5">/</span>
            <span class="text-ink">সম্পাদনা</span>
        </nav>

        <h1 class="mb-6 font-serif text-2xl font-semibold text-ink">{{ $pageTitle }}</h1>

        {{-- Errors --}}
        @if ($errors->any())
            <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.categories.update', $category) }}" method="POST"
              class="rounded-xl border border-hairline bg-white p-6">
            @csrf
            @method('PUT')

            <div class="mb-5">
                <label for="name" class="mb-1.5 block text-sm font-medium text-ink">নাম <span class="text-red-500">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" required
                       class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20"
                       placeholder="বিষয়ের নাম লিখুন">
            </div>

            <div class="mb-5">
                <label for="parent_id" class="mb-1.5 block text-sm font-medium text-ink">ঊর্ধ্বতন বিষয়</label>
                <select id="parent_id" name="parent_id"
                        class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20">
                    <option value="">— কোনোটি নয় (টপ-লেভেল) —</option>
                    @foreach ($parents as $p)
                        <option value="{{ $p->id }}" {{ old('parent_id', $category->parent_id) == $p->id ? 'selected' : '' }}>
                            {{ $p->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-5">
                <label for="sort_order" class="mb-1.5 block text-sm font-medium text-ink">সর্ট অর্ডার</label>
                <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $category->sort_order) }}" min="0"
                       class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20">
            </div>

            <div class="mb-6">
                <label class="flex items-center gap-2.5 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }}
                           class="h-4 w-4 rounded border-gray-300 text-brand focus:ring-brand/20">
                    <span class="text-sm font-medium text-ink">সক্রিয়</span>
                </label>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit"
                        class="inline-flex items-center gap-2 rounded-lg bg-brand px-5 py-2.5 text-sm font-medium text-white transition-colors hover:bg-brand-deep">
                    আপডেট করুন
                </button>
                <a href="{{ route('admin.categories.index', $category->parent_id ? ['parent_id' => $category->parent_id] : []) }}"
                   class="inline-flex items-center gap-2 rounded-lg border border-hairline px-5 py-2.5 text-sm font-medium text-faint transition-colors hover:bg-gray-50">
                    বাতিল
                </a>
            </div>
        </form>
    </div>
@endsection
