@extends('layouts.main')

@section('title', $post->title . ' — উসুলি')

@section('content')
    @php
        $eyebrowTick = 'inline-block h-0.5 w-[22px]';
        $metaText = 'text-[0.82rem] font-medium tracking-[0.01em] text-faint';
        $readLink =
            'group/link relative inline-flex w-fit items-center gap-2 font-semibold text-brand-deep after:absolute after:inset-x-0 after:-bottom-[3px] after:h-[1.5px] after:origin-left after:scale-x-0 after:bg-current after:transition-transform after:duration-300 after:ease-[cubic-bezier(0.22,0.61,0.36,1)] hover:after:scale-x-100 focus-visible:after:scale-x-100';
        $readLinkArrow = 'transition-transform duration-300 group-hover/link:translate-x-[5px]';
    @endphp

    <!-- ============ ARTICLE HERO ============ -->
    <section class="pb-[clamp(32px,4vw,52px)] pt-[clamp(40px,6vw,72px)]">
        <div class="shell">
            <a href="{{ route('blog') }}" class="reveal mb-[26px] inline-flex w-fit items-center gap-1.5 text-[0.9rem] font-semibold text-brand-deep transition-colors duration-300 hover:text-ink">
                <span aria-hidden="true">←</span> সব লেখায় ফিরে যান
            </a>

            @if ($post->category)
                <a href="{{ route('blog', ['category' => $post->category->slug]) }}" class="reveal mb-[18px] inline-flex items-center gap-2.5 text-[0.78rem] font-semibold tracking-[0.14em] text-brand-deep transition-colors duration-300 hover:text-brand">
                    <span class="{{ $eyebrowTick }} bg-brand" aria-hidden="true"></span>{{ $post->category->name }}
                </a>
            @endif

            <h1 class="reveal mb-6 font-serif text-[clamp(2rem,4.5vw,3.4rem)] font-semibold leading-[1.25] tracking-[-0.005em] text-ink">
                {{ $post->title }}
            </h1>

            <div class="reveal mb-8 flex flex-wrap items-center gap-3">
                @if ($post->author)
                    <span class="inline-flex items-center gap-2 text-[0.92rem] font-medium text-body">
                        <span class="grid h-8 w-8 place-items-center rounded-full bg-brand/10 font-serif text-sm font-semibold text-brand-deep">{{ mb_substr($post->author->name, 0, 1) }}</span>
                        {{ $post->author->name }}
                    </span>
                    <span class="text-faint" aria-hidden="true">·</span>
                @endif
                <span class="{{ $metaText }}">{{ $post->published_at?->format('d M Y') ?? '' }}</span>
            </div>

            @if ($post->excerpt)
                <p class="reveal text-[1.15rem] leading-[1.85] text-body">
                    {{ $post->excerpt }}
                </p>
            @endif
        </div>
    </section>

    <!-- ============ ARTICLE CONTENT + SIDEBAR ============ -->
    <article class="pb-[clamp(48px,6vw,88px)]">
        <div class="shell">
            <div class="flex flex-col gap-[clamp(32px,4vw,56px)] min-[901px]:flex-row">
                {{-- Main Content --}}
                <div class="min-w-0 flex-1">
                    @if ($post->image)
                        <figure class="reveal mb-[clamp(24px,3vw,40px)] overflow-hidden rounded-[14px] bg-[linear-gradient(150deg,#2f8fa6,#1c525f)]">
                            <img src="{{ $post->image }}" alt="{{ $post->title }}" loading="eager" class="ph-img h-full w-full object-cover" style="aspect-ratio: 16/9;">
                        </figure>
                    @endif

                    <div class="mx-auto max-w-[72ch]">
                        <div class="prose prose-lg prose-headings:font-serif prose-headings:text-ink prose-p:text-body prose-p:leading-[1.85] prose-a:text-brand-deep prose-a:no-underline hover:prose-a:underline prose-img:rounded-lg">
                            {!! $post->content !!}
                        </div>
                    </div>
                </div>

                {{-- Sidebar: Related Posts --}}
                @if ($related->count())
                    <aside class="min-w-0 w-full min-[901px]:w-[320px] shrink-0">
                        <div class="min-[901px]:sticky min-[901px]:top-[92px]">
                            <h2 class="reveal mb-5 font-serif text-[clamp(1.2rem,2vw,1.5rem)] font-semibold text-ink">
                                সম্পর্কিত লেখা
                            </h2>

                            <div class="flex flex-col gap-5">
                                @foreach ($related as $relPost)
                                    <article class="reveal group flex gap-4">
                                        <a href="{{ route('blog.show', $relPost->slug) }}" class="ph relative shrink-0 block h-[72px] w-[96px] overflow-hidden rounded-lg bg-[linear-gradient(150deg,#2f8fa6,#1c525f)]">
                                            @if ($relPost->image)
                                                <img src="{{ $relPost->image }}" alt="{{ $relPost->title }}" loading="lazy"
                                                    class="absolute inset-0 h-full w-full object-cover opacity-0 transition-[opacity,transform] duration-800 ease-[cubic-bezier(0.22,0.61,0.36,1)] group-hover:scale-105 motion-reduce:transition-none">
                                            @endif
                                        </a>
                                        <div class="flex min-w-0 flex-col justify-center">
                                            <span class="mb-1 block text-[0.68rem] font-semibold tracking-[0.1em] text-brand-deep">
                                                {{ $relPost->category?->name ?? 'বিভাগহীন' }}
                                            </span>
                                            <h3 class="mb-1 font-serif text-[0.95rem] font-semibold leading-[1.4] tracking-[-0.003em] text-ink">
                                                <a href="{{ route('blog.show', $relPost->slug) }}" class="line-clamp-2 transition-colors duration-300 group-hover:text-brand-deep">{{ $relPost->title }}</a>
                                            </h3>
                                            <span class="{{ $metaText }}">{{ $relPost->published_at?->format('d M Y') ?? '' }}</span>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        </div>
                    </aside>
                @endif
            </div>
        </div>
    </article>

    <!-- ============ COMMENTS ============ -->
    <section class="border-t border-hairline bg-gray-50/40 pb-[clamp(48px,6vw,88px)] pt-[clamp(32px,4vw,52px)]">
        <div class="shell">
            <div class="mx-auto max-w-[72ch]">
                <h2 class="reveal mb-8 font-serif text-[clamp(1.3rem,2.2vw,1.6rem)] font-semibold text-ink">
                    মন্তব্যসমূহ <span class="text-faint text-[0.85em]">({{ $comments->count() }})</span>
                </h2>

                {{-- Flash Message --}}
                @if (session('success'))
                    <div class="reveal mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Comment Form --}}
                @auth('frontend')
                    <form method="POST" action="{{ route('blog.comment.store', $post->slug) }}" class="reveal mb-10 rounded-xl border border-hairline bg-white p-5">
                        @csrf
                        <div class="mb-4 flex items-center gap-3">
                            @php $fu = Auth::guard('frontend')->user(); @endphp
                            @if (!empty($fu->images))
                                <img src="{{ $fu->images }}" alt="{{ $fu->name }}" class="h-10 w-10 rounded-full object-cover">
                            @else
                                <span class="grid h-10 w-10 shrink-0 place-items-center rounded-full bg-linear-160 from-brand to-brand-deep font-serif text-sm font-semibold text-white">
                                    {{ mb_substr($fu->name, 0, 1, 'UTF-8') }}
                                </span>
                            @endif
                            <div>
                                <p class="text-sm font-medium text-ink">{{ $fu->name }}</p>
                            </div>
                        </div>
                        <textarea name="body" rows="4" required maxlength="2000" placeholder="আপনার মন্তব্য লিখুন..."
                            class="w-full resize-none rounded-lg border border-hairline bg-gray-50/50 px-4 py-3 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20">{{ old('body') }}</textarea>
                        @error('body')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                        <div class="mt-3 flex justify-end">
                            <button type="submit" class="rounded-lg bg-brand px-5 py-2.5 text-sm font-medium text-white transition-colors hover:bg-brand-deep">
                                মন্তব্য করুন
                            </button>
                        </div>
                    </form>
                @else
                    <div class="reveal mb-10 rounded-xl border border-hairline bg-white p-5 text-center">
                        <p class="text-sm text-faint">
                            মন্তব্য করতে <a href="{{ route('frontend.login') }}" class="font-semibold text-brand-deep hover:underline">লগইন</a> করুন।
                        </p>
                    </div>
                @endauth

                {{-- Comments List --}}
                <div class="space-y-6">
                    @forelse ($comments as $comment)
                        <div class="reveal rounded-xl border border-hairline bg-white p-5">
                            {{-- Comment Header --}}
                            <div class="mb-3 flex items-center gap-3">
                                @if ($comment->user && !empty($comment->user->images))
                                    <img src="{{ $comment->user->images }}" alt="{{ $comment->user->name }}" class="h-9 w-9 rounded-full object-cover">
                                @else
                                    <span class="grid h-9 w-9 shrink-0 place-items-center rounded-full bg-linear-160 from-brand to-brand-deep font-serif text-xs font-semibold text-white">
                                        {{ mb_substr($comment->user->name ?? '?', 0, 1, 'UTF-8') }}
                                    </span>
                                @endif
                                <div>
                                    <p class="text-sm font-semibold text-ink">{{ $comment->user->name ?? 'অজানা ব্যবহারকারী' }}</p>
                                    <p class="text-[0.72rem] text-faint">{{ $comment->created_at->diffForHumans() }}</p>
                                </div>
                            </div>

                            {{-- Comment Body --}}
                            <p class="mb-3 text-[0.95rem] leading-[1.75] text-body">{{ $comment->body }}</p>

                            {{-- Reply Button --}}
                            <button type="button" onclick="document.getElementById('reply-form-{{ $comment->id }}').classList.toggle('hidden')" class="text-xs font-semibold text-brand-deep transition-colors hover:text-brand">
                                উত্তর দিন
                            </button>

                            {{-- Reply Form (hidden by default) --}}
                            <div id="reply-form-{{ $comment->id }}" class="hidden mt-4 rounded-lg border border-hairline bg-gray-50/50 p-4">
                                <form method="POST" action="{{ route('blog.comment.store', $post->slug) }}">
                                    @csrf
                                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                    <textarea name="body" rows="3" required maxlength="2000" placeholder="{{ $comment->user->name ?? 'ব্যবহারকারী' }}-কে উত্তর দিন..."
                                        class="w-full resize-none rounded-lg border border-hairline bg-white px-4 py-3 text-sm text-ink outline-none transition-colors focus:border-brand focus:ring-1 focus:ring-brand/20">{{ old('body') }}</textarea>
                                    @error('body')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                    <div class="mt-3 flex justify-end gap-2">
                                        <button type="button" onclick="document.getElementById('reply-form-{{ $comment->id }}').classList.add('hidden')"
                                            class="rounded-lg border border-hairline px-4 py-2 text-xs font-medium text-faint transition-colors hover:bg-gray-100">
                                            বাতিল
                                        </button>
                                        <button type="submit" class="rounded-lg bg-brand px-4 py-2 text-xs font-medium text-white transition-colors hover:bg-brand-deep">
                                            উত্তর দিন
                                        </button>
                                    </div>
                                </form>
                            </div>

                            {{-- Replies --}}
                            @if ($comment->replies && $comment->replies->count())
                                <div class="mt-4 space-y-4 border-l-2 border-brand/20 pl-4">
                                    @foreach ($comment->replies as $reply)
                                        <div>
                                            <div class="mb-2 flex items-center gap-2.5">
                                                @if ($reply->admin)
                                                    <span class="grid h-7 w-7 shrink-0 place-items-center rounded-full bg-brand/10 font-serif text-[0.65rem] font-semibold text-brand-deep">
                                                        {{ mb_substr($reply->admin->name ?? 'A', 0, 1, 'UTF-8') }}
                                                    </span>
                                                @elseif ($reply->user && !empty($reply->user->images))
                                                    <img src="{{ $reply->user->images }}" alt="{{ $reply->user->name }}" class="h-7 w-7 rounded-full object-cover">
                                                @else
                                                    <span class="grid h-7 w-7 shrink-0 place-items-center rounded-full bg-brand/10 font-serif text-[0.65rem] font-semibold text-brand-deep">
                                                        {{ mb_substr($reply->user->name ?? '?', 0, 1, 'UTF-8') }}
                                                    </span>
                                                @endif
                                                <div>
                                                    <p class="text-xs font-semibold text-ink">
                                                        {{ $reply->admin->name ?? ($reply->user->name ?? 'অজানা ব্যবহারকারী') }}
                                                        @if ($reply->admin)
                                                            <span class="ml-1 inline-flex items-center rounded-full bg-brand/10 px-1.5 py-0.5 text-[0.6rem] font-semibold text-brand-deep">অ্যাডমিন</span>
                                                        @endif
                                                    </p>
                                                    <p class="text-[0.65rem] text-faint">{{ $reply->created_at->diffForHumans() }}</p>
                                                </div>
                                            </div>
                                            <p class="text-[0.88rem] leading-[1.7] text-body">{{ $reply->body }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="reveal rounded-xl border border-hairline bg-white p-8 text-center">
                            <p class="text-sm text-faint">এখনো কোনো মন্তব্য নেই। প্রথম মন্তব্য করুন!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
@endsection
