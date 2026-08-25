<header class="sticky top-0 z-100 border-b border-hairline bg-[rgba(250,250,248,0.82)] backdrop-blur-md backdrop-saturate-[140%]">
    <div class="shell flex h-[76px] items-center justify-between gap-6">
        <a href="#" aria-label="উসুলি — প্রচ্ছদ" class="inline-flex items-center gap-3">
            <svg class="h-[45px] w-[30px] shrink-0 overflow-visible" viewBox="0 0 60 90" aria-hidden="true" focusable="false">
                <path class="[stroke-dasharray:240] [stroke-dashoffset:240] animate-draw motion-reduce:animate-none motion-reduce:[stroke-dashoffset:0]" d="M41 9 C 36 24 30 33 31 46 C 32 57 44 60 47 69 C 49 76 42 83 30 82 C 20 81 13 74 12 64"
                    fill="none" stroke="#2b8ca4" stroke-width="6.5" stroke-linecap="round" stroke-linejoin="round" />
                <path class="opacity-0 animate-fade-in-late motion-reduce:animate-none motion-reduce:opacity-100" d="M40 6 C 42 4 45 4 46 7" fill="none" stroke="#2b8ca4" stroke-width="4" stroke-linecap="round" />
            </svg>
            <span class="font-serif text-[1.7rem] font-semibold leading-none tracking-[-0.01em] text-ink max-[620px]:text-[1.55rem]">উসুলি</span>
        </a>

        <nav class="mx-auto hidden min-[1001px]:block" aria-label="প্রধান নেভিগেশন">
            <ul class="flex gap-[30px]">
                @foreach ($navItems as $item)
                    <li>
                        <a href="#" class="{{ $item['active'] ?? false ? 'nav-link-active' : 'nav-link' }}">{{ $item['label'] }}</a>
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
            <ul class="flex flex-col pb-5 pt-2 shell">
                @foreach ($navItems as $item)
                    <li><a href="#" class="mobile-nav-link">{{ $item['label'] }}</a></li>
                @endforeach
            </ul>
        </nav>
    </div>
</header>
