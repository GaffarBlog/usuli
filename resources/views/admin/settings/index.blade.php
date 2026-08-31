@extends('admin.layouts.app')

@section('title', 'সেটিংস — উসুলি অ্যাডমিন')

@section('content')
    @php
        $activeTab = request('tab', 'site');
        $tabs = [
            'site' => 'সাইট সেটিংস',
            'home' => 'হোম পেজ',
            'contact' => 'যোগাযোগ পেজ',
            'footer' => 'ফুটার',
            'social' => 'সোশ্যাল মিডিয়া',
        ];
    @endphp

    <div class="space-y-6">
        {{-- Breadcrumbs --}}
        <nav class="flex items-center gap-2 text-sm text-faint">
            <a href="{{ route('admin.dashboard.view') }}" class="transition-colors hover:text-brand">ড্যাশবোর্ড</a>
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M9 18l6-6-6-6" />
            </svg>
            <span class="text-ink">সেটিংস</span>
        </nav>

        {{-- Header --}}
        <h1 class="text-2xl font-semibold text-ink">সেটিংস</h1>

        {{-- Flash Message --}}
        @if (session('success'))
            <div id="flash-message" class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        {{-- Tabs --}}
        <div class="border-b border-hairline">
            <nav class="flex gap-1 -mb-px overflow-x-auto" aria-label="সেটিংস ট্যাব">
                @foreach ($tabs as $key => $label)
                    <a href="{{ route('admin.settings.index', ['tab' => $key]) }}"
                        class="shrink-0 border-b-2 px-4 py-2.5 text-sm font-medium transition-colors {{ $activeTab === $key ? 'border-brand text-brand' : 'border-transparent text-faint hover:border-gray-300 hover:text-ink' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </nav>
        </div>

        {{-- Tab Content --}}
        @if ($activeTab === 'site')
            <form method="POST" action="{{ route('admin.settings.update', ['tab' => 'site']) }}" enctype="multipart/form-data" class="space-y-6 rounded-xl border border-hairline bg-white p-6">
                @csrf
                @method('PUT')
                <input type="hidden" name="tab" value="site">

                <h2 class="text-lg font-semibold text-ink">সাইট তথ্য</h2>

                {{-- Site Logo --}}
                <div>
                    <label for="site_logo" class="mb-1.5 block text-sm font-medium text-ink">সাইট লোগো</label>
                    <div class="flex items-center gap-4">
                        <div class="shrink-0">
                            @if (!empty($settings['site_logo']))
                                <img id="logoPreview" src="{{ $settings['site_logo'] }}" alt="লোগো" class="h-16 w-16 rounded-lg object-contain">
                            @else
                                <span id="logoPreview" class="grid h-16 w-16 place-items-center rounded-lg bg-brand-soft font-serif text-xl font-semibold text-brand">
                                    {{ mb_substr($settings['site_name'] ?? 'উ', 0, 1, 'UTF-8') }}
                                </span>
                            @endif
                        </div>
                        <div class="flex-1">
                            <input type="file" id="site_logo" name="site_logo" accept="image/*"
                                class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20 file:mr-3 file:rounded-lg file:border-0 file:bg-brand/10 file:px-3 file:py-1.5 file:text-sm file:font-medium file:text-brand hover:file:bg-brand/20">
                            <p class="mt-1 text-xs text-faint">JPG, PNG অথবা WebP। সর্বোচ্চ 2MB।</p>
                        </div>
                    </div>
                    @error('site_logo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid gap-6 sm:grid-cols-2">
                    {{-- Site Name --}}
                    <div>
                        <label for="site_name" class="mb-1.5 block text-sm font-medium text-ink">
                            সাইটের নাম <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="site_name" name="site_name" value="{{ old('site_name', $settings['site_name'] ?? '') }}" required
                            class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20" placeholder="সাইটের নাম লিখুন">
                        @error('site_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Site Description --}}
                <div>
                    <label for="site_description" class="mb-1.5 block text-sm font-medium text-ink">সাইটের বিবরণ</label>
                    <textarea id="site_description" name="site_description" rows="3"
                        class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20"
                        placeholder="সাইট সম্পর্কে সংক্ষিপ্ত বিবরণ">{{ old('site_description', $settings['site_description'] ?? '') }}</textarea>
                    @error('site_description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <h3 class="pt-2 text-base font-semibold text-ink">যোগাযোগের তথ্য</h3>

                <div class="grid gap-6 sm:grid-cols-2">
                    {{-- Phone --}}
                    <div>
                        <label for="phone" class="mb-1.5 block text-sm font-medium text-ink">ফোন</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $settings['phone'] ?? '') }}"
                            class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20" placeholder="০১XXXXXXXXX">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="mb-1.5 block text-sm font-medium text-ink">ইমেইল</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $settings['email'] ?? '') }}"
                            class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20" placeholder="info@example.com">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Address --}}
                <div>
                    <label for="address" class="mb-1.5 block text-sm font-medium text-ink">ঠিকানা</label>
                    <textarea id="address" name="address" rows="2"
                        class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20"
                        placeholder="সম্পূর্ণ ঠিকানা">{{ old('address', $settings['address'] ?? '') }}</textarea>
                    @error('address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Buttons --}}
                <div class="flex items-center gap-3 pt-4 border-t border-hairline">
                    <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-brand px-5 py-2.5 text-sm font-medium text-white transition-colors hover:bg-brand-deep">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                            <polyline points="17 21 17 13 7 13 7 21" />
                            <polyline points="7 3 7 8 15 8" />
                        </svg>
                        সংরক্ষণ করুন
                    </button>
                </div>
            </form>

        @elseif ($activeTab === 'home')
            <form method="POST" action="{{ route('admin.settings.update', ['tab' => 'home']) }}" enctype="multipart/form-data" class="space-y-6 rounded-xl border border-hairline bg-white p-6">
                @csrf
                @method('PUT')
                <input type="hidden" name="tab" value="home">

                <h2 class="text-lg font-semibold text-ink">হোম পেজ সেটিংস</h2>

                {{-- Hero Post --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-ink">হিরো পোস্ট</label>
                    <p class="mb-3 text-xs text-faint">হোম পেজের শীর্ষে প্রদর্শিত প্রধান পোস্ট।</p>
                    <div id="heroPostSelected" class="mb-3" style="{{ empty($heroPost) ? 'display:none' : '' }}">
                        <div class="flex items-center gap-4 rounded-lg border border-brand/30 bg-brand-soft/30 p-4">
                            @if ($heroPost?->image)
                                <img src="{{ $heroPost->image }}" alt="" class="h-16 w-16 shrink-0 rounded-lg object-cover">
                            @else
                                <span class="grid h-16 w-16 shrink-0 place-items-center rounded-lg bg-gray-200 text-xs text-faint">ছবি নেই</span>
                            @endif
                            <div class="flex-1 min-w-0">
                                <p class="truncate font-medium text-ink">{{ $heroPost->title ?? '' }}</p>
                                <p class="text-xs text-faint">{{ $heroPost->category?->name ?? 'বিভাগহীন' }}</p>
                            </div>
                            <button type="button" onclick="clearHeroPost()" class="shrink-0 rounded-lg p-1.5 text-faint transition-colors hover:bg-red-50 hover:text-red-500">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18M6 6l12 12"/></svg>
                            </button>
                        </div>
                    </div>
                    <input type="hidden" id="heroPostId" name="home_hero_post_id" value="{{ $settings['home_hero_post_id'] ?? '' }}">
                    <div id="heroPostSearch" style="{{ !empty($heroPost) ? 'display:none' : '' }}">
                        <div class="relative">
                            <input type="text" id="heroSearchInput" placeholder="পোস্ট খুঁজুন..."
                                class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20">
                            <div id="heroSearchResults" class="absolute z-10 mt-1 hidden w-full rounded-lg border border-hairline bg-white shadow-lg"></div>
                        </div>
                    </div>
                    @error('home_hero_post_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Feature Post --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-ink">নির্বাচিত পোস্ট</label>
                    <p class="mb-3 text-xs text-faint">হোম পেজের "নির্বাচিত" সেকশনে প্রদর্শিত পোস্ট।</p>
                    <div id="featurePostSelected" class="mb-3" style="{{ empty($featurePost) ? 'display:none' : '' }}">
                        <div class="flex items-center gap-4 rounded-lg border border-brand/30 bg-brand-soft/30 p-4">
                            @if ($featurePost?->image)
                                <img src="{{ $featurePost->image }}" alt="" class="h-16 w-16 shrink-0 rounded-lg object-cover">
                            @else
                                <span class="grid h-16 w-16 shrink-0 place-items-center rounded-lg bg-gray-200 text-xs text-faint">ছবি নেই</span>
                            @endif
                            <div class="flex-1 min-w-0">
                                <p class="truncate font-medium text-ink">{{ $featurePost->title ?? '' }}</p>
                                <p class="text-xs text-faint">{{ $featurePost->category?->name ?? 'বিভাগহীন' }}</p>
                            </div>
                            <button type="button" onclick="clearFeaturePost()" class="shrink-0 rounded-lg p-1.5 text-faint transition-colors hover:bg-red-50 hover:text-red-500">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18M6 6l12 12"/></svg>
                            </button>
                        </div>
                    </div>
                    <input type="hidden" id="featurePostId" name="home_feature_post_id" value="{{ $settings['home_feature_post_id'] ?? '' }}">
                    <div id="featurePostSearch" style="{{ !empty($featurePost) ? 'display:none' : '' }}">
                        <div class="relative">
                            <input type="text" id="featureSearchInput" placeholder="পোস্ট খুঁজুন..."
                                class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20">
                            <div id="featureSearchResults" class="absolute z-10 mt-1 hidden w-full rounded-lg border border-hairline bg-white shadow-lg"></div>
                        </div>
                    </div>
                    @error('home_feature_post_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Banner Image --}}
                <div>
                    <label for="home_banner" class="mb-1.5 block text-sm font-medium text-ink">ব্যানার ছবি</label>
                    <p class="mb-3 text-xs text-faint">হোম পেজের "নির্বাচিত" সেকশনের পেছনের ব্যাকগ্রাউন্ড ইমেজ।</p>
                    <div class="flex items-center gap-4">
                        <div class="shrink-0">
                            @if (!empty($settings['home_banner']))
                                <img id="bannerPreview" src="{{ $settings['home_banner'] }}" alt="ব্যানার" class="h-20 w-40 rounded-lg object-cover">
                            @else
                                <div id="bannerPreview" class="flex h-20 w-40 items-center justify-center rounded-lg border-2 border-dashed border-hairline bg-gray-50 text-xs text-faint">
                                    ছবি নেই
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <input type="file" id="home_banner" name="home_banner" accept="image/*"
                                class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20 file:mr-3 file:rounded-lg file:border-0 file:bg-brand/10 file:px-3 file:py-1.5 file:text-sm file:font-medium file:text-brand hover:file:bg-brand/20">
                            <p class="mt-1 text-xs text-faint">JPG, PNG অথবা WebP। সর্বোচ্চ 4MB।</p>
                        </div>
                    </div>
                    @error('home_banner')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Buttons --}}
                <div class="flex items-center gap-3 pt-4 border-t border-hairline">
                    <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-brand px-5 py-2.5 text-sm font-medium text-white transition-colors hover:bg-brand-deep">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                            <polyline points="17 21 17 13 7 13 7 21" />
                            <polyline points="7 3 7 8 15 8" />
                        </svg>
                        সংরক্ষণ করুন
                    </button>
                </div>
            </form>

        @elseif ($activeTab === 'social')
            <form method="POST" action="{{ route('admin.settings.update', ['tab' => 'social']) }}" class="space-y-6 rounded-xl border border-hairline bg-white p-6">
                @csrf
                @method('PUT')
                <input type="hidden" name="tab" value="social">

                <h2 class="text-lg font-semibold text-ink">সোশ্যাল মিডিয়া লিংক</h2>
                <p class="text-sm text-faint">আপনার সামাজিক মাধ্যমের প্রোফাইল লিংক দিন। ফাঁকা লিংক প্রদর্শন করা হবে না।</p>

                <div class="grid gap-5 sm:grid-cols-2">
                    {{-- Facebook --}}
                    <div>
                        <label for="social_facebook" class="mb-1.5 flex items-center gap-2 text-sm font-medium text-ink">
                            <svg class="h-4 w-4 text-[#1877f2]" viewBox="0 0 24 24" fill="currentColor"><path d="M14 9V7c0-1 .3-1.5 1.6-1.5H17V2.5h-2.4C11.9 2.5 11 4 11 6.3V9H8.5v3H11v9.5h3V12h2.2l.4-3H14z"/></svg>
                            ফেসবুক
                        </label>
                        <input type="url" id="social_facebook" name="social_facebook" value="{{ old('social_facebook', $settings['social_facebook'] ?? '') }}"
                            class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20" placeholder="https://facebook.com/your-page">
                        @error('social_facebook')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Twitter / X --}}
                    <div>
                        <label for="social_twitter" class="mb-1.5 flex items-center gap-2 text-sm font-medium text-ink">
                            <svg class="h-4 w-4 text-ink" viewBox="0 0 24 24" fill="currentColor"><path d="M17.5 3h3l-6.6 7.5L21.7 21h-5.9l-4.3-5.6L6.4 21H3.3l7-8L2.6 3h6l3.9 5.1L17.5 3zm-1 16h1.6L7.6 4.6H5.9L16.5 19z"/></svg>
                            এক্স (টুইটার)
                        </label>
                        <input type="url" id="social_twitter" name="social_twitter" value="{{ old('social_twitter', $settings['social_twitter'] ?? '') }}"
                            class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20" placeholder="https://x.com/your-handle">
                        @error('social_twitter')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Instagram --}}
                    <div>
                        <label for="social_instagram" class="mb-1.5 flex items-center gap-2 text-sm font-medium text-ink">
                            <svg class="h-4 w-4 text-[#e4405f]" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 1.17.054 1.805.249 2.227.415.56.217.96.477 1.38.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.058 1.266.069 1.646.069 4.85s-.012 3.584-.07 4.85c-.054 1.17-.249 1.805-.413 2.227-.217.56-.477.96-.896 1.381-.42.419-.82.679-1.38.896-.422.164-1.057.36-2.227.413-1.266.058-1.646.069-4.85.069s-3.584-.012-4.85-.07c-1.17-.054-1.805-.249-2.227-.413-.56-.217-.96-.477-1.38-.896-.42-.42-.679-.82-.896-1.38-.164-.422-.36-1.057-.413-2.227C2.175 15.584 2.163 15.204 2.163 12s.012-3.584.07-4.85c.054-1.17.249-1.805.413-2.227.217-.56.477-.96.896-1.38.42-.42.82-.679 1.38-.896.422-.164 1.057-.36 2.227-.413C8.416 2.175 8.796 2.163 12 2.163zM12 0C8.741 0 8.333.014 7.053.072 5.775.13 4.902.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.902.13 5.775.072 7.053.014 8.333 0 8.741 0 12s.014 3.668.072 4.948c.058 1.277.261 2.15.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.763.297 1.636.5 2.913.558C8.333 23.986 8.741 24 12 24s3.668-.014 4.948-.072c1.277-.058 2.15-.261 2.913-.558.788-.306 1.459-.717 2.126-1.384.666-.667 1.079-1.338 1.384-2.126.297-.763.5-1.636.558-2.913.058-1.28.072-1.688.072-4.948s-.014-3.668-.072-4.948c-.058-1.277-.261-2.15-.558-2.913-.306-.789-.717-1.459-1.384-2.126C21.32 1.347 20.651.935 19.86.63c-.763-.297-1.636-.5-2.913-.558C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                            ইনস্টাগ্রাম
                        </label>
                        <input type="url" id="social_instagram" name="social_instagram" value="{{ old('social_instagram', $settings['social_instagram'] ?? '') }}"
                            class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20" placeholder="https://instagram.com/your-handle">
                        @error('social_instagram')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- YouTube --}}
                    <div>
                        <label for="social_youtube" class="mb-1.5 flex items-center gap-2 text-sm font-medium text-ink">
                            <svg class="h-4 w-4 text-[#ff0000]" viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                            ইউটিউব
                        </label>
                        <input type="url" id="social_youtube" name="social_youtube" value="{{ old('social_youtube', $settings['social_youtube'] ?? '') }}"
                            class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20" placeholder="https://youtube.com/@your-channel">
                        @error('social_youtube')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Telegram --}}
                    <div>
                        <label for="social_telegram" class="mb-1.5 flex items-center gap-2 text-sm font-medium text-ink">
                            <svg class="h-4 w-4 text-[#26a5e4]" viewBox="0 0 24 24" fill="currentColor"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.479.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>
                            টেলিগ্রাম
                        </label>
                        <input type="url" id="social_telegram" name="social_telegram" value="{{ old('social_telegram', $settings['social_telegram'] ?? '') }}"
                            class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20" placeholder="https://t.me/your-channel">
                        @error('social_telegram')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="flex items-center gap-3 pt-4 border-t border-hairline">
                    <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-brand px-5 py-2.5 text-sm font-medium text-white transition-colors hover:bg-brand-deep">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                            <polyline points="17 21 17 13 7 13 7 21" />
                            <polyline points="7 3 7 8 15 8" />
                        </svg>
                        সংরক্ষণ করুন
                    </button>
                </div>
            </form>

        @else
            {{-- Placeholder for other tabs --}}
            <div class="rounded-xl border border-hairline bg-white p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-faint" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10" />
                    <path d="M12 6v6l4 2" />
                </svg>
                <h3 class="mt-4 text-lg font-semibold text-ink">{{ $tabs[$activeTab] }}</h3>
                <p class="mt-2 text-sm text-faint">এই সেকশনটি শীঘ্রই আসছে।</p>
            </div>
        @endif
    </div>

    @push('scripts')
    <script>
        $(function() {
            var searchUrl = '{{ route("admin.settings.posts.search") }}';
            var debounceTimer;

            $('#site_logo').on('change', function(e) {
                var file = e.target.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(ev) {
                        var $preview = $('#logoPreview');
                        if ($preview.is('span')) {
                            var $img = $('<img>').attr({
                                id: 'logoPreview',
                                src: ev.target.result,
                                alt: 'লোগো',
                                'class': 'h-16 w-16 rounded-lg object-contain'
                            });
                            $preview.replaceWith($img);
                        } else {
                            $preview.attr('src', ev.target.result);
                        }
                    };
                    reader.readAsDataURL(file);
                }
            });

            $('#home_banner').on('change', function(e) {
                var file = e.target.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(ev) {
                        var $preview = $('#bannerPreview');
                        if ($preview.is('div')) {
                            var $img = $('<img>').attr({
                                id: 'bannerPreview',
                                src: ev.target.result,
                                alt: 'ব্যানার',
                                'class': 'h-20 w-40 rounded-lg object-cover'
                            });
                            $preview.replaceWith($img);
                        } else {
                            $preview.attr('src', ev.target.result);
                        }
                    };
                    reader.readAsDataURL(file);
                }
            });

            function initPostSearch(inputId, resultsId, hiddenId, selectedId, searchId) {
                var $input = $('#' + inputId);
                var $results = $('#' + resultsId);
                var $hidden = $('#' + hiddenId);

                $input.on('keyup', function() {
                    var q = $(this).val().trim();
                    clearTimeout(debounceTimer);
                    if (q.length < 1) {
                        $results.addClass('hidden').empty();
                        return;
                    }
                    debounceTimer = setTimeout(function() {
                        $.get(searchUrl, { q: q }, function(data) {
                            $results.empty();
                            if (data.length === 0) {
                                $results.append('<div class="px-4 py-3 text-sm text-faint">কোনো পোস্ট পাওয়া যায়নি।</div>');
                            } else {
                                $.each(data, function(i, post) {
                                    var img = post.image
                                        ? '<img src="' + post.image + '" class="h-10 w-10 shrink-0 rounded object-cover">'
                                        : '<span class="grid h-10 w-10 shrink-0 place-items-center rounded bg-gray-200 text-[10px] text-faint">ছবি নেই</span>';
                                    var html = '<div class="flex items-center gap-3 px-4 py-3 cursor-pointer transition-colors hover:bg-gray-50 post-select-item" data-id="' + post.id + '" data-title="' + post.title.replace(/"/g, '&quot;') + '" data-image="' + (post.image || '') + '" data-category="' + (post.excerpt || '') + '">' + img + '<div class="flex-1 min-w-0"><p class="truncate text-sm font-medium text-ink">' + post.title + '</p></div></div>';
                                    $results.append(html);
                                });
                            }
                            $results.removeClass('hidden');
                        });
                    }, 300);
                });

                $results.on('click', '.post-select-item', function() {
                    var id = $(this).data('id');
                    var title = $(this).data('title');
                    var image = $(this).data('image');
                    $hidden.val(id);
                    $input.val('');
                    $results.addClass('hidden').empty();

                    var imgHtml = image
                        ? '<img src="' + image + '" alt="" class="h-16 w-16 shrink-0 rounded-lg object-cover">'
                        : '<span class="grid h-16 w-16 shrink-0 place-items-center rounded-lg bg-gray-200 text-xs text-faint">ছবি নেই</span>';
                    var cardHtml = '<div class="flex items-center gap-4 rounded-lg border border-brand/30 bg-brand-soft/30 p-4">' + imgHtml + '<div class="flex-1 min-w-0"><p class="truncate font-medium text-ink">' + title + '</p></div><button type="button" onclick="clear' + (inputId === 'heroSearchInput' ? 'Hero' : 'Feature') + 'Post()" class="shrink-0 rounded-lg p-1.5 text-faint transition-colors hover:bg-red-50 hover:text-red-500"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18M6 6l12 12"/></svg></button></div>';

                    $('#' + selectedId).html(cardHtml).show();
                    $('#' + searchId).hide();
                });

                $(document).on('click', function(e) {
                    if (!$(e.target).closest('#' + inputId).length && !$(e.target).closest('#' + resultsId).length) {
                        $results.addClass('hidden');
                    }
                });
            }

            initPostSearch('heroSearchInput', 'heroSearchResults', 'heroPostId', 'heroPostSelected', 'heroPostSearch');
            initPostSearch('featureSearchInput', 'featureSearchResults', 'featurePostId', 'featurePostSelected', 'featurePostSearch');
        });

        function clearHeroPost() {
            $('#heroPostId').val('');
            $('#heroPostSelected').hide().empty();
            $('#heroPostSearch').show();
        }

        function clearFeaturePost() {
            $('#featurePostId').val('');
            $('#featurePostSelected').hide().empty();
            $('#featurePostSearch').show();
        }
    </script>
    @endpush
@endsection
