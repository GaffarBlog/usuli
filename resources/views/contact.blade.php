@extends('layouts.main')

@section('title', 'যোগাযোগ — উসুলি')

@section('content')
    @php
        $phone = GetSetting('phone');
        $email = GetSetting('email');
        $address = GetSetting('address');
        $socials = GetSettingsGroup('social_');
        $frontendUser = Auth::guard('frontend')->user();
    @endphp

    <!-- ============ CONTACT HERO ============ -->
    <section class="pb-[clamp(32px,5vw,60px)] pt-[clamp(40px,6vw,72px)]" aria-labelledby="contactTitle">
        <div class="shell">
            <div class="mx-auto max-w-2xl text-center">
                <span class="mb-5 inline-flex items-center gap-2.5 text-[0.78rem] font-semibold tracking-[0.14em] text-brand-deep">
                    <span class="inline-block h-0.5 w-[22px] bg-brand" aria-hidden="true"></span>যোগাযোগ
                </span>
                <h1 class="mb-5 font-serif text-[clamp(2rem,4vw,3.2rem)] font-semibold leading-[1.3] tracking-[-0.005em] text-ink" id="contactTitle">
                    আমাদের সঙ্গে যোগাযোগ করুন
                </h1>
                <p class="text-[1.1rem] leading-[1.85] text-body">
                    কোনো প্রশ্ন, মতামত অথবা সহযোগিতার প্রস্তাব থাকলে নিচের ফর্মটি পূরণ করুন।
                </p>
            </div>
        </div>
    </section>

    <!-- ============ CONTACT FORM ============ -->
    <section class="pb-[clamp(48px,6vw,86px)]" aria-labelledby="formTitle">
        <div class="shell">
            <div class="mx-auto max-w-2xl">
                {{-- Flash Message --}}
                @if (session('success'))
                    <div id="flash-message" class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="rounded-2xl border border-hairline bg-white p-[clamp(24px,4vw,48px)] shadow-sm">
                    <h2 class="mb-6 font-serif text-[clamp(1.2rem,2vw,1.5rem)] font-semibold text-ink" id="formTitle">
                        বার্তা পাঠান
                    </h2>

                    <form method="POST" action="{{ route('contact.store') }}" class="space-y-5">
                        @csrf

                        {{-- Name --}}
                        <div>
                            <label for="name" class="mb-1.5 block text-sm font-medium text-ink">নাম <span class="text-red-500">*</span></label>
                            <input type="text" id="name" name="name" required maxlength="255" value="{{ old('name', $frontendUser?->name ?? '') }}" placeholder="আপনার নাম লিখুন"
                                class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-3 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20">
                            @error('name')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Subject --}}
                        <div>
                            <label for="subject" class="mb-1.5 block text-sm font-medium text-ink">বিষয় <span class="text-red-500">*</span></label>
                            <input type="text" id="subject" name="subject" required maxlength="255" value="{{ old('subject') }}" placeholder="বার্তার বিষয় লিখুন"
                                class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-3 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20">
                            @error('subject')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email + Phone (two columns) --}}
                        <div class="grid gap-5 min-[501px]:grid-cols-2">
                            <div>
                                <label for="email" class="mb-1.5 block text-sm font-medium text-ink">ইমেইল <span class="text-faint">(ঐচ্ছিক)</span></label>
                                <input type="email" id="email" name="email" maxlength="255" value="{{ old('email', $frontendUser?->email ?? '') }}" placeholder="example@email.com"
                                    class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-3 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20">
                                @error('email')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="phone" class="mb-1.5 block text-sm font-medium text-ink">ফোন <span class="text-faint">(ঐচ্ছিক)</span></label>
                                <input type="text" id="phone" name="phone" maxlength="20" value="{{ old('phone', $frontendUser?->phone ?? '') }}" placeholder="01XXXXXXXXX"
                                    class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-3 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20">
                                @error('phone')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Message --}}
                        <div>
                            <label for="body" class="mb-1.5 block text-sm font-medium text-ink">বার্তা <span class="text-red-500">*</span></label>
                            <textarea id="body" name="body" rows="5" required maxlength="5000" placeholder="আপনার বার্তা লিখুন..."
                                class="w-full resize-none rounded-lg border border-hairline bg-gray-50/50 px-4 py-3 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20">{{ old('body') }}</textarea>
                            @error('body')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Submit --}}
                        <div class="flex justify-end">
                            <button type="submit" class="rounded-lg bg-brand px-6 py-3 text-sm font-medium text-white transition-colors hover:bg-brand-deep">
                                বার্তা পাঠান
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ CONTACT INFO ============ -->
    <section class="pb-[clamp(48px,6vw,86px)]" aria-label="যোগাযোগের তথ্য">
        <div class="shell">
            <div class="mx-auto grid max-w-4xl gap-6 sm:grid-cols-2 lg:grid-cols-3">
                {{-- Phone --}}
                @if ($phone)
                    <div class="reveal flex flex-col items-center gap-4 rounded-xl border border-hairline bg-white px-6 py-8 text-center transition-shadow duration-300 hover:shadow-md">
                        <div class="grid h-14 w-14 place-items-center rounded-full bg-brand-soft">
                            <svg class="h-6 w-6 text-brand" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="mb-1 text-sm font-semibold text-ink">ফোন</h3>
                            <a href="tel:{{ $phone }}" class="text-[1.05rem] font-medium text-brand-deep transition-colors hover:text-brand">{{ $phone }}</a>
                        </div>
                    </div>
                @endif

                {{-- Email --}}
                @if ($email)
                    <div class="reveal flex flex-col items-center gap-4 rounded-xl border border-hairline bg-white px-6 py-8 text-center transition-shadow duration-300 hover:shadow-md">
                        <div class="grid h-14 w-14 place-items-center rounded-full bg-brand-soft">
                            <svg class="h-6 w-6 text-brand" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="4" width="20" height="16" rx="2" />
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="mb-1 text-sm font-semibold text-ink">ইমেইল</h3>
                            <a href="mailto:{{ $email }}" class="text-[1.05rem] font-medium text-brand-deep transition-colors hover:text-brand">{{ $email }}</a>
                        </div>
                    </div>
                @endif

                {{-- Address --}}
                @if ($address)
                    <div class="reveal flex flex-col items-center gap-4 rounded-xl border border-hairline bg-white px-6 py-8 text-center transition-shadow duration-300 hover:shadow-md sm:col-span-2 lg:col-span-1">
                        <div class="grid h-14 w-14 place-items-center rounded-full bg-brand-soft">
                            <svg class="h-6 w-6 text-brand" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z" />
                                <circle cx="12" cy="10" r="3" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="mb-1 text-sm font-semibold text-ink">ঠিকানা</h3>
                            <p class="text-[1.05rem] leading-relaxed text-body">{{ $address }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- Show social section only if any social link exists --}}
    @if (in_array(true, array_map('strlen', $socials)))
        <!-- ============ SOCIAL ============ -->
        <section class="pb-[clamp(48px,6vw,86px)]" aria-label="সামাজিক মাধ্যম">
            <div class="shell">
                <div class="mx-auto max-w-4xl text-center">
                    <h2 class="mb-6 font-serif text-[clamp(1.3rem,2.4vw,1.75rem)] font-semibold tracking-[-0.005em] text-ink">
                        সামাজিক মাধ্যমে আমাদের অনুসরণ করুন
                    </h2>
                    <div class="flex flex-wrap justify-center gap-4">
                        @if (!empty($socials['social_facebook']))
                            <a href="{{ $socials['social_facebook'] }}" target="_blank" rel="noopener" aria-label="ফেসবুক"
                                class="group flex items-center gap-3 rounded-full border border-hairline bg-white px-6 py-3 text-sm font-medium text-ink transition-all duration-300 hover:-translate-y-0.5 hover:border-[#1877f2] hover:bg-[#1877f2]/5 hover:text-[#1877f2] hover:shadow-sm">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M14 9V7c0-1 .3-1.5 1.6-1.5H17V2.5h-2.4C11.9 2.5 11 4 11 6.3V9H8.5v3H11v9.5h3V12h2.2l.4-3H14z" />
                                </svg>
                                ফেসবুক
                            </a>
                        @endif
                        @if (!empty($socials['social_twitter']))
                            <a href="{{ $socials['social_twitter'] }}" target="_blank" rel="noopener" aria-label="এক্স"
                                class="group flex items-center gap-3 rounded-full border border-hairline bg-white px-6 py-3 text-sm font-medium text-ink transition-all duration-300 hover:-translate-y-0.5 hover:border-ink hover:bg-ink/5 hover:text-ink hover:shadow-sm">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M17.5 3h3l-6.6 7.5L21.7 21h-5.9l-4.3-5.6L6.4 21H3.3l7-8L2.6 3h6l3.9 5.1L17.5 3zm-1 16h1.6L7.6 4.6H5.9L16.5 19z" />
                                </svg>
                                এক্স
                            </a>
                        @endif
                        @if (!empty($socials['social_instagram']))
                            <a href="{{ $socials['social_instagram'] }}" target="_blank" rel="noopener" aria-label="ইনস্টাগ্রাম"
                                class="group flex items-center gap-3 rounded-full border border-hairline bg-white px-6 py-3 text-sm font-medium text-ink transition-all duration-300 hover:-translate-y-0.5 hover:border-[#e4405f] hover:bg-[#e4405f]/5 hover:text-[#e4405f] hover:shadow-sm">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M12 2.163c3.204 0 3.584.012 4.85.07 1.17.054 1.805.249 2.227.415.56.217.96.477 1.38.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.058 1.266.069 1.646.069 4.85s-.012 3.584-.07 4.85c-.054 1.17-.249 1.805-.413 2.227-.217.56-.477.96-.896 1.381-.42.419-.82.679-1.38.896-.422.164-1.057.36-2.227.413-1.266.058-1.646.069-4.85.069s-3.584-.012-4.85-.07c-1.17-.054-1.805-.249-2.227-.413-.56-.217-.96-.477-1.38-.896-.42-.42-.679-.82-.896-1.38-.164-.422-.36-1.057-.413-2.227C2.175 15.584 2.163 15.204 2.163 12s.012-3.584.07-4.85c.054-1.17.249-1.805.413-2.227.217-.56.477-.96.896-1.38.42-.42.82-.679 1.38-.896.422-.164 1.057-.36 2.227-.413C8.416 2.175 8.796 2.163 12 2.163zM12 0C8.741 0 8.333.014 7.053.072 5.775.13 4.902.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.902.13 5.775.072 7.053.014 8.333 0 8.741 0 12s.014 3.668.072 4.948c.058 1.277.261 2.15.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.763.297 1.636.5 2.913.558C8.333 23.986 8.741 24 12 24s3.668-.014 4.948-.072c1.277-.058 2.15-.261 2.913-.558.788-.306 1.459-.717 2.126-1.384.666-.667 1.079-1.338 1.384-2.126.297-.763.5-1.636.558-2.913.058-1.28.072-1.688.072-4.948s-.014-3.668-.072-4.948c-.058-1.277-.261-2.15-.558-2.913-.306-.789-.717-1.459-1.384-2.126C21.32 1.347 20.651.935 19.86.63c-.763-.297-1.636.5-2.913-.558C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z" />
                                </svg>
                                ইনস্টাগ্রাম
                            </a>
                        @endif
                        @if (!empty($socials['social_youtube']))
                            <a href="{{ $socials['social_youtube'] }}" target="_blank" rel="noopener" aria-label="ইউটিউব"
                                class="group flex items-center gap-3 rounded-full border border-hairline bg-white px-6 py-3 text-sm font-medium text-ink transition-all duration-300 hover:-translate-y-0.5 hover:border-[#ff0000] hover:bg-[#ff0000]/5 hover:text-[#ff0000] hover:shadow-sm">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                                </svg>
                                ইউটিউব
                            </a>
                        @endif
                        @if (!empty($socials['social_telegram']))
                            <a href="{{ $socials['social_telegram'] }}" target="_blank" rel="noopener" aria-label="টেলিগ্রাম"
                                class="group flex items-center gap-3 rounded-full border border-hairline bg-white px-6 py-3 text-sm font-medium text-ink transition-all duration-300 hover:-translate-y-0.5 hover:border-[#26a5e4] hover:bg-[#26a5e4]/5 hover:text-[#26a5e4] hover:shadow-sm">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.479.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z" />
                                </svg>
                                টেলিগ্রাম
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    @endif

    <script>
        $(document).ready(function() {
            $('#flash-message').delay(4000).fadeOut(300);
        });
    </script>
@endsection
