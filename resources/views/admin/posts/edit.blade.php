@extends('admin.layouts.app')

@section('title', $pageTitle . ' — উসুলি অ্যাডমিন')

@section('content')
    <div class="space-y-6">
        {{-- Breadcrumbs --}}
        <nav class="flex items-center gap-2 text-sm text-faint">
            <a href="{{ route('admin.posts.index') }}" class="transition-colors hover:text-brand">সব লেখা</a>
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M9 18l6-6-6-6"/>
            </svg>
            <span class="text-ink">{{ $pageTitle }}</span>
        </nav>

        {{-- Header --}}
        <h1 class="text-2xl font-semibold text-ink">{{ $pageTitle }}</h1>

        {{-- Form --}}
        <form method="POST"
              action="{{ route('admin.posts.update', $post) }}"
              class="space-y-6 rounded-xl border border-hairline bg-white p-6">
            @csrf
            @method('PUT')

            {{-- Title --}}
            <div>
                <label for="title" class="mb-1.5 block text-sm font-medium text-ink">
                    শিরোনাম <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       id="title"
                       name="title"
                       value="{{ old('title', $post->title) }}"
                       required
                       class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20"
                       placeholder="লেখার শিরোনাম লিখুন">
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Content --}}
            <div>
                <label for="content" class="mb-1.5 block text-sm font-medium text-ink">
                    বিষয়বস্তু <span class="text-red-500">*</span>
                </label>
                <textarea id="content"
                          name="content"
                          rows="12"
                          required
                          class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20"
                          placeholder="লেখার বিষয়বস্তু লিখুন...">{{ old('content', $post->content) }}</textarea>
                @error('content')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Excerpt --}}
            <div>
                <label for="excerpt" class="mb-1.5 block text-sm font-medium text-ink">
                    সারাংশ
                </label>
                <textarea id="excerpt"
                          name="excerpt"
                          rows="3"
                          maxlength="500"
                          class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20"
                          placeholder="লেখার সংক্ষিপ্ত বিবরণ (ঐচ্ছিক)">{{ old('excerpt', $post->excerpt) }}</textarea>
                @error('excerpt')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Image URL --}}
            <div>
                <label for="image" class="mb-1.5 block text-sm font-medium text-ink">
                    ছবির URL
                </label>
                <input type="url"
                       id="image"
                       name="image"
                       value="{{ old('image', $post->image) }}"
                       class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20"
                       placeholder="https://example.com/image.jpg">
                @error('image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                {{-- Category --}}
                <div>
                    <label for="category_id" class="mb-1.5 block text-sm font-medium text-ink">
                        বিষয় <span class="text-red-500">*</span>
                    </label>
                    <select id="category_id"
                            name="category_id"
                            required
                            class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20">
                        <option value="">বিষয় নির্বাচন করুন</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Status --}}
                <div>
                    <label for="status" class="mb-1.5 block text-sm font-medium text-ink">
                        অবস্থা <span class="text-red-500">*</span>
                    </label>
                    <select id="status"
                            name="status"
                            required
                            class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20">
                        <option value="draft" {{ old('status', $post->status) === 'draft' ? 'selected' : '' }}>খসড়া</option>
                        <option value="published" {{ old('status', $post->status) === 'published' ? 'selected' : '' }}>প্রকাশিত</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                {{-- Published At --}}
                <div>
                    <label for="published_at" class="mb-1.5 block text-sm font-medium text-ink">
                        প্রকাশের তারিখ
                    </label>
                    <input type="datetime-local"
                           id="published_at"
                           name="published_at"
                           value="{{ old('published_at', $post->published_at?->format('Y-m-d\TH:i')) }}"
                           class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20">
                    @error('published_at')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Featured --}}
                <div class="flex items-end pb-1">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox"
                               name="is_featured"
                               value="1"
                               {{ old('is_featured', $post->is_featured) ? 'checked' : '' }}
                               class="h-4 w-4 rounded border-hairline text-brand focus:ring-brand/20">
                        <span class="text-sm font-medium text-ink">বৈশিষ্ট্যযুক্ত লেখা</span>
                    </label>
                </div>
            </div>

            {{-- Buttons --}}
            <div class="flex items-center gap-3 pt-4 border-t border-hairline">
                <button type="submit"
                        class="inline-flex items-center gap-2 rounded-lg bg-brand px-5 py-2.5 text-sm font-medium text-white transition-colors hover:bg-brand-deep">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                        <polyline points="17 21 17 13 7 13 7 21"/>
                        <polyline points="7 3 7 8 15 8"/>
                    </svg>
                    আপডেট করুন
                </button>
                <a href="{{ route('admin.posts.index') }}"
                   class="rounded-lg border border-hairline px-5 py-2.5 text-sm font-medium text-faint transition-colors hover:bg-gray-50">
                    বাতিল
                </a>
            </div>
        </form>
    </div>
@endsection
