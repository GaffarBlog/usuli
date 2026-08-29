<!DOCTYPE html>
<html lang="bn" dir="ltr" class="scroll-smooth motion-reduce:scroll-auto">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'ড্যাশবোর্ড — উসুলি অ্যাডমিন')</title>
    <meta name="description" content="@yield('description', 'উসুলি অ্যাডমিন প্যানেল।')">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;500;600;700&family=Noto+Serif+Bengali:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">

    @vite(['resources/css/app.css'])
</head>
<body class="bg-page font-sans text-[17px] leading-[1.75] text-body antialiased max-[620px]:text-base">
    @php
        $brandMarkPath = 'M41 9 C 36 24 30 33 31 46 C 32 57 44 60 47 69 C 49 76 42 83 30 82 C 20 81 13 74 12 64';
        $brandAccentPath = 'M40 6 C 42 4 45 4 46 7';
        $menuItem = 'flex items-center gap-3 rounded-lg px-3.5 py-2.5 text-[0.95rem] font-medium text-footer-mut transition-colors duration-200 hover:bg-white/[0.06] hover:text-white';
        $menuItemActive = 'flex items-center gap-3 rounded-lg bg-brand/15 px-3.5 py-2.5 text-[0.95rem] font-semibold text-white transition-colors duration-200';
        $iconBtn = 'grid h-10 w-10 place-items-center rounded-full text-ink transition-colors duration-300 hover:bg-brand-soft hover:text-brand-deep';
        $navIcon = 'h-[18px] w-[18px] shrink-0';
        $currentRoute = request()->route()->getName();
    @endphp

    <!-- ============ SIDEBAR ============ -->
    <aside id="adminSidebar" data-state="closed"
           class="fixed inset-y-0 left-0 z-[300] flex w-[264px] -translate-x-full flex-col overflow-y-auto border-r border-white/[0.06] bg-footer transition-transform duration-300 ease-[cubic-bezier(0.22,0.61,0.36,1)] will-change-transform data-[state=open]:translate-x-0 lg:translate-x-0">
        <div class="flex items-center justify-between gap-3 px-5 pb-4 pt-6">
            <a href="{{ route('home') }}" aria-label="উসুলি — প্রচ্ছদ" class="inline-flex items-center gap-3">
                <svg class="h-[42px] w-[28px] shrink-0 overflow-visible" viewBox="0 0 60 90" aria-hidden="true" focusable="false">
                    <path class="[stroke-dasharray:240] [stroke-dashoffset:240] animate-draw motion-reduce:animate-none motion-reduce:[stroke-dashoffset:0]"
                          d="{{ $brandMarkPath }}"
                          fill="none" stroke="#4fb6cf" stroke-width="6.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path class="opacity-0 animate-fade-in-late motion-reduce:animate-none motion-reduce:opacity-100"
                          d="{{ $brandAccentPath }}"
                          fill="none" stroke="#4fb6cf" stroke-width="4" stroke-linecap="round"/>
                </svg>
                <span class="font-serif text-[1.45rem] font-semibold leading-none tracking-[-0.01em] text-footer-ink">উসুলি</span>
            </a>
            <button type="button" id="adminSidebarClose" aria-label="মেনু বন্ধ করুন"
                    class="{{ $iconBtn }} !text-footer-mut hover:!bg-white/[0.06] hover:!text-white lg:hidden">
                <svg class="{{ $navIcon }}" viewBox="0 0 24 24" aria-hidden="true" focusable="false"
                     fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round">
                    <path d="M6 6l12 12"/><path d="M18 6 6 18"/>
                </svg>
            </button>
        </div>

        <nav class="flex flex-col gap-1 px-3" aria-label="অ্যাডমিন মেনু">
            <p class="px-3.5 pb-2 pt-3 text-[0.72rem] font-semibold tracking-[0.14em] text-footer-mut">মেনু</p>

            <a href="{{ route('admin.dashboard') }}" aria-current="{{ $currentRoute === 'admin.dashboard' ? 'page' : 'false' }}" class="{{ $currentRoute === 'admin.dashboard' ? $menuItemActive : $menuItem }}">
                <svg class="{{ $navIcon }} {{ $currentRoute === 'admin.dashboard' ? 'text-[#4fb6cf]' : '' }}" viewBox="0 0 24 24" aria-hidden="true" focusable="false"
                     fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3.5" y="3.5" width="7" height="7" rx="1.5"/><rect x="13.5" y="3.5" width="7" height="7" rx="1.5"/>
                    <rect x="3.5" y="13.5" width="7" height="7" rx="1.5"/><rect x="13.5" y="13.5" width="7" height="7" rx="1.5"/>
                </svg>
                ড্যাশবোর্ড
            </a>

            <a href="#" class="{{ $menuItem }}">
                <svg class="{{ $navIcon }}" viewBox="0 0 24 24" aria-hidden="true" focusable="false"
                     fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5"/>
                    <path d="M12 12v6"/><path d="M9 15h6"/>
                </svg>
                নতুন লেখা
            </a>

            <a href="#" class="{{ $menuItem }}">
                <svg class="{{ $navIcon }}" viewBox="0 0 24 24" aria-hidden="true" focusable="false"
                     fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M8 6h13"/><path d="M8 12h13"/><path d="M8 18h13"/>
                    <path d="M3.7 6h.01"/><path d="M3.7 12h.01"/><path d="M3.7 18h.01"/>
                </svg>
                সব লেখা
            </a>

            <a href="{{ route('admin.categories.index') }}" class="{{ str_starts_with($currentRoute, 'admin.categories') ? $menuItemActive : $menuItem }}">
                <svg class="{{ $navIcon }} {{ str_starts_with($currentRoute, 'admin.categories') ? 'text-[#4fb6cf]' : '' }}" viewBox="0 0 24 24" aria-hidden="true" focusable="false"
                     fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20.6 13.4 13.4 20.6a2 2 0 0 1-2.8 0L3 13V3h10l7.6 7.6a2 2 0 0 1 0 2.8z"/>
                    <circle cx="7.5" cy="7.5" r="1.2"/>
                </svg>
                বিষয়সমূহ
            </a>

            <a href="#" class="{{ $menuItem }}">
                <svg class="{{ $navIcon }}" viewBox="0 0 24 24" aria-hidden="true" focusable="false"
                     fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 12a8 8 0 0 1-8 8H4l2.2-2.6A8 8 0 1 1 21 12z"/>
                </svg>
                মন্তব্য
                <span class="ml-auto rounded-full bg-brand/25 px-2 py-0.5 text-[0.7rem] font-semibold text-[#9fdcec]">১২</span>
            </a>

            <a href="#" class="{{ $menuItem }}">
                <svg class="{{ $navIcon }}" viewBox="0 0 24 24" aria-hidden="true" focusable="false"
                     fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3.5" y="4.5" width="17" height="15" rx="2"/><circle cx="9" cy="10" r="1.6"/>
                    <path d="m4.5 18 4.8-4.8 3.4 3.4 2.8-2.8 4 4"/>
                </svg>
                গণমাধ্যম
            </a>

            <a href="#" class="{{ $menuItem }}">
                <svg class="{{ $navIcon }}" viewBox="0 0 24 24" aria-hidden="true" focusable="false"
                     fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="9" cy="8" r="3.2"/><path d="M3.5 19.5c.6-3 2.9-4.5 5.5-4.5s4.9 1.5 5.5 4.5"/>
                    <path d="M16 5.6a3.2 3.2 0 0 1 0 4.9"/><path d="M17.8 15.4c1.6.7 2.6 2 3 4.1"/>
                </svg>
                সদস্য
            </a>
        </nav>

        <nav class="mt-auto flex flex-col gap-1 border-t border-white/10 px-3 py-4" aria-label="অ্যাকাউন্ট মেনু">
            <a href="#" class="{{ $menuItem }}">
                <svg class="{{ $navIcon }}" viewBox="0 0 24 24" aria-hidden="true" focusable="false"
                     fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 8h10"/><circle cx="17" cy="8" r="2.5"/>
                    <path d="M20 16H10"/><circle cx="7" cy="16" r="2.5"/>
                </svg>
                সেটিংস
            </a>
            <a href="#" class="{{ $menuItem }}">
                <svg class="{{ $navIcon }}" viewBox="0 0 24 24" aria-hidden="true" focusable="false"
                     fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="8.5"/><path d="M9.6 9.3a2.5 2.5 0 1 1 3.4 2.9c-.7.3-1 .8-1 1.6"/><path d="M12 16.8h.01"/>
                </svg>
                সাহায্য
            </a>
            <a href="#" class="{{ $menuItem }}">
                <svg class="{{ $navIcon }}" viewBox="0 0 24 24" aria-hidden="true" focusable="false"
                     fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 4H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h7"/><path d="m17 8 4 4-4 4"/><path d="M10 12h11"/>
                </svg>
                প্রস্থান
            </a>
        </nav>
    </aside>

    <!-- Mobile backdrop -->
    <div id="adminBackdrop" hidden class="fixed inset-0 z-[290] bg-[rgba(12,26,30,0.55)] backdrop-blur-[2px] lg:hidden" aria-hidden="true"></div>

    <div class="flex min-h-screen flex-col lg:pl-[264px]">
        <!-- ============ TOPBAR ============ -->
        <header class="sticky top-0 z-100 h-[68px] border-b border-hairline bg-[rgba(250,250,248,0.85)] backdrop-blur-md backdrop-saturate-[140%]">
            <div class="flex h-full items-center justify-between gap-4 px-[clamp(16px,3vw,32px)]">
                <div class="flex items-center gap-2">
                    <button type="button" id="adminMenuToggle" aria-label="মেনু" aria-expanded="false" aria-controls="adminSidebar"
                            class="{{ $iconBtn }} min-[1024px]:hidden">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" aria-hidden="true" focusable="false"
                             fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round">
                            <line x1="3" y1="7" x2="21" y2="7"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="17" x2="21" y2="17"/>
                        </svg>
                    </button>
                    <div class="leading-tight">
                        <p class="text-[0.72rem] font-semibold tracking-[0.14em] text-faint">উসুলি অ্যাডমিন</p>
                        <h1 class="font-serif text-xl font-semibold tracking-[-0.005em] text-ink">{{ $pageTitle ?? 'ড্যাশবোর্ড' }}</h1>
                    </div>
                </div>

                <div class="flex items-center gap-1.5">
                    <button type="button" aria-label="খুঁজুন" class="{{ $iconBtn }}">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" aria-hidden="true" focusable="false"
                             fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round">
                            <circle cx="11" cy="11" r="7"/><line x1="16.5" y1="16.5" x2="21" y2="21"/>
                        </svg>
                    </button>
                    <button type="button" aria-label="বিজ্ঞপ্তি" class="{{ $iconBtn }} relative">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" aria-hidden="true" focusable="false"
                             fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 9a6 6 0 1 0-12 0c0 6-2.5 7-2.5 7h17S18 15 18 9z"/><path d="M10.3 20a2 2 0 0 0 3.4 0"/>
                        </svg>
                        <span class="absolute right-2 top-2 h-2 w-2 rounded-full bg-brand" aria-hidden="true"></span>
                    </button>
                    <span class="mx-1 hidden h-6 w-px bg-hairline min-[480px]:block" aria-hidden="true"></span>
                    <button type="button" class="flex items-center gap-2.5 rounded-full p-0.5 pr-3 transition-colors duration-300 hover:bg-brand-soft max-[479px]:pr-0.5" aria-label="প্রোফাইল">
                        <span class="grid h-9 w-9 place-items-center rounded-full bg-linear-160 from-brand to-brand-deep font-serif text-lg font-semibold text-white">উ</span>
                        <span class="hidden text-sm font-medium leading-tight text-body min-[480px]:block">
                            উসুলি অ্যাডমিন<br>
                            <span class="text-[0.72rem] font-normal text-faint">সম্পাদক</span>
                        </span>
                    </button>
                </div>
            </div>
        </header>

        <!-- ============ MAIN ============ -->
        <main class="flex-1 px-[clamp(16px,3vw,32px)] py-[clamp(24px,4vw,40px)]">
            @yield('content')
        </main>

        <!-- ============ FOOTER ============ -->
        <footer class="border-t border-hairline px-[clamp(16px,3vw,32px)] py-5">
            <div class="flex flex-wrap items-center justify-between gap-3 text-[0.85rem] text-faint">
                <p>© ২০২৬ উসুলি। সর্বস্বত্ব সংরক্ষিত।</p>
                <p>ভার্সন ১.০</p>
            </div>
        </footer>
    </div>

    <script src="https://code.jquery.com/jquery-4.0.0.min.js"
            integrity="sha256-OaVG6prZf4v69dPg6PhVattBXkcOWQB62pdZ3ORyrao=" crossorigin="anonymous"></script>
    <script>
        $(function () {
            /* ---- Sidebar toggle (off-canvas below 1024px) ---- */
            var $sidebar = $('#adminSidebar');
            var $backdrop = $('#adminBackdrop');
            var $toggle = $('#adminMenuToggle');

            var setSidebar = function (open) {
                $toggle.attr('aria-expanded', String(open));
                $sidebar.attr('data-state', open ? 'open' : 'closed');
                $backdrop.prop('hidden', !open);
            };

            var isOpen = function () {
                return $toggle.attr('aria-expanded') === 'true';
            };

            $toggle.on('click', function () {
                setSidebar(!isOpen());
            });

            $backdrop.on('click', function () {
                setSidebar(false);
            });

            $('#adminSidebarClose').on('click', function () {
                setSidebar(false);
            });

            $(document).on('keydown', function (event) {
                if (event.key === 'Escape' && isOpen()) {
                    setSidebar(false);
                }
            });

            $(window).on('resize', function () {
                if ($(window).width() >= 1024) {
                    setSidebar(false);
                }
            });

            /* ---- Reveal on scroll ---- */
            var $revealables = $('.reveal');

            $revealables.each(function (index) {
                $(this).css('transition-delay', Math.min((index % 6) * 70, 350) + 'ms');
            });

            var revealInView = function () {
                var triggerLine = $(window).scrollTop() + $(window).height() * 0.92;

                $revealables.filter(function () {
                    return !$(this).data('revealed');
                }).each(function () {
                    var $el = $(this);

                    if ($el.offset().top < triggerLine) {
                        $el.data('revealed', true).css({ opacity: '1', transform: 'none' });
                    }
                });
            };

            revealInView();
            $(window).on('scroll resize', revealInView);
        });
    </script>
</body>
</html>
