@extends('admin.layouts.app')

@section('title', $pageTitle . ' — উসুলি অ্যাডমিন')

@section('content')
    <div>

        {{-- Success Message --}}
        @if (session('success'))
            <div id="flash-msg" class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        {{-- Breadcrumbs --}}
        @if (!empty($breadcrumbs) || $parent)
            <nav class="mb-4 text-sm text-faint">
                <a href="{{ route('admin.categories.index') }}" class="hover:text-brand">বিষয়সমূহ</a>
                @foreach ($breadcrumbs as $crumb)
                    <span class="mx-1.5">/</span>
                    <a href="{{ route('admin.categories.index', ['parent_id' => $crumb->id]) }}" class="hover:text-brand">{{ $crumb->name }}</a>
                @endforeach
                @if ($parent && empty($breadcrumbs))
                    <span class="mx-1.5">/</span>
                    <span class="text-ink">{{ $parent->name }}</span>
                @endif
            </nav>
        @endif

        {{-- Header --}}
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="font-serif text-2xl font-semibold text-ink">{{ $pageTitle }}</h1>
                @if ($parent)
                    <p class="mt-1 text-sm text-faint">উপবিষয় তালিকা</p>
                @endif
            </div>
            <a href="{{ route('admin.categories.create', $parent ? ['parent_id' => $parent->id] : []) }}"
               class="inline-flex items-center gap-2 rounded-lg bg-brand px-4 py-2.5 text-sm font-medium text-white transition-colors hover:bg-brand-deep">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                নতুন বিষয়
            </a>
        </div>

        {{-- Table --}}
        <div class="overflow-hidden rounded-xl border border-hairline bg-white">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-hairline bg-gray-50/60">
                        <th class="px-5 py-3 font-semibold text-ink">#</th>
                        <th class="px-5 py-3 font-semibold text-ink">নাম</th>
                        <th class="px-5 py-3 font-semibold text-ink">স্লাগ</th>
                        <th class="px-5 py-3 font-semibold text-ink">উপবিষয়</th>
                        <th class="px-5 py-3 font-semibold text-ink">অবস্থা</th>
                        <th class="px-5 py-3 text-right font-semibold text-ink">কার্যক্রম</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $index => $category)
                        <tr class="border-b border-hairline last:border-0 transition-colors hover:bg-gray-50/40">
                            <td class="px-5 py-3.5 text-faint">{{ $index + 1 }}</td>
                            <td class="px-5 py-3.5">
                                @if ($category->children_count > 0)
                                    <a href="{{ route('admin.categories.index', ['parent_id' => $category->id]) }}"
                                       class="font-medium text-ink hover:text-brand transition-colors">
                                        {{ $category->name }}
                                    </a>
                                @else
                                    <span class="font-medium text-ink">{{ $category->name }}</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-faint">{{ $category->slug }}</td>
                            <td class="px-5 py-3.5">
                                @if ($category->children_count > 0)
                                    <a href="{{ route('admin.categories.index', ['parent_id' => $category->id]) }}"
                                       class="inline-flex items-center gap-1 text-brand hover:underline">
                                        {{ $category->children_count }}
                                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="9 18 15 12 9 6"/>
                                        </svg>
                                    </a>
                                @else
                                    <span class="text-faint">—</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5">
                                @if ($category->is_active)
                                    <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-medium text-emerald-700">সক্রিয়</span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-500">নিষ্ক্রিয়</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('admin.categories.edit', $category) }}"
                                       class="grid h-8 w-8 place-items-center rounded-lg text-faint transition-colors hover:bg-brand/10 hover:text-brand"
                                       title="সম্পাদনা">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M17 3a2.83 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                          onsubmit="return confirm('আপনি কি নিশ্চিত এই বিষয়টি মুছে ফেলতে চান?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="grid h-8 w-8 place-items-center rounded-lg text-faint transition-colors hover:bg-red-50 hover:text-red-600"
                                                title="মুছুন">
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                                                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-16 text-center text-faint">
                                @if ($parent)
                                    এই বিষয়ের অধীনে কোনো উপবিষয় নেই।
                                @else
                                    কোনো বিষয় তৈরি হয়নি।
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        $(function () {
            if ($('#flash-msg').length) {
                setTimeout(function () {
                    $('#flash-msg').fadeOut(400, function () { $(this).remove(); });
                }, 3000);
            }
        });
    </script>
@endsection
