@extends('layouts.site')

@section('title', 'আমাদের সম্পর্কে — উসুলি')

@section('content')
    <!-- ============ ABOUT HERO ============ -->
    <section class="pb-[clamp(32px,5vw,60px)] pt-[clamp(40px,6vw,72px)]" aria-labelledby="aboutTitle">
        <div class="shell">
            <div class="mx-auto max-w-2xl text-center">
                <span class="mb-5 inline-flex items-center gap-2.5 text-[0.78rem] font-semibold tracking-[0.14em] text-brand-deep">
                    <span class="inline-block h-0.5 w-[22px] bg-brand" aria-hidden="true"></span>আমাদের সম্পর্কে
                </span>
                <h1 class="mb-5 font-serif text-[clamp(2rem,4vw,3.2rem)] font-semibold leading-[1.3] tracking-[-0.005em] text-ink" id="aboutTitle">
                    উসুলি কী?
                </h1>
                <p class="text-[1.1rem] leading-[1.85] text-body">
                    উসুলি হলো বাংলা সাহিত্যের একটি অনলাইন জার্নাল, যেখানে গল্প, ভাবনা ও মানুষের কথা একত্রিত হয়।
                </p>
            </div>
        </div>
    </section>

    <!-- ============ MISSION ============ -->
    <section class="pb-[clamp(48px,6vw,86px)]" aria-labelledby="missionTitle">
        <div class="shell">
            <div class="mx-auto max-w-3xl">
                <div class="reveal rounded-2xl border border-hairline bg-white p-[clamp(24px,4vw,48px)] shadow-sm">
                    <h2 class="mb-6 font-serif text-[clamp(1.3rem,2.4vw,1.75rem)] font-semibold tracking-[-0.005em] text-ink" id="missionTitle">
                        আমাদের লক্ষ্য
                    </h2>
                    <div class="space-y-4 text-[1.05rem] leading-[1.9] text-body">
                        <p>
                            উসুলির জন্ম হয়েছে বাংলা সাহিত্যকে সমৃদ্ধ করার একটি সাধারণ কামনা থেকে। আমরা বিশ্বাস করি, বাংলা ভাষায় লেখালেখির একটি সমৃদ্ধ ঐতিহ্য রয়েছে, এবং ডিজিটাল যুগে সেই ঐতিহ্যকে নতুন মানুষের কাছে পৌঁছে দেওয়া আমাদের দায়িত্ব।
                        </p>
                        <p>
                            আমরা চাই যেন নতুন ও পুরনো লেখক, পাঠক ও সাহিত্যঅনুরাগীরা একটি জায়গায় একত্রিত হতে পারেন। গল্প পড়তে, লিখতে, এবং সাহিত্য নিয়ে কথা বলতে পারেন।
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ VALUES ============ -->
    <section class="pb-[clamp(48px,6vw,86px)]" aria-labelledby="valuesTitle">
        <div class="shell">
            <div class="mx-auto max-w-4xl text-center">
                <h2 class="mb-10 font-serif text-[clamp(1.3rem,2.4vw,1.75rem)] font-semibold tracking-[-0.005em] text-ink" id="valuesTitle">
                    আমাদের মূল্যবোধ
                </h2>
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <div class="reveal flex flex-col items-center gap-4 rounded-xl border border-hairline bg-white px-6 py-8 text-center transition-shadow duration-300 hover:shadow-md">
                        <div class="grid h-14 w-14 place-items-center rounded-full bg-brand-soft">
                            <svg class="h-6 w-6 text-brand" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <h3 class="text-sm font-semibold text-ink">সাহিত্যচর্চা</h3>
                        <p class="text-[0.95rem] leading-relaxed text-body">
                            গল্প, কবিতা, প্রবন্ধ ও বিভিন্ন ধরনের সাহিত্যকর্মকে একটি একক মঞ্চে এনে তোলা।
                        </p>
                    </div>

                    <div class="reveal flex flex-col items-center gap-4 rounded-xl border border-hairline bg-white px-6 py-8 text-center transition-shadow duration-300 hover:shadow-md">
                        <div class="grid h-14 w-14 place-items-center rounded-full bg-brand-soft">
                            <svg class="h-6 w-6 text-brand" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                <circle cx="9" cy="7" r="4" />
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                            </svg>
                        </div>
                        <h3 class="text-sm font-semibold text-ink">সম্প্রদায়</h3>
                        <p class="text-[0.95rem] leading-relaxed text-body">
                            পাঠক ও লেখকদের মধ্যে সংলাপ ও সম্পর্ক গড়ে তোলা।
                        </p>
                    </div>

                    <div class="reveal flex flex-col items-center gap-4 rounded-xl border border-hairline bg-white px-6 py-8 text-center transition-shadow duration-300 hover:shadow-md">
                        <div class="grid h-14 w-14 place-items-center rounded-full bg-brand-soft">
                            <svg class="h-6 w-6 text-brand" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="2" y1="12" x2="22" y2="12" />
                                <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" />
                            </svg>
                        </div>
                        <h3 class="text-sm font-semibold text-ink">সর্বজনীনতা</h3>
                        <p class="text-[0.95rem] leading-relaxed text-body">
                            সকলের জন্য উন্মুক্ত, যে কেউ পড়তে ও লিখতে পারবেন।
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ TEAM / STORY ============ -->
    <section class="pb-[clamp(48px,6vw,86px)]" aria-labelledby="storyTitle">
        <div class="shell">
            <div class="mx-auto max-w-3xl">
                <div class="reveal rounded-2xl border border-hairline bg-white p-[clamp(24px,4vw,48px)] shadow-sm">
                    <h2 class="mb-6 font-serif text-[clamp(1.3rem,2.4vw,1.75rem)] font-semibold tracking-[-0.005em] text-ink" id="storyTitle">
                        আমাদের গল্প
                    </h2>
                    <div class="space-y-4 text-[1.05rem] leading-[1.9] text-body">
                        <p>
                            উসুলি শুরু হয়েছিল একটি ছোট প্রকল্প হিসেবে। কয়েকজন লেখক ও সাহিত্যানুরাগী মিলে একটি এমন প্ল্যাটফর্ম তৈরি করার স্বপ্ন দেখেছিলেন, যেখানে বাংলা সাহিত্য নতুন উচ্চতায় পৌঁছাতে পারে।
                        </p>
                        <p>
                            আজ উসুলি একটি ক্রমবর্ধমান সাহিত্যিক সম্প্রদায়ে রূপান্তরিত হয়েছে। এখানে অভিজ্ঞ লেখকদের পাশাপাশি নতুন লেখকরাও তাদের সৃষ্টি পাঠকের কাছে পৌঁছে দিতে পারেন।
                        </p>
                        <p>
                            আমাদের বিশ্বাস — ভালো সাহিত্য সীমানা ভেঙে যায়, এবং উসুলি সেই সীমানা ভাঙতে সাহায্য করতে চায়।
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ CTA ============ -->
    <section class="pb-[clamp(48px,6vw,86px)]" aria-label="যোগাযোগের আহ্বান">
        <div class="shell">
            <div class="mx-auto max-w-2xl text-center">
                <div class="reveal rounded-2xl border border-hairline bg-brand-soft/30 px-[clamp(24px,4vw,48px)] py-[clamp(32px,4vw,56px)]">
                    <h2 class="mb-4 font-serif text-[clamp(1.3rem,2.4vw,1.75rem)] font-semibold tracking-[-0.005em] text-ink">
                        সাহিত্য কি আপনার প্রাণ?
                    </h2>
                    <p class="mb-8 text-[1.05rem] leading-[1.85] text-body">
                        আমাদের সঙ্গে যুক্ত হতে চাইলে এখনই নিবন্ধন করুন অথবা যোগাযোগ করুন।
                    </p>
                    <div class="flex flex-wrap justify-center gap-4">
                        <a href="{{ route('frontend.register') }}"
                            class="rounded-lg bg-brand px-6 py-3 text-sm font-medium text-white transition-colors hover:bg-brand-deep">
                            নিবন্ধন করুন
                        </a>
                        <a href="{{ route('contact') }}"
                            class="rounded-lg border border-hairline bg-white px-6 py-3 text-sm font-medium text-ink transition-colors hover:bg-gray-50">
                            যোগাযোগ করুন
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
