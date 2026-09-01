@extends('layouts.main')

@section('title', 'সব লেখা — উসুলি')

@section('content')
    @php
        $eyebrowTick = 'inline-block h-0.5 w-[22px]';
        $metaText = 'text-[0.82rem] font-medium tracking-[0.01em] text-faint';
        $filterPill =
            'cursor-pointer rounded-full border border-brand-line bg-white px-[18px] py-2 text-[0.95rem] font-medium text-body transition-all duration-300 hover:-translate-y-0.5 hover:border-brand hover:bg-brand-soft hover:text-brand-deep aria-pressed:border-brand aria-pressed:bg-brand aria-pressed:text-white';
    @endphp

    <!-- ============ PAGE HEADER ============ -->
    <section class="pb-[clamp(28px,4vw,48px)] pt-[clamp(40px,6vw,72px)]">
        <div class="shell">
            <a href="{{ route('home.index') }}" class="reveal mb-[26px] inline-flex w-fit items-center gap-1.5 text-[0.9rem] font-semibold text-brand-deep transition-colors duration-300 hover:text-ink">
                <span aria-hidden="true">←</span> প্রচ্ছদে ফিরে যান
            </a>

            <span class="reveal mb-[22px] flex w-fit items-center gap-2.5 text-[0.78rem] font-semibold tracking-[0.14em] text-brand-deep">
                <span class="{{ $eyebrowTick }} bg-brand" aria-hidden="true"></span>জার্নাল
            </span>

            <div class="reveal mb-4 flex flex-wrap items-end justify-between gap-4 max-[620px]:flex-col max-[620px]:items-start">
                <h1 class="font-serif text-[clamp(2rem,4.2vw,3.2rem)] font-semibold leading-[1.25] tracking-[-0.005em] text-ink" id="pageTitle">
                    সব লেখা
                </h1>
                <span class="{{ $metaText }} pb-1.5">মোট {{ $totalBn }}টি লেখা</span>
            </div>

            <p class="reveal max-w-[52ch] text-[1.12rem] leading-[1.85] text-body">
                এক জায়গায় উসুলির সব গল্প, ভাবনা ও মানুষের কথা—পছন্দের বিষয় বেছে নিয়ে পড়ুন।
            </p>
        </div>
    </section>

    <!-- ============ CATEGORY FILTER ============ -->
    <div class="shell pb-[clamp(28px,3vw,44px)]">
        <ul class="reveal flex flex-wrap gap-3" aria-label="বিষয়ভিত্তিক ফিল্টার">
            @foreach ($filters as $filter)
                <li>
                    <a href="{{ $filter['value'] === 'all' ? route('blog') : route('blog', ['category' => $filter['value']]) }}" aria-pressed="{{ $filter['active'] ? 'true' : 'false' }}" class="{{ $filterPill }}">
                        {{ $filter['label'] }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- ============ ARTICLE GRID ============ -->
    <section class="pb-[clamp(40px,5vw,64px)]" aria-label="সব লেখার তালিকা">
        <div class="shell grid grid-cols-1 gap-[clamp(26px,3vw,40px)] min-[621px]:grid-cols-2 min-[1001px]:grid-cols-3">
            @forelse ($posts as $post)
                <article class="reveal group flex flex-col">
                    <a href="{{ route('blog.show', $post->slug) }}" tabindex="-1" aria-hidden="true" class="ph relative mb-[18px] block aspect-[3/2] overflow-hidden rounded-[10px] bg-[linear-gradient(150deg,#2f8fa6,#1c525f)]">
                        @if ($post->image)
                            <img src="{{ $post->image }}" alt="{{ $post->title }}" loading="lazy"
                                class="absolute inset-0 h-full w-full object-cover opacity-0 transition-[opacity,transform] duration-800 ease-[cubic-bezier(0.22,0.61,0.36,1)] group-hover:scale-105 motion-reduce:transition-none">
                        @endif
                    </a>
                    <div class="flex flex-col">
                        <span class="mb-2.5 block text-[0.74rem] font-semibold tracking-[0.12em] text-brand-deep">
                            {{ $post->category?->name ?? 'বিভাগহীন' }}
                        </span>
                        <h2 class="mb-2.5 font-serif text-[1.32rem] font-semibold leading-[1.45] tracking-[-0.003em] text-ink">
                            <a href="{{ route('blog.show', $post->slug) }}" class="transition-colors duration-300 group-hover:text-brand-deep">{{ $post->title }}</a>
                        </h2>
                        <p class="mb-3.5 text-base leading-[1.78] text-body">{{ $post->excerpt }}</p>
                        <div class="mt-auto flex items-center">
                            <span class="{{ $metaText }}">{{ $post->published_at?->format('d M Y') ?? '' }}</span>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full py-20 text-center">
                    <p class="text-lg text-faint">কোনো লেখা পাওয়া যায়নি।</p>
                </div>
            @endforelse
        </div>
    </section>

    <!-- ============ PAGINATION ============ -->
    @if ($posts->hasPages())
        <div class="shell flex justify-center pb-[clamp(52px,6vw,90px)]">
            {{ $posts->links() }}
        </div>
    @endif
@endsection
