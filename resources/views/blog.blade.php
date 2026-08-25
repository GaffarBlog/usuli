@extends('layouts.site')

@section('title', 'সব লেখা — উসুলি')

@section('content')
    @php
        $eyebrowTick = 'inline-block h-0.5 w-[22px]';
        $readLink = 'group/link relative inline-flex w-fit items-center gap-2 font-semibold text-brand-deep after:absolute after:inset-x-0 after:-bottom-[3px] after:h-[1.5px] after:origin-left after:scale-x-0 after:bg-current after:transition-transform after:duration-300 after:ease-[cubic-bezier(0.22,0.61,0.36,1)] hover:after:scale-x-100 focus-visible:after:scale-x-100';
        $cardImg = 'absolute inset-0 h-full w-full object-cover opacity-0 transition-[opacity,transform] duration-800 ease-[cubic-bezier(0.22,0.61,0.36,1)] group-hover:scale-105 motion-reduce:transition-none';
        $metaText = 'text-[0.82rem] font-medium tracking-[0.01em] text-faint';
        $filterPill = 'cursor-pointer rounded-full border border-brand-line bg-white px-[18px] py-2 text-[0.95rem] font-medium text-body transition-all duration-300 hover:-translate-y-0.5 hover:border-brand hover:bg-brand-soft hover:text-brand-deep aria-pressed:border-brand aria-pressed:bg-brand aria-pressed:text-white';
    @endphp

    <!-- ============ PAGE HEADER ============ -->
    <section class="pb-[clamp(28px,4vw,48px)] pt-[clamp(40px,6vw,72px)]">
        <div class="shell">
            <a href="{{ route('home') }}" class="reveal mb-[26px] inline-flex w-fit items-center gap-1.5 text-[0.9rem] font-semibold text-brand-deep transition-colors duration-300 hover:text-ink">
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
                    <button type="button" data-filter="{{ $filter['value'] }}" aria-pressed="{{ $filter['active'] ? 'true' : 'false' }}"
                            class="js-filter-pill {{ $filterPill }}">
                        {{ $filter['label'] }}
                    </button>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- ============ ARTICLE GRID ============ -->
    <section class="pb-[clamp(40px,5vw,64px)]" aria-label="সব লেখার তালিকা">
        <div class="shell grid grid-cols-1 gap-[clamp(26px,3vw,40px)] min-[621px]:grid-cols-2 min-[1001px]:grid-cols-3">
            @foreach ($visibleArticles as $article)
                <article class="js-article-card reveal group flex flex-col" data-category="{{ $article['category'] }}">
                    <a href="#" tabindex="-1" aria-hidden="true"
                       class="ph relative mb-[18px] block aspect-[3/2] overflow-hidden rounded-[10px] {{ $article['mediaClass'] }}">
                        <img src="{{ $article['image'] }}" alt="" loading="lazy" class="{{ $cardImg }}">
                    </a>
                    <div class="flex flex-col">
                        <span class="mb-2.5 block text-[0.74rem] font-semibold tracking-[0.12em] text-brand-deep">{{ $article['category'] }}</span>
                        <h2 class="mb-2.5 font-serif text-[1.32rem] font-semibold leading-[1.45] tracking-[-0.003em] text-ink">
                            <a href="#" class="transition-colors duration-300 group-hover:text-brand-deep">{{ $article['title'] }}</a>
                        </h2>
                        <p class="mb-3.5 text-base leading-[1.78] text-body">{{ $article['excerpt'] }}</p>
                        <div class="mt-auto flex items-center">
                            <span class="{{ $metaText }}">{{ $article['date'] }}</span>
                            <span class="mx-2 text-faint" aria-hidden="true">·</span>
                            <span class="{{ $metaText }}">{{ $article['minutes'] }}</span>
                        </div>
                    </div>
                </article>
            @endforeach

            @foreach ($extraArticles as $article)
                <article class="js-article-card js-extra-card reveal group flex flex-col" data-category="{{ $article['category'] }}" hidden>
                    <a href="#" tabindex="-1" aria-hidden="true"
                       class="ph relative mb-[18px] block aspect-[3/2] overflow-hidden rounded-[10px] {{ $article['mediaClass'] }}">
                        <img src="{{ $article['image'] }}" alt="" loading="lazy" class="{{ $cardImg }}">
                    </a>
                    <div class="flex flex-col">
                        <span class="mb-2.5 block text-[0.74rem] font-semibold tracking-[0.12em] text-brand-deep">{{ $article['category'] }}</span>
                        <h2 class="mb-2.5 font-serif text-[1.32rem] font-semibold leading-[1.45] tracking-[-0.003em] text-ink">
                            <a href="#" class="transition-colors duration-300 group-hover:text-brand-deep">{{ $article['title'] }}</a>
                        </h2>
                        <p class="mb-3.5 text-base leading-[1.78] text-body">{{ $article['excerpt'] }}</p>
                        <div class="mt-auto flex items-center">
                            <span class="{{ $metaText }}">{{ $article['date'] }}</span>
                            <span class="mx-2 text-faint" aria-hidden="true">·</span>
                            <span class="{{ $metaText }}">{{ $article['minutes'] }}</span>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    <!-- ============ LOAD MORE ============ -->
    @if (count($extraArticles) > 0)
        <div class="shell flex justify-center pb-[clamp(52px,6vw,90px)]">
            <button type="button" id="loadMoreBtn"
                    class="rounded-full border border-brand-line bg-white px-8 py-3.5 text-base font-semibold text-brand-deep transition-all duration-300 hover:-translate-y-px hover:border-brand hover:bg-brand-soft hover:text-brand">
                আরও দেখুন
            </button>
        </div>
    @endif
@endsection
