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
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.comments.index') }}" class="grid h-10 w-10 place-items-center rounded-lg border border-hairline text-faint transition-colors hover:bg-gray-50 hover:text-ink">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 12H5M12 19l-7-7 7-7" />
                    </svg>
                </a>
                <h1 class="text-2xl font-semibold text-ink">{{ $pageTitle }}</h1>
            </div>
            <form method="POST" action="{{ route('admin.comments.destroy', $comment) }}" onsubmit="return confirm('আপনি কি নিশ্চিত এই মন্তব্যটি মুছে ফেলতে চান?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center gap-2 rounded-lg border border-red-200 bg-red-50 px-4 py-2.5 text-sm font-medium text-red-600 transition-colors hover:bg-red-100">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                    </svg>
                    মুছুন
                </button>
            </form>
        </div>

        <div class="grid gap-6 min-[901px]:grid-cols-[1fr_360px]">
            {{-- Main: Comment Thread --}}
            <div class="space-y-6">
                {{-- Original Comment --}}
                <div class="rounded-xl border border-hairline bg-white p-6">
                    <div class="mb-4 flex items-center gap-3">
                        @if ($comment->user && !empty($comment->user->images))
                            <img src="{{ $comment->user->images }}" alt="{{ $comment->user->name }}" class="h-11 w-11 rounded-full object-cover">
                        @else
                            <span class="grid h-11 w-11 shrink-0 place-items-center rounded-full bg-linear-160 from-brand to-brand-deep font-serif text-base font-semibold text-white">
                                {{ mb_substr($comment->user->name ?? '?', 0, 1, 'UTF-8') }}
                            </span>
                        @endif
                        <div>
                            <p class="font-semibold text-ink">{{ $comment->user->name ?? 'অজানা ব্যবহারকারী' }}</p>
                            <p class="text-xs text-faint">{{ $comment->created_at->format('d M Y, h:i A') }}</p>
                        </div>
                    </div>
                    <p class="text-[0.95rem] leading-[1.8] text-body">{{ $comment->body }}</p>
                </div>

                {{-- Replies --}}
                @if ($comment->replies && $comment->replies->count())
                    <div class="space-y-4">
                        <h3 class="text-sm font-semibold text-ink">উত্তরসমূহ ({{ $comment->replies->count() }})</h3>
                        @foreach ($comment->replies as $reply)
                            <div class="rounded-xl border border-hairline bg-white p-5">
                                <div class="mb-3 flex items-center gap-3">
                                    @if ($reply->admin)
                                        @if (!empty(Auth::user()->images))
                                            <img src="{{ Auth::user()->images }}" alt="{{ $reply->admin->name }}" class="h-9 w-9 rounded-full object-cover">
                                        @else
                                            <span class="grid h-9 w-9 shrink-0 place-items-center rounded-full bg-brand/10 font-serif text-xs font-semibold text-brand-deep">
                                                {{ mb_substr($reply->admin->name ?? '?', 0, 1, 'UTF-8') }}
                                            </span>
                                        @endif
                                        <div>
                                            <p class="text-sm font-semibold text-ink">
                                                {{ $reply->admin->name }}
                                                <span class="ml-1 inline-flex items-center rounded-full bg-brand/10 px-1.5 py-0.5 text-[0.6rem] font-semibold text-brand-deep">অ্যাডমিন</span>
                                            </p>
                                            <p class="text-[0.68rem] text-faint">{{ $reply->created_at->format('d M Y, h:i A') }}</p>
                                        </div>
                                    @elseif ($reply->user)
                                        @if (!empty($reply->user->images))
                                            <img src="{{ $reply->user->images }}" alt="{{ $reply->user->name }}" class="h-9 w-9 rounded-full object-cover">
                                        @else
                                            <span class="grid h-9 w-9 shrink-0 place-items-center rounded-full bg-brand/10 font-serif text-xs font-semibold text-brand-deep">
                                                {{ mb_substr($reply->user->name ?? '?', 0, 1, 'UTF-8') }}
                                            </span>
                                        @endif
                                        <div>
                                            <p class="text-sm font-semibold text-ink">{{ $reply->user->name }}</p>
                                            <p class="text-[0.68rem] text-faint">{{ $reply->created_at->format('d M Y, h:i A') }}</p>
                                        </div>
                                    @endif
                                </div>
                                <p class="text-[0.9rem] leading-[1.75] text-body">{{ $reply->body }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- Reply Form --}}
                <div class="rounded-xl border border-hairline bg-white p-6">
                    <h3 class="mb-4 text-sm font-semibold text-ink">উত্তর দিন</h3>
                    <form method="POST" action="{{ route('admin.comments.reply', $comment) }}">
                        @csrf
                        <textarea name="body" rows="4" required maxlength="2000" placeholder="আপনার উত্তর লিখুন..."
                            class="w-full resize-none rounded-lg border border-hairline bg-gray-50/50 px-4 py-3 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20">{{ old('body') }}</textarea>
                        @error('body')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                        <div class="mt-3 flex justify-end">
                            <button type="submit" class="rounded-lg bg-brand px-5 py-2.5 text-sm font-medium text-white transition-colors hover:bg-brand-deep">
                                উত্তর পোস্ট করুন
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Sidebar: Post Info --}}
            <aside class="min-w-0">
                <div class="min-[901px]:sticky min-[901px]:top-[92px] space-y-6">
                    <div class="rounded-xl border border-hairline bg-white p-5">
                        <h3 class="mb-3 text-sm font-semibold text-ink">লেখার তথ্য</h3>
                        @if ($comment->post)
                            <div class="space-y-3">
                                @if ($comment->post->image)
                                    <img src="{{ $comment->post->image }}" alt="{{ $comment->post->title }}" class="w-full rounded-lg object-cover" style="aspect-ratio: 16/9;">
                                @endif
                                <div>
                                    <p class="text-xs text-faint">শিরোনাম</p>
                                    <a href="{{ route('blog.show', $comment->post->slug) }}" target="_blank" class="text-sm font-medium text-brand-deep hover:underline">
                                        {{ $comment->post->title }}
                                    </a>
                                </div>
                                <div>
                                    <p class="text-xs text-faint">প্রকাশিত</p>
                                    <p class="text-sm text-ink">{{ $comment->post->published_at?->format('d M Y') ?? '—' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-faint">লেখক</p>
                                    <p class="text-sm text-ink">{{ $comment->post->author->name ?? '—' }}</p>
                                </div>
                            </div>
                        @else
                            <p class="text-sm text-faint">লেখাটি মুছে ফেলা হয়েছে।</p>
                        @endif
                    </div>

                    <div class="rounded-xl border border-hairline bg-white p-5">
                        <h3 class="mb-3 text-sm font-semibold text-ink">মন্তব্যকারীর তথ্য</h3>
                        @if ($comment->user)
                            <div class="space-y-3">
                                <div class="flex items-center gap-3">
                                    @if (!empty($comment->user->images))
                                        <img src="{{ $comment->user->images }}" alt="{{ $comment->user->name }}" class="h-10 w-10 rounded-full object-cover">
                                    @else
                                        <span class="grid h-10 w-10 shrink-0 place-items-center rounded-full bg-linear-160 from-brand to-brand-deep font-serif text-sm font-semibold text-white">
                                            {{ mb_substr($comment->user->name, 0, 1, 'UTF-8') }}
                                        </span>
                                    @endif
                                    <div>
                                        <p class="text-sm font-medium text-ink">{{ $comment->user->name }}</p>
                                        <p class="text-xs text-faint">{{ $comment->user->email }}</p>
                                    </div>
                                </div>
                                @if ($comment->user->phone)
                                    <div>
                                        <p class="text-xs text-faint">ফোন</p>
                                        <p class="text-sm text-ink">{{ $comment->user->phone }}</p>
                                    </div>
                                @endif
                                <div>
                                    <p class="text-xs text-faint">অবস্থা</p>
                                    <p class="text-sm text-ink">{{ $comment->user->status }}</p>
                                </div>
                            </div>
                        @else
                            <p class="text-sm text-faint">ব্যবহারকারী পাওয়া যায়নি।</p>
                        @endif
                    </div>
                </div>
            </aside>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#flash-message').delay(3000).fadeOut(300);
        });
    </script>
@endsection
