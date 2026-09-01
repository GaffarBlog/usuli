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
        </div>

        {{-- Filters --}}
        <form method="GET" class="flex flex-wrap items-end gap-4 rounded-xl border border-hairline bg-white p-4">
            <div class="flex-1 min-w-[200px]">
                <label class="mb-1.5 block text-sm font-medium text-ink">অনুসন্ধান</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="মন্তব্য, ব্যবহারকারী বা লেখার নাম..."
                    class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20">
            </div>
            <div class="min-w-[150px]">
                <label class="mb-1.5 block text-sm font-medium text-ink">অবস্থা</label>
                <select name="status" class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20">
                    <option value="">সব</option>
                    <option value="unseen" {{ request('status') === 'unseen' ? 'selected' : '' }}>নতুন</option>
                    <option value="seen" {{ request('status') === 'seen' ? 'selected' : '' }}>দেখা হয়েছে</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="rounded-lg bg-brand px-4 py-2.5 text-sm font-medium text-white transition-colors hover:bg-brand-deep">
                    ফিল্টার
                </button>
                <a href="{{ route('admin.comments.index') }}" class="rounded-lg border border-hairline px-4 py-2.5 text-sm font-medium text-faint transition-colors hover:bg-gray-50">
                    রিসেট
                </a>
            </div>
        </form>

        {{-- Comments Table --}}
        <div class="overflow-hidden rounded-xl border border-hairline bg-white">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-hairline bg-gray-50/50">
                        <th class="px-4 py-3 font-medium text-ink">ব্যবহারকারী</th>
                        <th class="px-4 py-3 font-medium text-ink">মন্তব্য</th>
                        <th class="px-4 py-3 font-medium text-ink">লেখা</th>
                        <th class="px-4 py-3 font-medium text-ink">অবস্থা</th>
                        <th class="px-4 py-3 font-medium text-ink">তারিখ</th>
                        <th class="px-4 py-3 text-right font-medium text-ink">কার্যক্রম</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-hairline">
                    @forelse ($comments as $comment)
                        <tr class="transition-colors hover:bg-gray-50/50">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    @if ($comment->user && !empty($comment->user->images))
                                        <img src="{{ $comment->user->images }}" alt="{{ $comment->user->name }}" class="h-8 w-8 rounded-full object-cover">
                                    @else
                                        <span class="grid h-8 w-8 shrink-0 place-items-center rounded-full bg-brand/10 font-serif text-xs font-semibold text-brand-deep">
                                            {{ mb_substr($comment->user->name ?? '?', 0, 1, 'UTF-8') }}
                                        </span>
                                    @endif
                                    <span class="font-medium text-ink">{{ $comment->user->name ?? 'অজানা' }}</span>
                                </div>
                            </td>
                            <td class="max-w-[250px] px-4 py-3">
                                <p class="truncate text-faint">{{ $comment->body }}</p>
                            </td>
                            <td class="max-w-[180px] px-4 py-3">
                                <a href="{{ route('blog.show', $comment->post->slug) }}" target="_blank" class="truncate font-medium text-brand-deep hover:underline">
                                    {{ $comment->post->title ?? 'মুছে ফেলা হয়েছে' }}
                                </a>
                            </td>
                            <td class="px-4 py-3">
                                @if ($comment->is_seen)
                                    <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-medium text-emerald-700">
                                        দেখা হয়েছে
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-amber-50 px-2.5 py-0.5 text-xs font-medium text-amber-700">
                                        নতুন
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-faint">
                                {{ $comment->created_at->diffForHumans() }}
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('admin.comments.show', $comment) }}" class="rounded-lg p-2 text-faint transition-colors hover:bg-brand/10 hover:text-brand" title="দেখুন ও উত্তর দিন">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                                        </svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.comments.destroy', $comment) }}" onsubmit="return confirm('আপনি কি নিশ্চিত এই মন্তব্যটি মুছে ফেলতে চান?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-lg p-2 text-faint transition-colors hover:bg-red-50 hover:text-red-600" title="মুছুন">
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center text-faint">
                                কোনো মন্তব্য পাওয়া যায়নি।
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($comments->hasPages())
            {{ $comments->links() }}
        @endif
    </div>

    <script>
        $(document).ready(function() {
            $('#flash-message').delay(3000).fadeOut(300);
        });
    </script>
@endsection
