@extends('admin.layouts.app')

@section('title', $pageTitle . ' — উসুলি অ্যাডমিন')

@section('content')
    <div class="space-y-6">
        {{-- Flash Message --}}
        @if (session('success'))
            <div id="flash-message" class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        {{-- Header --}}
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-semibold text-ink">{{ $pageTitle }}</h1>
            <a href="{{ route('admin.posts.create') }}"
               class="inline-flex items-center gap-2 rounded-lg bg-brand px-4 py-2.5 text-sm font-medium text-white transition-colors hover:bg-brand-deep">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 5v14M5 12h14"/>
                </svg>
                নতুন লেখা
            </a>
        </div>

        {{-- Filters --}}
        <form method="GET" class="flex flex-wrap items-end gap-4 rounded-xl border border-hairline bg-white p-4">
            <div class="flex-1 min-w-[200px]">
                <label class="mb-1.5 block text-sm font-medium text-ink">অনুসন্ধান</label>
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="লেখার শিরোনাম বা বিষয়বস্তু..."
                       class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20">
            </div>
            <div class="min-w-[150px]">
                <label class="mb-1.5 block text-sm font-medium text-ink">অবস্থা</label>
                <select name="status"
                        class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20">
                    <option value="">সব</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>খসড়া</option>
                    <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>প্রকাশিত</option>
                </select>
            </div>
            <div class="min-w-[150px]">
                <label class="mb-1.5 block text-sm font-medium text-ink">বিষয়</label>
                <select name="category_id"
                        class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20">
                    <option value="">সব</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit"
                        class="rounded-lg bg-brand px-4 py-2.5 text-sm font-medium text-white transition-colors hover:bg-brand-deep">
                    ফিল্টার
                </button>
                <a href="{{ route('admin.posts.index') }}"
                   class="rounded-lg border border-hairline px-4 py-2.5 text-sm font-medium text-faint transition-colors hover:bg-gray-50">
                    রিসেট
                </a>
            </div>
        </form>

        {{-- Posts Table --}}
        <div class="overflow-hidden rounded-xl border border-hairline bg-white">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-hairline bg-gray-50/50">
                        <th class="px-4 py-3 font-medium text-ink">শিরোনাম</th>
                        <th class="px-4 py-3 font-medium text-ink">বিষয়</th>
                        <th class="px-4 py-3 font-medium text-ink">লেখক</th>
                        <th class="px-4 py-3 font-medium text-ink">অবস্থা</th>
                        <th class="px-4 py-3 font-medium text-ink">প্রকাশিত</th>
                        <th class="px-4 py-3 text-right font-medium text-ink">কার্যক্রম</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-hairline">
                    @forelse ($posts as $post)
                        <tr class="transition-colors hover:bg-gray-50/50">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    @if ($post->is_featured)
                                        <span class="inline-block h-2 w-2 rounded-full bg-brand" title="বৈশিষ্ট্যযুক্ত"></span>
                                    @endif
                                    <span class="font-medium text-ink">{{ $post->title }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-faint">{{ $post->category->name ?? '—' }}</td>
                            <td class="px-4 py-3 text-faint">{{ $post->author->name ?? '—' }}</td>
                            <td class="px-4 py-3">
                                @if ($post->status === 'published')
                                    <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-medium text-emerald-700">
                                        প্রকাশিত
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-amber-50 px-2.5 py-0.5 text-xs font-medium text-amber-700">
                                        খসড়া
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-faint">
                                {{ $post->published_at?->locale('bn')->isoFormat('D MMMM, YYYY') ?? '—' }}
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('admin.posts.edit', $post) }}"
                                       class="rounded-lg p-2 text-faint transition-colors hover:bg-brand/10 hover:text-brand"
                                       title="সম্পাদনা">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M17 3a2.83 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/>
                                        </svg>
                                    </a>
                                    <form method="POST"
                                          action="{{ route('admin.posts.destroy', $post) }}"
                                          onsubmit="return confirm('আপনি কি নিশ্চিত এই লেখাটি মুছে ফেলতে চান?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="rounded-lg p-2 text-faint transition-colors hover:bg-red-50 hover:text-red-600"
                                                title="মুছুন">
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center text-faint">
                                কোনো লেখা পাওয়া যায়নি।
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($posts->hasPages())
            <div class="flex justify-center">
                {{ $posts->links() }}
            </div>
        @endif
    </div>

    <script>
        $(document).ready(function() {
            $('#flash-message').delay(3000).fadeOut(300);
        });
    </script>
@endsection
