@extends('layouts.site')

@section('content')
    @php
        $eyebrowTick = 'inline-block h-0.5 w-[22px]';
        $sectionMarker = 'h-6 w-2.5 shrink-0 -rotate-[8deg] rounded-lg rounded-tl-none bg-linear-160 from-brand to-brand-deep';
        $sectionTitle = 'flex items-center gap-3.5 font-serif font-semibold tracking-[-0.005em] text-ink';
        $readLink = 'group/link relative inline-flex w-fit items-center gap-2 font-semibold text-brand-deep after:absolute after:inset-x-0 after:-bottom-[3px] after:h-[1.5px] after:origin-left after:scale-x-0 after:bg-current after:transition-transform after:duration-300 after:ease-[cubic-bezier(0.22,0.61,0.36,1)] hover:after:scale-x-100 focus-visible:after:scale-x-100';
        $readLinkArrow = 'transition-transform duration-300 group-hover/link:translate-x-[5px]';
        $cardImg = 'absolute inset-0 h-full w-full object-cover opacity-0 transition-[opacity,transform] duration-800 ease-[cubic-bezier(0.22,0.61,0.36,1)] group-hover:scale-105 motion-reduce:transition-none';
        $metaText = 'text-[0.82rem] font-medium tracking-[0.01em] text-faint';
    @endphp

    <!-- ============ HERO / FEATURED ============ -->
    <section class="pb-[clamp(48px,6vw,88px)] pt-[clamp(40px,6vw,78px)]" aria-labelledby="heroTitle">
        <div class="shell grid items-center gap-8 min-[861px]:grid-cols-[1fr_1.05fr] min-[861px]:gap-[clamp(32px,5vw,68px)]">
            <figure class="reveal group relative block aspect-[16/10] overflow-hidden rounded-[14px] bg-[linear-gradient(160deg,#2f93ab,#123a44)] min-[861px]:aspect-[5/4]">
                <img src="https://images.unsplash.com/photo-1583422409516-2895a77efded?auto=format&fit=crop&w=1400&q=70"
                     alt="সন্ধ্যার শহর—আলো-ছায়ায় ঢাকা পথঘাট" loading="eager"
                     class="ph-img absolute inset-0 h-full w-full object-cover opacity-0 transition-[opacity,transform] duration-900 ease-[cubic-bezier(0.22,0.61,0.36,1)] group-hover:scale-[1.03] motion-reduce:transition-none">
            </figure>

            <div>
                <span class="reveal mb-[22px] inline-flex items-center gap-2.5 text-[0.78rem] font-semibold tracking-[0.14em] text-brand-deep">
                    <span class="{{ $eyebrowTick }} bg-brand" aria-hidden="true"></span>বিশেষ লেখা
                </span>
                <h1 class="reveal mb-[22px] font-serif text-[clamp(2.05rem,4.4vw,3.35rem)] font-semibold leading-[1.28] tracking-[-0.005em] text-ink" id="heroTitle">
                    শহরের ব্যস্ততার মাঝেও হারিয়ে যাচ্ছে না যে গল্পগুলো
                </h1>
                <p class="reveal mb-[26px] max-w-[46ch] text-[1.15rem] leading-[1.85] text-body">
                    সময়ের পরিবর্তনের সঙ্গে বদলে যাচ্ছে আমাদের জীবন, কিন্তু কিছু গল্প এখনো মানুষের স্মৃতি ও অনুভূতির সঙ্গে জড়িয়ে থাকে।
                </p>
                <div class="reveal mb-[26px] flex items-center">
                    <span class="{{ $metaText }}">২৫ আগস্ট ২০২৬</span>
                    <span class="mx-2 text-faint" aria-hidden="true">·</span>
                    <span class="{{ $metaText }}">৬ মিনিট পড়তে সময় লাগবে</span>
                </div>
                <a href="#" class="reveal {{ $readLink }}">
                    পড়ুন <span class="{{ $readLinkArrow }}" aria-hidden="true">→</span>
                </a>
            </div>
        </div>
    </section>

    <!-- ============ LATEST ARTICLES ============ -->
    <section class="py-[clamp(48px,6vw,86px)]" aria-labelledby="latestTitle">
        <div class="shell">
            <header class="reveal mb-[clamp(28px,3vw,44px)] flex items-baseline justify-between gap-5 max-[620px]:flex-col max-[620px]:items-start max-[620px]:gap-2.5">
                <h2 class="{{ $sectionTitle }} text-[clamp(1.5rem,2.6vw,2rem)]" id="latestTitle">
                    <span class="{{ $sectionMarker }}" aria-hidden="true"></span>সাম্প্রতিক লেখা
                </h2>
                <a href="{{ route('blog') }}" class="{{ $readLink }} text-[0.9rem]">
                    সব লেখা <span aria-hidden="true">→</span>
                </a>
            </header>

            <div class="grid grid-cols-1 gap-[clamp(26px,3vw,40px)] min-[621px]:grid-cols-2 min-[1001px]:grid-cols-3">
                @foreach ($articles as $post)
                    <article class="reveal group flex flex-col">
                        <a href="{{ route('blog.show', $post->slug) }}" tabindex="-1" aria-hidden="true"
                           class="ph relative mb-[18px] block aspect-[3/2] overflow-hidden rounded-[10px] bg-[linear-gradient(150deg,#2f8fa6,#1c525f)]">
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

    <!-- ============ FEATURED STORY ============ -->
    <section class="relative isolate flex min-h-[clamp(420px,56vw,560px)] items-center" aria-labelledby="featureTitle">
        <div class="ph absolute inset-0 -z-10 overflow-hidden bg-[linear-gradient(120deg,#12333b,#1f6d80)]">
            <img src="https://images.unsplash.com/photo-1470770841072-f978cf4d019e?auto=format&fit=crop&w=1800&q=72"
                 alt="ভোরের নদী ও তীরে জেগে ওঠা জনপদ" loading="lazy"
                 class="ph-img absolute inset-0 h-full w-full object-cover opacity-0 transition-opacity duration-1000 ease-[cubic-bezier(0.22,0.61,0.36,1)]">
            <div class="absolute inset-0 bg-[linear-gradient(90deg,rgba(12,26,30,0.92)_0%,rgba(12,26,30,0.72)_42%,rgba(12,26,30,0.15)_100%),linear-gradient(0deg,rgba(12,26,30,0.55),rgba(12,26,30,0.1))] max-[620px]:bg-[linear-gradient(0deg,rgba(12,26,30,0.94)_8%,rgba(12,26,30,0.55)_55%,rgba(12,26,30,0.35)_100%)]"
                 aria-hidden="true"></div>
        </div>
        <div class="shell">
            <div class="reveal max-w-[620px] py-10">
                <span class="mb-[22px] inline-flex items-center gap-2.5 text-[0.78rem] font-semibold tracking-[0.14em] text-[#bfe4ec]">
                    <span class="{{ $eyebrowTick }} bg-[#bfe4ec]" aria-hidden="true"></span>নির্বাচিত
                </span>
                <h2 class="mb-5 font-serif text-[clamp(1.9rem,4vw,3rem)] font-semibold leading-[1.3] tracking-[-0.005em] text-white" id="featureTitle">
                    যে নদী বদলে দিয়েছে একটি জনপদের গল্প
                </h2>
                <p class="mb-[26px] max-w-[52ch] text-[1.1rem] leading-[1.85] text-[rgba(255,255,255,0.86)]">
                    নদীর দুই তীরে গড়ে ওঠা জীবন, তার স্রোতের সঙ্গে বদলে যাওয়া সময় আর মানুষের গল্প—একটি দীর্ঘ অনুসন্ধান, যেখানে জল আর মাটি মিলেমিশে লিখেছে এক জনপদের ইতিহাস।
                </p>
                <a href="#" class="{{ $readLink }} text-[#eafafd]">
                    সম্পূর্ণ গল্প পড়ুন <span class="{{ $readLinkArrow }}" aria-hidden="true">→</span>
                </a>
            </div>
        </div>
    </section>

    <!-- ============ CATEGORIES ============ -->
    <section class="py-[clamp(38px,4.5vw,62px)]" aria-labelledby="topicsTitle">
        <div class="shell">
            <header class="reveal mb-[clamp(28px,3vw,44px)] flex justify-center text-center">
                <h2 class="{{ $sectionTitle }} text-[clamp(1.5rem,2.6vw,2rem)]" id="topicsTitle">
                    <span class="{{ $sectionMarker }}" aria-hidden="true"></span>বিষয়
                </h2>
            </header>
            <ul class="reveal flex flex-wrap justify-center gap-3.5">
                @foreach ($topics as $topic)
                    <li>
                        <a href="{{ route('blog', ['category' => $topic]) }}"
                           class="inline-block rounded-full border border-brand-line bg-white px-[22px] py-2.5 text-[0.98rem] font-medium text-body transition-all duration-300 hover:-translate-y-0.5 hover:border-brand hover:bg-brand-soft hover:text-brand-deep">
                            {{ $topic }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    <!-- ============ POPULAR / EDITOR'S PICKS ============ -->
    <section class="py-[clamp(48px,6vw,86px)]" aria-label="জনপ্রিয় লেখা ও সম্পাদকের পছন্দ">
        <div class="shell">
            <div class="grid grid-cols-1 gap-y-2 min-[861px]:grid-cols-2 min-[861px]:gap-x-[clamp(36px,6vw,96px)]">
                <div class="reveal">
                    <h2 class="{{ $sectionTitle }} mb-[26px] text-[clamp(1.25rem,2vw,1.5rem)]">
                        <span class="{{ $sectionMarker }}" aria-hidden="true"></span>জনপ্রিয় লেখা
                    </h2>
                    <ol class="flex flex-col">
                        @php
                            $popularPosts = \App\Models\Post::published()->latest('published_at')->limit(4)->get();
                        @endphp
                        @foreach ($popularPosts as $index => $post)
                            <li class="flex items-baseline gap-5 border-b border-hairline py-5 first:pt-1">
                                <span class="min-w-8 font-serif text-[1.15rem] font-medium text-brand [font-feature-settings:'tnum']">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                <a href="#" class="font-serif text-[1.2rem] font-medium leading-normal text-ink transition-colors duration-300 hover:text-brand-deep">{{ $post->title }}</a>
                            </li>
                        @endforeach
                    </ol>
                </div>

                <div class="reveal max-[860px]:pt-5">
                    <h2 class="{{ $sectionTitle }} mb-[26px] text-[clamp(1.25rem,2vw,1.5rem)]">
                        <span class="{{ $sectionMarker }}" aria-hidden="true"></span>সম্পাদকের পছন্দ
                    </h2>
                    <ol class="flex flex-col">
                        @php
                            $featuredPosts = \App\Models\Post::published()->featured()->latest('published_at')->limit(4)->get();
                        @endphp
                        @foreach ($featuredPosts as $index => $post)
                            <li class="flex items-baseline gap-5 border-b border-hairline py-5 first:pt-1">
                                <span class="min-w-8 font-serif text-[1.15rem] font-medium text-faint [font-feature-settings:'tnum']">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                <a href="#" class="font-serif text-[1.2rem] font-medium leading-normal text-ink transition-colors duration-300 hover:text-brand-deep">{{ $post->title }}</a>
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ NEWSLETTER ============ -->
    <section class="pb-[clamp(52px,6vw,90px)] pt-[clamp(20px,4vw,40px)]" aria-labelledby="nlTitle">
        <div class="shell">
            <div class="reveal relative overflow-hidden rounded-[14px] border border-brand-line bg-brand-soft px-[clamp(24px,5vw,40px)] py-[clamp(40px,6vw,72px)] text-center">
                <div class="mb-5 flex justify-center" aria-hidden="true">
                    <svg class="h-[50px] w-[34px] overflow-visible" viewBox="0 0 60 90">
                        <path d="M41 9 C 36 24 30 33 31 46 C 32 57 44 60 47 69 C 49 76 42 83 30 82 C 20 81 13 74 12 64"
                              fill="none" stroke="#2b8ca4" stroke-width="6.5" stroke-linecap="round" stroke-linejoin="round" opacity="0.9"/>
                    </svg>
                </div>
                <h2 class="mb-3.5 font-serif text-[clamp(1.6rem,3vw,2.3rem)] font-semibold tracking-[-0.005em] text-ink" id="nlTitle">
                    নতুন লেখা আপনার ইনবক্সে
                </h2>
                <p class="mx-auto mb-[30px] max-w-[48ch] text-[1.08rem] leading-[1.8] text-body">
                    নির্বাচিত বাংলা গল্প, ভাবনা ও নতুন লেখার খবর পেতে আমাদের সঙ্গে থাকুন।
                </p>
                <form id="newsletterForm" class="mx-auto flex max-w-[520px] gap-3 max-[620px]:flex-col" novalidate>
                    <label class="sr-only" for="nlEmail">আপনার ইমেইল</label>
                    <input id="nlEmail" type="email" name="email" placeholder="আপনার ইমেইল" autocomplete="email"
                           class="flex-1 rounded-full border border-brand-line bg-white px-5 py-3.5 text-base text-body outline-none transition-[border-color,box-shadow] duration-300 placeholder:text-faint focus:border-brand focus:ring-3 focus:ring-brand/15 max-[620px]:w-full">
                    <button type="submit"
                            class="whitespace-nowrap rounded-full bg-brand px-7 py-3.5 text-base font-semibold text-white transition-all duration-300 hover:-translate-y-px hover:bg-brand-deep max-[620px]:w-full max-[620px]:py-[15px]">
                        সাবস্ক্রাইব করুন
                    </button>
                </form>
            </div>
        </div>
    </section>
@endsection
