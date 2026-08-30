@extends('layouts.site')

@section('title', $post->title . ' — উসুলি')

@section('content')
    @php
        $eyebrowTick = 'inline-block h-0.5 w-[22px]';
        $metaText = 'text-[0.82rem] font-medium tracking-[0.01em] text-faint';
        $readLink = 'group/link relative inline-flex w-fit items-center gap-2 font-semibold text-brand-deep after:absolute after:inset-x-0 after:-bottom-[3px] after:h-[1.5px] after:origin-left after:scale-x-0 after:bg-current after:transition-transform after:duration-300 after:ease-[cubic-bezier(0.22,0.61,0.36,1)] hover:after:scale-x-100 focus-visible:after:scale-x-100';
        $readLinkArrow = 'transition-transform duration-300 group-hover/link:translate-x-[5px]';
    @endphp

    <!-- ============ ARTICLE HERO ============ -->
    <section class="pb-[clamp(32px,4vw,52px)] pt-[clamp(40px,6vw,72px)]">
        <div class="shell">
            <a href="{{ route('blog') }}" class="reveal mb-[26px] inline-flex w-fit items-center gap-1.5 text-[0.9rem] font-semibold text-brand-deep transition-colors duration-300 hover:text-ink">
                <span aria-hidden="true">←</span> সব লেখায় ফিরে যান
            </a>

            @if ($post->category)
                <a href="{{ route('blog', ['category' => $post->category->slug]) }}"
                   class="reveal mb-[18px] inline-flex items-center gap-2.5 text-[0.78rem] font-semibold tracking-[0.14em] text-brand-deep transition-colors duration-300 hover:text-brand">
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
                <p class="reveal max-w-[62ch] text-[1.15rem] leading-[1.85] text-body">
                    {{ $post->excerpt }}
                </p>
            @endif
        </div>
    </section>

    <!-- ============ FEATURED IMAGE ============ -->
    @if ($post->image)
        <section class="pb-[clamp(32px,4vw,52px)]">
            <div class="shell">
                <figure class="reveal overflow-hidden rounded-[14px] bg-[linear-gradient(150deg,#2f8fa6,#1c525f)]">
                    <img src="{{ $post->image }}" alt="{{ $post->title }}" loading="eager"
                         class="ph-img h-full w-full object-cover" style="aspect-ratio: 16/9;">
                </figure>
            </div>
        </section>
    @endif

    <!-- ============ ARTICLE CONTENT ============ -->
    <article class="pb-[clamp(48px,6vw,88px)]">
        <div class="shell">
            <div class="mx-auto max-w-[72ch]">
                <div class="prose prose-lg prose-headings:font-serif prose-headings:text-ink prose-p:text-body prose-p:leading-[1.85] prose-a:text-brand-deep prose-a:no-underline hover:prose-a:underline prose-img:rounded-lg">
                    {!! $post->content !!}
                </div>
            </div>
        </div>
    </article>

    <!-- ============ RELATED POSTS ============ -->
    @if ($related->count())
        <section class="pb-[clamp(48px,6vw,88px)] border-t border-hairline">
            <div class="shell">
                <header class="reveal mb-[clamp(28px,3vw,44px)] pt-[clamp(32px,4vw,52px)]">
                    <h2 class="font-serif text-[clamp(1.4rem,2.4vw,1.8rem)] font-semibold text-ink">
                        সম্পর্কিত লেখা
                    </h2>
                </header>

                <div class="grid grid-cols-1 gap-[clamp(26px,3vw,40px)] min-[621px]:grid-cols-2 min-[1001px]:grid-cols-3">
                    @foreach ($related as $post)
                        <article class="reveal group flex flex-col">
                            <a href="{{ route('blog.show', $post->slug) }}" class="ph relative mb-[18px] block aspect-[3/2] overflow-hidden rounded-[10px] bg-[linear-gradient(150deg,#2f8fa6,#1c525f)]">
                                @if ($post->image)
                                    <img src="{{ $post->image }}" alt="{{ $post->title }}" loading="lazy"
                                         class="absolute inset-0 h-full w-full object-cover opacity-0 transition-[opacity,transform] duration-800 ease-[cubic-bezier(0.22,0.61,0.36,1)] group-hover:scale-105 motion-reduce:transition-none">
                                @endif
                            </a>
                            <div class="flex flex-col">
                                <span class="mb-2.5 block text-[0.74rem] font-semibold tracking-[0.12em] text-brand-deep">
                                    {{ $post->category?->name ?? 'বিভাগহীন' }}
                                </span>
                                <h3 class="mb-2.5 font-serif text-[1.32rem] font-semibold leading-[1.45] tracking-[-0.003em] text-ink">
                                    <a href="{{ route('blog.show', $post->slug) }}" class="transition-colors duration-300 group-hover:text-brand-deep">{{ $post->title }}</a>
                                </h3>
                                <p class="mb-3.5 text-base leading-[1.78] text-body">{{ $post->excerpt }}</p>
                                <div class="mt-auto flex items-center">
                                    <span class="{{ $metaText }}">{{ $post->published_at?->format('d M Y') ?? '' }}</span>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
