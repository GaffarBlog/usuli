<footer class="bg-footer text-footer-mut">
    <div class="shell grid grid-cols-[1.4fr_1fr_auto] items-start gap-[clamp(28px,5vw,60px)] pb-10 pt-[clamp(48px,6vw,72px)] max-[861px]:grid-cols-2 max-[620px]:grid-cols-1 max-[620px]:gap-[30px]">
        <div class="max-[861px]:col-span-full">
            <a href="#" aria-label="উসুলি — প্রচ্ছদ" class="inline-flex items-center gap-3">
                <svg class="h-[45px] w-[30px] shrink-0 overflow-visible" viewBox="0 0 60 90" aria-hidden="true" focusable="false">
                    <path class="[stroke-dasharray:240] [stroke-dashoffset:240] animate-draw motion-reduce:animate-none motion-reduce:[stroke-dashoffset:0]" d="M41 9 C 36 24 30 33 31 46 C 32 57 44 60 47 69 C 49 76 42 83 30 82 C 20 81 13 74 12 64"
                        fill="none" stroke="#4fb6cf" stroke-width="6.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path class="opacity-0 animate-fade-in-late motion-reduce:animate-none motion-reduce:opacity-100" d="M40 6 C 42 4 45 4 46 7" fill="none" stroke="#4fb6cf" stroke-width="4" stroke-linecap="round" />
                </svg>
                <span class="font-serif text-[1.7rem] font-semibold leading-none tracking-[-0.01em] text-footer-ink max-[620px]:text-[1.55rem]">উসুলি</span>
            </a>
            <p class="mt-[18px] max-w-[34ch] font-serif text-[1.02rem] leading-[1.8] text-footer-mut">বাংলায় গল্প, ভাবনা ও মানুষের কথা।</p>
        </div>

        <nav class="flex flex-col gap-3.5 pt-1.5" aria-label="ফুটার নেভিগেশন">
            @foreach (['প্রচ্ছদ', 'আমাদের সম্পর্কে', 'যোগাযোগ', 'গোপনীয়তা', 'শর্তাবলি'] as $footerLink)
                <a href="#" class="w-fit text-[0.98rem] transition-colors duration-300 hover:text-[#4fb6cf]">{{ $footerLink }}</a>
            @endforeach
        </nav>

        <div class="flex gap-3 pt-1.5" aria-label="সামাজিক মাধ্যম">
            <a href="#" aria-label="ফেসবুক" class="grid h-10 w-10 place-items-center rounded-full border border-white/15 text-footer-mut transition-colors duration-300 hover:border-[#4fb6cf] hover:bg-[#4fb6cf]/12 hover:text-white">
                <svg class="h-[19px] w-[19px]" viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round">
                    <path d="M14 9V7c0-1 .3-1.5 1.6-1.5H17V2.5h-2.4C11.9 2.5 11 4 11 6.3V9H8.5v3H11v9.5h3V12h2.2l.4-3H14z" />
                </svg>
            </a>
            <a href="#" aria-label="এক্স" class="grid h-10 w-10 place-items-center rounded-full border border-white/15 text-footer-mut transition-colors duration-300 hover:border-[#4fb6cf] hover:bg-[#4fb6cf]/12 hover:text-white">
                <svg class="h-[19px] w-[19px]" viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round">
                    <path d="M17.5 3h3l-6.6 7.5L21.7 21h-5.9l-4.3-5.6L6.4 21H3.3l7-8L2.6 3h6l3.9 5.1L17.5 3zm-1 16h1.6L7.6 4.6H5.9L16.5 19z" />
                </svg>
            </a>
            <a href="#" aria-label="ইনস্টাগ্রাম" class="grid h-10 w-10 place-items-center rounded-full border border-white/15 text-footer-mut transition-colors duration-300 hover:border-[#4fb6cf] hover:bg-[#4fb6cf]/12 hover:text-white">
                <svg class="h-[19px] w-[19px]" viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round">
                    <rect x="3.5" y="3.5" width="17" height="17" rx="5" />
                    <circle cx="12" cy="12" r="4" />
                    <circle cx="17.2" cy="6.8" r="1.2" fill="currentColor" stroke="none" />
                </svg>
            </a>
            <a href="#" aria-label="ইউটিউব" class="grid h-10 w-10 place-items-center rounded-full border border-white/15 text-footer-mut transition-colors duration-300 hover:border-[#4fb6cf] hover:bg-[#4fb6cf]/12 hover:text-white">
                <svg class="h-[19px] w-[19px]" viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round">
                    <rect x="2.5" y="5.5" width="19" height="13" rx="4" />
                    <path d="M10 9.2l5 2.8-5 2.8V9.2z" fill="currentColor" stroke="none" />
                </svg>
            </a>
        </div>
    </div>

    <div class="shell border-t border-white/10 py-6">
        <p class="text-[0.88rem]">© ২০২৬ উসুলি। সর্বস্বত্ব সংরক্ষিত।</p>
    </div>
</footer>
