<!DOCTYPE html>
<html lang="bn" dir="ltr" class="scroll-smooth motion-reduce:scroll-auto">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'উসুলি — উসুলি - নুসুস• ফাহমুস-সালাফ')</title>
    <meta name="description" content="@yield('description', 'উসুলি একটি স্বাধীন বাংলা ডিজিটাল জার্নাল—নির্বাচিত গল্প, ভাবনা ও মানুষের কথা।')">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;500;600;700&family=Noto+Serif+Bengali:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">

    @vite(['resources/css/app.css'])
</head>

<body class="relative bg-page font-sans text-[17px] leading-[1.75] text-body antialiased max-[620px]:text-base">
    @php
        $navLink =
            'relative py-1.5 text-[0.98rem] font-medium text-body transition-colors duration-300 after:absolute after:inset-x-0 after:bottom-0 after:h-0.5 after:origin-left after:scale-x-0 after:bg-brand after:transition-transform after:duration-300 hover:text-brand-deep hover:after:scale-x-100 focus-visible:after:scale-x-100';
        $navLinkActive =
            'relative py-1.5 text-[0.98rem] font-semibold text-ink transition-colors duration-300 after:absolute after:inset-x-0 after:bottom-0 after:h-0.5 after:origin-left after:scale-x-100 after:bg-ink after:transition-transform after:duration-300';
        $mobileNavLink = 'block border-b border-hairline py-3 text-[1.15rem] font-medium text-ink transition-[color,padding-inline-start] duration-200 last:border-none hover:ps-3 hover:text-brand';
        $brandMarkPath = 'M41 9 C 36 24 30 33 31 46 C 32 57 44 60 47 69 C 49 76 42 83 30 82 C 20 81 13 74 12 64';
        $brandAccentPath = 'M40 6 C 42 4 45 4 46 7';
        $siteLogo = GetSetting('site_logo');
    @endphp

    <a href="#main" class="absolute left-4 top-[-60px] z-[200] rounded-lg bg-brand px-[18px] py-2.5 font-semibold text-white transition-[top] duration-300 focus:top-3.5">
        মূল অংশে যান
    </a>

    <!-- ============ HEADER ============ -->
    <header class="sticky top-0 z-100 border-b border-hairline bg-[rgba(250,250,248,0.82)] backdrop-blur-md backdrop-saturate-[140%]">
        <div class="shell flex h-[76px] items-center justify-between gap-6">
            <a href="{{ route('home.index') }}" aria-label="উসুলি — প্রচ্ছদ" class="inline-flex items-center gap-3">
                @if ($siteLogo)
                    <img src="{{ $siteLogo }}" alt="{{ GetSetting('site_name') ?? 'উসুলি' }}" class="h-[45px] w-auto shrink-0 object-contain">
                @else
                    <svg class="h-[45px] w-[30px] shrink-0 overflow-visible" viewBox="0 0 60 90" aria-hidden="true" focusable="false">
                        <path class="[stroke-dasharray:240] [stroke-dashoffset:240] animate-draw motion-reduce:animate-none motion-reduce:[stroke-dashoffset:0]" d="{{ $brandMarkPath }}" fill="none" stroke="#2b8ca4" stroke-width="6.5"
                            stroke-linecap="round" stroke-linejoin="round" />
                        <path class="opacity-0 animate-fade-in-late motion-reduce:animate-none motion-reduce:opacity-100" d="{{ $brandAccentPath }}" fill="none" stroke="#2b8ca4" stroke-width="4" stroke-linecap="round" />
                    </svg>
                @endif
                <span class="font-serif text-[1.7rem] font-semibold leading-none tracking-[-0.01em] text-ink max-[620px]:text-[1.55rem]">উসুলি</span>
            </a>

            <nav class="mx-auto hidden min-[1001px]:block" aria-label="প্রধান নেভিগেশন">
                <ul class="flex gap-[30px]">
                    @foreach ($navItems as $item)
                        <li>
                            <a href="{{ $item['href'] ?? '#' }}" class="{{ $item['label'] === ($activeNav ?? '') ? $navLinkActive : $navLink }}">{{ $item['label'] }}</a>
                        </li>
                    @endforeach
                </ul>
            </nav>

            <div class="flex items-center gap-1.5">
                <button type="button" aria-label="খুঁজুন" class="grid h-[42px] w-[42px] place-items-center rounded-full text-ink transition-colors duration-300 hover:bg-brand-soft hover:text-brand-deep">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" aria-hidden="true" focusable="false" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round">
                        <circle cx="11" cy="11" r="7" />
                        <line x1="16.5" y1="16.5" x2="21" y2="21" />
                    </svg>
                </button>
                @if (Auth::guard('frontend')->check())
                    @php $frontendUser = Auth::guard('frontend')->user(); @endphp
                    <div class="relative" id="userDropdownWrapper">
                        <button type="button" id="userDropdownToggle" class="flex items-center gap-2 rounded-full py-1.5 pl-1.5 pr-3 text-ink transition-colors duration-300 hover:bg-brand-soft" aria-haspopup="true" aria-expanded="false">
                            @if (!empty($frontendUser->images))
                                <img src="{{ $frontendUser->images }}" alt="{{ $frontendUser->name }}" class="h-[30px] w-[30px] rounded-full object-cover">
                            @else
                                <span class="grid h-[30px] w-[30px] shrink-0 place-items-center rounded-full bg-linear-160 from-brand to-brand-deep font-serif text-xs font-semibold text-white">
                                    {{ mb_substr($frontendUser->name, 0, 1, 'UTF-8') }}
                                </span>
                            @endif
                            <span class="hidden min-[1001px]:inline text-sm font-medium max-w-[100px] truncate">{{ $frontendUser->name }}</span>
                            <svg class="hidden min-[1001px]:inline h-3.5 w-3.5 text-faint transition-transform duration-200" id="dropdownArrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9" />
                            </svg>
                        </button>
                        <div id="userDropdownMenu"
                            class="hidden absolute right-0 top-full mt-2 w-52 rounded-xl border border-hairline bg-white py-2 shadow-lg z-50 min-[1001px]:opacity-0 min-[1001px]:translate-y-1 min-[1001px]:transition-all min-[1001px]:duration-200">
                            <div class="px-4 py-2.5 border-b border-hairline">
                                <p class="text-sm font-medium text-ink truncate">{{ $frontendUser->name }}</p>
                                <p class="text-xs text-faint truncate">{{ $frontendUser->email }}</p>
                            </div>
                            <a href="{{ route('frontend.dashboard.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-body transition-colors hover:bg-brand-soft hover:text-brand-deep">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="3" width="7" height="7" rx="1" />
                                    <rect x="14" y="3" width="7" height="7" rx="1" />
                                    <rect x="3" y="14" width="7" height="7" rx="1" />
                                    <rect x="14" y="14" width="7" height="7" rx="1" />
                                </svg>
                                ড্যাশবোর্ড
                            </a>
                            <a href="{{ route('frontend.dashboard.profile') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-body transition-colors hover:bg-brand-soft hover:text-brand-deep">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                    <circle cx="12" cy="7" r="4" />
                                </svg>
                                প্রোফাইল
                            </a>
                            <div class="my-1.5 border-t border-hairline"></div>
                            <form method="POST" action="{{ route('frontend.logout') }}">
                                @csrf
                                <button type="submit" class="flex w-full items-center gap-3 px-4 py-2.5 text-sm text-body transition-colors hover:bg-red-50 hover:text-red-600">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                        <polyline points="16 17 21 12 16 7" />
                                        <line x1="21" y1="12" x2="9" y2="12" />
                                    </svg>
                                    প্রস্থান
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('frontend.login') }}" class="grid h-[42px] w-[42px] place-items-center rounded-full text-ink transition-colors duration-300 hover:bg-brand-soft hover:text-brand-deep" aria-label="লগইন">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" aria-hidden="true" focusable="false" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                    </a>
                @endif
                <button type="button" aria-label="মেনু" aria-expanded="false" aria-controls="mobileNav" id="menuToggle"
                    class="grid h-[42px] w-[42px] place-items-center rounded-full text-ink transition-colors duration-300 hover:bg-brand-soft hover:text-brand-deep min-[1001px]:hidden">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" aria-hidden="true" focusable="false" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round">
                        <line x1="3" y1="7" x2="21" y2="7" />
                        <line x1="3" y1="12" x2="21" y2="12" />
                        <line x1="3" y1="17" x2="21" y2="17" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile navigation panel -->
        <div id="mobileNav" hidden class="overflow-hidden border-t border-hairline bg-white">
            <nav aria-label="মোবাইল নেভিগেশন">
                <ul class="shell flex flex-col pb-5 pt-2">
                    @foreach ($navItems as $item)
                        <li><a href="{{ $item['href'] ?? '#' }}" class="{{ $mobileNavLink }}">{{ $item['label'] }}</a></li>
                    @endforeach
                </ul>
            </nav>
        </div>
    </header>

    <main id="main">
        @yield('content')
    </main>

    <!-- ============ FOOTER ============ -->
    <footer class="bg-footer text-footer-mut">
        <div class="shell grid grid-cols-[1.4fr_1fr_auto] items-start gap-[clamp(28px,5vw,60px)] pb-10 pt-[clamp(48px,6vw,72px)] max-[861px]:grid-cols-2 max-[620px]:grid-cols-1 max-[620px]:gap-[30px]">
            <div class="max-[861px]:col-span-full">
                <a href="{{ route('home.index') }}" aria-label="উসুলি — প্রচ্ছদ" class="inline-flex items-center gap-3">
                    @if ($siteLogo)
                        <img src="{{ $siteLogo }}" alt="{{ GetSetting('site_name') ?? 'উসুলি' }}" class="h-[45px] w-auto shrink-0 object-contain">
                    @else
                        <svg class="h-[45px] w-[30px] shrink-0 overflow-visible" viewBox="0 0 60 90" aria-hidden="true" focusable="false">
                            <path class="[stroke-dasharray:240] [stroke-dashoffset:240] animate-draw motion-reduce:animate-none motion-reduce:[stroke-dashoffset:0]" d="{{ $brandMarkPath }}" fill="none" stroke="#4fb6cf" stroke-width="6.5"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <path class="opacity-0 animate-fade-in-late motion-reduce:animate-none motion-reduce:opacity-100" d="{{ $brandAccentPath }}" fill="none" stroke="#4fb6cf" stroke-width="4" stroke-linecap="round" />
                        </svg>
                    @endif
                    <span class="font-serif text-[1.7rem] font-semibold leading-none tracking-[-0.01em] text-footer-ink max-[620px]:text-[1.55rem]">উসুলি</span>
                </a>
                <p class="mt-[18px] max-w-[34ch] font-serif text-[1.02rem] leading-[1.8] text-footer-mut">{{ GetSetting('footer_slogan') ?: 'উসুলি - নুসুস• ফাহমুস-সালাফ।' }}</p>
            </div>

            <nav class="flex flex-col gap-3.5 pt-1.5" aria-label="ফুটার নেভিগেশন">
                @php
                    $footerMenu = json_decode(GetSetting('footer_menu_items') ?? '[]', true);
                @endphp
                @forelse ($footerMenu as $footerItem)
                    <a href="{{ $footerItem['url'] ?? '#' }}" class="w-fit text-[0.98rem] transition-colors duration-300 hover:text-[#4fb6cf]">{{ $footerItem['label'] ?? '' }}</a>
                @empty
                    <a href="{{ route('home.index') }}" class="w-fit text-[0.98rem] transition-colors duration-300 hover:text-[#4fb6cf]">প্রচ্ছদ</a>
                    <a href="{{ route('blog') }}" class="w-fit text-[0.98rem] transition-colors duration-300 hover:text-[#4fb6cf]">গল্প</a>
                    <a href="{{ route('about') }}" class="w-fit text-[0.98rem] transition-colors duration-300 hover:text-[#4fb6cf]">আমাদের সম্পর্কে</a>
                    <a href="{{ route('contact') }}" class="w-fit text-[0.98rem] transition-colors duration-300 hover:text-[#4fb6cf]">যোগাযোগ</a>
                @endforelse
            </nav>

            <div class="flex gap-3 pt-1.5" aria-label="সামাজিক মাধ্যম">
                @if (!empty(GetSetting('social_facebook')))
                    <a href="{{ GetSetting('social_facebook') }}" target="_blank" rel="noopener" aria-label="ফেসবুক"
                        class="grid h-10 w-10 place-items-center rounded-full border border-white/15 text-footer-mut transition-colors duration-300 hover:border-[#4fb6cf] hover:bg-[#4fb6cf]/12 hover:text-white">
                        <svg class="h-[19px] w-[19px]" viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round">
                            <path d="M14 9V7c0-1 .3-1.5 1.6-1.5H17V2.5h-2.4C11.9 2.5 11 4 11 6.3V9H8.5v3H11v9.5h3V12h2.2l.4-3H14z" />
                        </svg>
                    </a>
                @endif
                @if (!empty(GetSetting('social_twitter')))
                    <a href="{{ GetSetting('social_twitter') }}" target="_blank" rel="noopener" aria-label="এক্স"
                        class="grid h-10 w-10 place-items-center rounded-full border border-white/15 text-footer-mut transition-colors duration-300 hover:border-[#4fb6cf] hover:bg-[#4fb6cf]/12 hover:text-white">
                        <svg class="h-[19px] w-[19px]" viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round">
                            <path d="M17.5 3h3l-6.6 7.5L21.7 21h-5.9l-4.3-5.6L6.4 21H3.3l7-8L2.6 3h6l3.9 5.1L17.5 3zm-1 16h1.6L7.6 4.6H5.9L16.5 19z" />
                        </svg>
                    </a>
                @endif
                @if (!empty(GetSetting('social_instagram')))
                    <a href="{{ GetSetting('social_instagram') }}" target="_blank" rel="noopener" aria-label="ইনস্টাগ্রাম"
                        class="grid h-10 w-10 place-items-center rounded-full border border-white/15 text-footer-mut transition-colors duration-300 hover:border-[#4fb6cf] hover:bg-[#4fb6cf]/12 hover:text-white">
                        <svg class="h-[19px] w-[19px]" viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round">
                            <rect x="3.5" y="3.5" width="17" height="17" rx="5" />
                            <circle cx="12" cy="12" r="4" />
                            <circle cx="17.2" cy="6.8" r="1.2" fill="currentColor" stroke="none" />
                        </svg>
                    </a>
                @endif
                @if (!empty(GetSetting('social_youtube')))
                    <a href="{{ GetSetting('social_youtube') }}" target="_blank" rel="noopener" aria-label="ইউটিউব"
                        class="grid h-10 w-10 place-items-center rounded-full border border-white/15 text-footer-mut transition-colors duration-300 hover:border-[#4fb6cf] hover:bg-[#4fb6cf]/12 hover:text-white">
                        <svg class="h-[19px] w-[19px]" viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round">
                            <rect x="2.5" y="5.5" width="19" height="13" rx="4" />
                            <path d="M10 9.2l5 2.8-5 2.8V9.2z" fill="currentColor" stroke="none" />
                        </svg>
                    </a>
                @endif
                @if (!empty(GetSetting('social_telegram')))
                    <a href="{{ GetSetting('social_telegram') }}" target="_blank" rel="noopener" aria-label="টেলিগ্রাম"
                        class="grid h-10 w-10 place-items-center rounded-full border border-white/15 text-footer-mut transition-colors duration-300 hover:border-[#4fb6cf] hover:bg-[#4fb6cf]/12 hover:text-white">
                        <svg class="h-[19px] w-[19px]" viewBox="0 0 24 24" aria-hidden="true" fill="currentColor">
                            <path
                                d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.479.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z" />
                        </svg>
                    </a>
                @endif
            </div>
        </div>

        <div class="shell border-t border-white/10 py-6">
            <p class="text-[0.88rem]">{{ GetSetting('footer_copyright') ?: '© ২০২৬ উসুলি। সর্বস্বত্ব সংরক্ষিত।' }}</p>
        </div>
    </footer>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script>
        $(function() {
            /* ---- Mobile menu toggle ---- */
            var $toggle = $('#menuToggle');
            var $panel = $('#mobileNav');

            $toggle.on('click', function() {
                var willOpen = $toggle.attr('aria-expanded') !== 'true';
                $toggle.attr('aria-expanded', String(willOpen));
                $panel.prop('hidden', !willOpen);
            });

            $panel.on('click', 'a', function() {
                $toggle.attr('aria-expanded', 'false');
                $panel.prop('hidden', true);
            });

            $(window).on('resize', function() {
                if ($(window).width() > 1000 && !$panel.prop('hidden')) {
                    $toggle.attr('aria-expanded', 'false');
                    $panel.prop('hidden', true);
                }
            });

            /* ---- Fade photos in over their duotone placeholders ---- */
            $('.ph img').each(function() {
                var $img = $(this);
                var markLoaded = function() {
                    $img.css('opacity', '1');
                };

                if (this.complete && this.naturalWidth > 0) {
                    markLoaded();
                } else {
                    $img.one('load', markLoaded);
                    $img.one('error', function() {
                        $img.remove();
                    });
                }
            });

            /* ---- Reveal on scroll ---- */
            var $revealables = $('.reveal');

            $revealables.each(function(index) {
                $(this).css('transition-delay', Math.min((index % 6) * 70, 350) + 'ms');
            });

            var revealInView = function() {
                var triggerLine = $(window).scrollTop() + $(window).height() * 0.92;

                $revealables.filter(function() {
                    return !$(this).data('revealed');
                }).each(function() {
                    var $el = $(this);

                    if ($el.offset().top < triggerLine) {
                        $el.data('revealed', true).css({
                            opacity: '1',
                            transform: 'none'
                        });
                    }
                });
            };

            revealInView();
            $(window).on('scroll resize', revealInView);

            /* ---- Newsletter demo form (home page) ---- */
            $('#newsletterForm').on('submit', function(event) {
                event.preventDefault();
            });

            /* ---- Blog category filter + load more ---- */
            var $pills = $('.js-filter-pill');
            var $cards = $('.js-article-card');

            if ($pills.length && $cards.length) {
                var currentFilter = 'all';

                var syncLoadMore = function() {
                    $('#loadMoreBtn').prop('hidden', $cards.filter('.js-extra-card[hidden]').length === 0);
                };

                var applyFilter = function(filter) {
                    currentFilter = String(filter);

                    $cards.attr('hidden', function() {
                        return currentFilter === 'all' || String($(this).data('category')) === currentFilter ? null : '';
                    });

                    revealInView();
                    syncLoadMore();
                };

                $pills.on('click', function() {
                    $pills.attr('aria-pressed', 'false');
                    $(this).attr('aria-pressed', 'true');

                    applyFilter($(this).data('filter'));
                });

                $('#loadMoreBtn').on('click', function() {
                    $cards.filter('.js-extra-card').removeAttr('hidden');

                    applyFilter(currentFilter);
                    revealInView();
                });
            }

            /* ---- User dropdown (hover on desktop, click on mobile) ---- */
            var $wrapper = $('#userDropdownWrapper');
            if ($wrapper.length) {
                var $toggle = $('#userDropdownToggle');
                var $menu = $('#userDropdownMenu');
                var $arrow = $('#dropdownArrow');
                var hoverTimer;

                var showMenu = function() {
                    clearTimeout(hoverTimer);
                    $menu.removeClass('hidden').addClass('min-[1001px]:opacity-100 min-[1001px]:translate-y-0');
                    $arrow.addClass('rotate-180');
                    $toggle.attr('aria-expanded', 'true');
                };

                var hideMenu = function() {
                    hoverTimer = setTimeout(function() {
                        $menu.addClass('hidden').removeClass('min-[1001px]:opacity-100 min-[1001px]:translate-y-0');
                        $arrow.removeClass('rotate-180');
                        $toggle.attr('aria-expanded', 'false');
                    }, 150);
                };

                $wrapper.on('mouseenter', function() {
                    if ($(window).width() >= 1001) {
                        showMenu();
                    }
                });

                $wrapper.on('mouseleave', function() {
                    if ($(window).width() >= 1001) {
                        hideMenu();
                    }
                });

                $toggle.on('click', function(e) {
                    e.stopPropagation();
                    if ($menu.hasClass('hidden')) {
                        showMenu();
                    } else {
                        hideMenu();
                    }
                });

                $(document).on('click', function(e) {
                    if (!$wrapper.is(e.target) && $wrapper.has(e.target).length === 0) {
                        hideMenu();
                    }
                });
            }
        });
    </script>
</body>

</html>
