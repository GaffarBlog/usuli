@extends('admin.layouts.app')

@section('title', 'সেটিংস — উসুলি অ্যাডমিন')

@section('content')
    @php
        $activeTab = request('tab', 'site');
        $tabs = [
            'site' => 'সাইট সেটিংস',
            'home' => 'হোম পেজ',
            'navbar' => 'নেভার',
            'about' => 'আমাদের সম্পর্কে',
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

        @elseif ($activeTab === 'navbar')
            <div class="space-y-6 rounded-xl border border-hairline bg-white p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-ink">নেভার মেনু</h2>
                        <p class="text-sm text-faint">ড্র্যাগ করে মেনুর অর্ডার পরিবর্তন করুন। হোম, ব্লগ, আমাদের সম্পর্কে ও যোগাযোগ মুছে ফেলা যাবে না।</p>
                    </div>
                    <button type="button" id="addCategoryBtn"
                        class="inline-flex items-center gap-2 rounded-lg bg-brand px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-brand-deep">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                        ক্যাটাগরি যোগ করুন
                    </button>
                </div>

                {{-- Add Category Modal --}}
                <div id="addCategoryModal" class="hidden">
                    <div class="rounded-lg border border-hairline bg-gray-50 p-4">
                        <label class="mb-2 block text-sm font-medium text-ink">ক্যাটাগরি খুঁজুন</label>
                        <div class="relative">
                            <input type="text" id="catSearchInput" placeholder="ক্যাটাগরির নাম লিখুন..."
                                class="w-full rounded-lg border border-hairline bg-white px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:ring-1 focus:ring-brand/20">
                            <div id="catSearchResults" class="absolute z-10 mt-1 hidden w-full rounded-lg border border-hairline bg-white shadow-lg max-h-60 overflow-y-auto"></div>
                        </div>
                        <button type="button" id="cancelAddCategory" class="mt-3 text-sm text-faint hover:text-ink">বাতিল করুন</button>
                    </div>
                </div>

                {{-- Sortable Navbar Items --}}
                <form id="navbarForm" method="POST" action="{{ route('admin.settings.update', ['tab' => 'navbar']) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="tab" value="navbar">
                    <input type="hidden" id="navbarItemsJson" name="navbar_items_json" value="{{ json_encode($navbarItems) }}">

                    <ul id="navbarList" class="space-y-2">
                        @forelse ($navbarItems as $index => $item)
                            <li class="navbar-item flex items-center gap-3 rounded-lg border border-hairline bg-white px-4 py-3 transition-colors hover:border-brand/40"
                                data-type="{{ $item['type'] ?? 'category' }}"
                                data-category-id="{{ $item['category_id'] ?? '' }}"
                                data-index="{{ $index }}">
                                {{-- Drag Handle --}}
                                <span class="sortable-handle cursor-grab text-faint hover:text-ink">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M8 6a2 2 0 1 1 0 4 2 2 0 0 1 0-4zm0 6a2 2 0 1 1 0 4 2 2 0 0 1 0-4zm0 6a2 2 0 1 1 0 4 2 2 0 0 1 0-4zm8-14a2 2 0 1 1 0 4 2 2 0 0 1 0-4zm0 6a2 2 0 1 1 0 4 2 2 0 0 1 0-4zm0 6a2 2 0 1 1 0 4 2 2 0 0 1 0-4z"/></svg>
                                </span>

                                {{-- Type Badge --}}
                                @if (($item['type'] ?? '') === 'home')
                                    <span class="shrink-0 rounded-md bg-emerald-50 px-2 py-0.5 text-xs font-medium text-emerald-700">হোম</span>
                                @elseif (($item['type'] ?? '') === 'blog')
                                    <span class="shrink-0 rounded-md bg-blue-50 px-2 py-0.5 text-xs font-medium text-blue-700">ব্লগ</span>
                                @elseif (($item['type'] ?? '') === 'about')
                                    <span class="shrink-0 rounded-md bg-amber-50 px-2 py-0.5 text-xs font-medium text-amber-700">আমাদের সম্পর্কে</span>
                                @elseif (($item['type'] ?? '') === 'contact')
                                    <span class="shrink-0 rounded-md bg-rose-50 px-2 py-0.5 text-xs font-medium text-rose-700">যোগাযোগ</span>
                                @else
                                    <span class="shrink-0 rounded-md bg-purple-50 px-2 py-0.5 text-xs font-medium text-purple-700">ক্যাটাগরি</span>
                                @endif

                                {{-- Label Input --}}
                                <input type="text" class="navbar-label flex-1 rounded-md border border-hairline bg-gray-50/50 px-3 py-1.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20"
                                    value="{{ $item['label'] ?? '' }}" placeholder="মেনু টেক্সট">

                                {{-- Toggle (about & contact only) --}}
                                @if (in_array($item['type'] ?? '', ['about', 'contact']))
                                    <label class="relative inline-flex shrink-0 cursor-pointer items-center">
                                        <input type="checkbox" class="navbar-enabled sr-only peer"
                                            {{ ($item['enabled'] ?? true) ? 'checked' : '' }}>
                                        <div class="h-5 w-9 rounded-full bg-gray-200 after:absolute after:left-[2px] after:top-[2px] after:h-4 after:w-4 after:rounded-full after:bg-white after:transition-all peer-checked:bg-brand peer-checked:after:translate-x-full"></div>
                                    </label>
                                @endif

                                {{-- Delete Button --}}
                                @if (! in_array($item['type'] ?? '', ['home', 'blog', 'about', 'contact']))
                                    <button type="button" class="remove-navbar-item shrink-0 rounded-lg p-1.5 text-faint transition-colors hover:bg-red-50 hover:text-red-500"
                                        title="মুছে ফেলুন">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18M6 6l12 12"/></svg>
                                    </button>
                                @endif
                            </li>
                        @empty
                            <li class="py-8 text-center text-sm text-faint">কোনো মেনু আইটেম নেই। "ক্যাটাগরি যোগ করুন" বাটনে ক্লিক করুন।</li>
                        @endforelse
                    </ul>

                    {{-- Buttons --}}
                    <div class="flex items-center gap-3 pt-4 mt-4 border-t border-hairline">
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
            </div>

        @elseif ($activeTab === 'about')
            <form method="POST" action="{{ route('admin.settings.update', ['tab' => 'about']) }}" class="space-y-6 rounded-xl border border-hairline bg-white p-6">
                @csrf
                @method('PUT')
                <input type="hidden" name="tab" value="about">

                <h2 class="text-lg font-semibold text-ink">আমাদের সম্পর্কে পেজ সেটিংস</h2>
                <p class="text-sm text-faint">আমাদের সম্পর্কে পেজের বিষয়বস্তু পরিচালনা করুন।</p>

                {{-- Hero Section --}}
                <div class="rounded-lg border border-hairline bg-gray-50/50 p-5 space-y-4">
                    <h3 class="text-base font-semibold text-ink">হিরো সেকশন</h3>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label for="about_hero_label" class="mb-1.5 block text-sm font-medium text-ink">লেবেল</label>
                            <input type="text" id="about_hero_label" name="about_hero_label" value="{{ old('about_hero_label', $settings['about_hero_label'] ?? '') }}"
                                class="w-full rounded-lg border border-hairline bg-white px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:ring-1 focus:ring-brand/20" placeholder="আমাদের সম্পর্কে">
                            @error('about_hero_label')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="about_hero_title" class="mb-1.5 block text-sm font-medium text-ink">শিরোনাম</label>
                            <input type="text" id="about_hero_title" name="about_hero_title" value="{{ old('about_hero_title', $settings['about_hero_title'] ?? '') }}"
                                class="w-full rounded-lg border border-hairline bg-white px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:ring-1 focus:ring-brand/20" placeholder="উসুলি কী?">
                            @error('about_hero_title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="about_hero_subtitle" class="mb-1.5 block text-sm font-medium text-ink">উপশিরোনাম</label>
                        <textarea id="about_hero_subtitle" name="about_hero_subtitle" rows="2"
                            class="w-full rounded-lg border border-hairline bg-white px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:ring-1 focus:ring-brand/20"
                            placeholder="উসুলি হলো বাংলা সাহিত্যের একটি অনলাইন জার্নাল...">{{ old('about_hero_subtitle', $settings['about_hero_subtitle'] ?? '') }}</textarea>
                        @error('about_hero_subtitle')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Mission Section --}}
                <div class="rounded-lg border border-hairline bg-gray-50/50 p-5 space-y-4">
                    <h3 class="text-base font-semibold text-ink">লক্ষ্য সেকশন</h3>

                    <div>
                        <label for="about_mission_title" class="mb-1.5 block text-sm font-medium text-ink">শিরোনাম</label>
                        <input type="text" id="about_mission_title" name="about_mission_title" value="{{ old('about_mission_title', $settings['about_mission_title'] ?? '') }}"
                            class="w-full rounded-lg border border-hairline bg-white px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:ring-1 focus:ring-brand/20" placeholder="আমাদের লক্ষ্য">
                        @error('about_mission_title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="about_mission_p1" class="mb-1.5 block text-sm font-medium text-ink">অনুচ্ছেদ ১</label>
                        <textarea id="about_mission_p1" name="about_mission_p1" rows="3"
                            class="w-full rounded-lg border border-hairline bg-white px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:ring-1 focus:ring-brand/20"
                            placeholder="প্রথম অনুচ্ছেদ...">{{ old('about_mission_p1', $settings['about_mission_p1'] ?? '') }}</textarea>
                        @error('about_mission_p1')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="about_mission_p2" class="mb-1.5 block text-sm font-medium text-ink">অনুচ্ছেদ ২</label>
                        <textarea id="about_mission_p2" name="about_mission_p2" rows="3"
                            class="w-full rounded-lg border border-hairline bg-white px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:ring-1 focus:ring-brand/20"
                            placeholder="দ্বিতীয় অনুচ্ছেদ...">{{ old('about_mission_p2', $settings['about_mission_p2'] ?? '') }}</textarea>
                        @error('about_mission_p2')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Values Section --}}
                <div class="rounded-lg border border-hairline bg-gray-50/50 p-5 space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-base font-semibold text-ink">মূল্যবোধ সেকশন</h3>
                        <button type="button" id="addValueBtn"
                            class="inline-flex items-center gap-2 rounded-lg bg-brand px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-brand-deep">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                            মূল্যবোধ যোগ করুন
                        </button>
                    </div>

                    <div>
                        <label for="about_values_title" class="mb-1.5 block text-sm font-medium text-ink">শিরোনাম</label>
                        <input type="text" id="about_values_title" name="about_values_title" value="{{ old('about_values_title', $settings['about_values_title'] ?? '') }}"
                            class="w-full rounded-lg border border-hairline bg-white px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:ring-1 focus:ring-brand/20" placeholder="আমাদের মূল্যবোধ">
                        @error('about_values_title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <input type="hidden" id="aboutValuesJson" name="about_values_json" value="{{ $settings['about_values'] ?? '[]' }}">

                    <ul id="valuesList" class="space-y-3">
                        @php
                            $values = json_decode($settings['about_values'] ?? '[]', true) ?: [
                                ['title' => 'সাহিত্যচর্চা', 'description' => 'গল্প, কবিতা, প্রবন্ধ ও বিভিন্ন ধরনের সাহিত্যকর্মকে একটি একক মঞ্চে এনে তোলা।', 'icon' => 'book'],
                                ['title' => 'সম্প্রদায়', 'description' => 'পাঠক ও লেখকদের মধ্যে সংলাপ ও সম্পর্ক গড়ে তোলা।', 'icon' => 'users'],
                                ['title' => 'সর্বজনীনতা', 'description' => 'সকলের জন্য উন্মুক্ত, যে কেউ পড়তে ও লিখতে পারবেন।', 'icon' => 'globe'],
                            ];
                        @endphp
                        @forelse ($values as $index => $value)
                            <li class="value-item rounded-lg border border-hairline bg-white px-4 py-4 transition-colors hover:border-brand/40" data-index="{{ $index }}">
                                <div class="grid gap-3 sm:grid-cols-2">
                                    <div>
                                        <label class="mb-1 block text-xs font-medium text-ink">শিরোনাম</label>
                                        <input type="text" class="value-title w-full rounded-md border border-hairline bg-gray-50/50 px-3 py-1.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20"
                                            value="{{ $value['title'] ?? '' }}" placeholder="মূল্যবোধের নাম">
                                    </div>
                                    <div>
                                        <label class="mb-1 block text-xs font-medium text-ink">আইকন</label>
                                        <select class="value-icon w-full rounded-md border border-hairline bg-gray-50/50 px-3 py-1.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20">
                                            <option value="book" {{ ($value['icon'] ?? '') === 'book' ? 'selected' : '' }}>বই (book)</option>
                                            <option value="users" {{ ($value['icon'] ?? '') === 'users' ? 'selected' : '' }}>ব্যক্তি (users)</option>
                                            <option value="globe" {{ ($value['icon'] ?? '') === 'globe' ? 'selected' : '' }}>গ্লোব (globe)</option>
                                            <option value="heart" {{ ($value['icon'] ?? '') === 'heart' ? 'selected' : '' }}>হৃদয় (heart)</option>
                                            <option value="star" {{ ($value['icon'] ?? '') === 'star' ? 'selected' : '' }}>তারা (star)</option>
                                            <option value="lightbulb" {{ ($value['icon'] ?? '') === 'lightbulb' ? 'selected' : '' }}>বাতি (lightbulb)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <label class="mb-1 block text-xs font-medium text-ink">বিবরণ</label>
                                    <textarea class="value-description w-full rounded-md border border-hairline bg-gray-50/50 px-3 py-1.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20"
                                        rows="2" placeholder="মূল্যবোধের বিবরণ">{{ $value['description'] ?? '' }}</textarea>
                                </div>
                                <div class="mt-2 flex justify-end">
                                    <button type="button" class="remove-value-item rounded-lg p-1.5 text-faint transition-colors hover:bg-red-50 hover:text-red-500" title="মুছে ফেলুন">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18M6 6l12 12"/></svg>
                                    </button>
                                </div>
                            </li>
                        @empty
                            <li class="py-4 text-center text-sm text-faint">কোনো মূল্যবোধ নেই। "মূল্যবোধ যোগ করুন" বাটনে ক্লিক করুন।</li>
                        @endforelse
                    </ul>
                </div>

                {{-- Story Section --}}
                <div class="rounded-lg border border-hairline bg-gray-50/50 p-5 space-y-4">
                    <h3 class="text-base font-semibold text-ink">গল্প সেকশন</h3>

                    <div>
                        <label for="about_story_title" class="mb-1.5 block text-sm font-medium text-ink">শিরোনাম</label>
                        <input type="text" id="about_story_title" name="about_story_title" value="{{ old('about_story_title', $settings['about_story_title'] ?? '') }}"
                            class="w-full rounded-lg border border-hairline bg-white px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:ring-1 focus:ring-brand/20" placeholder="আমাদের গল্প">
                        @error('about_story_title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="about_story_p1" class="mb-1.5 block text-sm font-medium text-ink">অনুচ্ছেদ ১</label>
                        <textarea id="about_story_p1" name="about_story_p1" rows="3"
                            class="w-full rounded-lg border border-hairline bg-white px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:ring-1 focus:ring-brand/20"
                            placeholder="প্রথম অনুচ্ছেদ...">{{ old('about_story_p1', $settings['about_story_p1'] ?? '') }}</textarea>
                        @error('about_story_p1')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="about_story_p2" class="mb-1.5 block text-sm font-medium text-ink">অনুচ্ছেদ ২</label>
                        <textarea id="about_story_p2" name="about_story_p2" rows="3"
                            class="w-full rounded-lg border border-hairline bg-white px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:ring-1 focus:ring-brand/20"
                            placeholder="দ্বিতীয় অনুচ্ছেদ...">{{ old('about_story_p2', $settings['about_story_p2'] ?? '') }}</textarea>
                        @error('about_story_p2')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="about_story_p3" class="mb-1.5 block text-sm font-medium text-ink">অনুচ্ছেদ ৩</label>
                        <textarea id="about_story_p3" name="about_story_p3" rows="3"
                            class="w-full rounded-lg border border-hairline bg-white px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:ring-1 focus:ring-brand/20"
                            placeholder="তৃতীয় অনুচ্ছেদ...">{{ old('about_story_p3', $settings['about_story_p3'] ?? '') }}</textarea>
                        @error('about_story_p3')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- CTA Section --}}
                <div class="rounded-lg border border-hairline bg-gray-50/50 p-5 space-y-4">
                    <h3 class="text-base font-semibold text-ink">CTA সেকশন</h3>

                    <div>
                        <label for="about_cta_title" class="mb-1.5 block text-sm font-medium text-ink">শিরোনাম</label>
                        <input type="text" id="about_cta_title" name="about_cta_title" value="{{ old('about_cta_title', $settings['about_cta_title'] ?? '') }}"
                            class="w-full rounded-lg border border-hairline bg-white px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:ring-1 focus:ring-brand/20" placeholder="সাহিত্য কি আপনার প্রাণ?">
                        @error('about_cta_title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="about_cta_subtitle" class="mb-1.5 block text-sm font-medium text-ink">উপশিরোনাম</label>
                        <textarea id="about_cta_subtitle" name="about_cta_subtitle" rows="2"
                            class="w-full rounded-lg border border-hairline bg-white px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:ring-1 focus:ring-brand/20"
                            placeholder="আমাদের সঙ্গে যুক্ত হতে চাইলে...">{{ old('about_cta_subtitle', $settings['about_cta_subtitle'] ?? '') }}</textarea>
                        @error('about_cta_subtitle')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label for="about_cta_register_btn" class="mb-1.5 block text-sm font-medium text-ink">রেজিস্ট্রেশন বাটন টেক্সট</label>
                            <input type="text" id="about_cta_register_btn" name="about_cta_register_btn" value="{{ old('about_cta_register_btn', $settings['about_cta_register_btn'] ?? '') }}"
                                class="w-full rounded-lg border border-hairline bg-white px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:ring-1 focus:ring-brand/20" placeholder="নিবন্ধন করুন">
                            @error('about_cta_register_btn')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="about_cta_contact_btn" class="mb-1.5 block text-sm font-medium text-ink">যোগাযোগ বাটন টেক্সট</label>
                            <input type="text" id="about_cta_contact_btn" name="about_cta_contact_btn" value="{{ old('about_cta_contact_btn', $settings['about_cta_contact_btn'] ?? '') }}"
                                class="w-full rounded-lg border border-hairline bg-white px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:ring-1 focus:ring-brand/20" placeholder="যোগাযোগ করুন">
                            @error('about_cta_contact_btn')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
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

        @elseif ($activeTab === 'footer')
            <div class="space-y-6 rounded-xl border border-hairline bg-white p-6">
                <div>
                    <h2 class="text-lg font-semibold text-ink">ফুটার সেটিংস</h2>
                    <p class="text-sm text-faint">ফুটারের স্লোগান, মেনু এবং কপিরাইট পরিচালনা করুন।</p>
                </div>

                <form id="footerForm" method="POST" action="{{ route('admin.settings.update', ['tab' => 'footer']) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="tab" value="footer">

                    {{-- Footer Slogan --}}
                    <div>
                        <label for="footer_slogan" class="mb-1.5 block text-sm font-medium text-ink">ফুটার স্লোগান</label>
                        <input type="text" id="footer_slogan" name="footer_slogan" value="{{ old('footer_slogan', $settings['footer_slogan'] ?? '') }}"
                            class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20" placeholder="ফুটারের স্লোগান লিখুন">
                        @error('footer_slogan')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Footer Menu Items --}}
                    <div class="mt-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-ink">ফুটার মেনু</label>
                                <p class="text-xs text-faint">ড্র্যাগ করে মেনুর অর্ডার পরিবর্তন করুন।</p>
                            </div>
                            <button type="button" id="addFooterLinkBtn"
                                class="inline-flex items-center gap-2 rounded-lg bg-brand px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-brand-deep">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                                লিংক যোগ করুন
                            </button>
                        </div>

                        {{-- Add Custom Link Form --}}
                        <div id="addFooterLinkModal" class="hidden mt-3">
                            <div class="rounded-lg border border-hairline bg-gray-50 p-4 space-y-3">
                                <div class="grid gap-3 sm:grid-cols-2">
                                    <div>
                                        <label class="mb-1 block text-xs font-medium text-ink">লেবেল</label>
                                        <input type="text" id="footerLinkLabel" placeholder="মেনু টেক্সট"
                                            class="w-full rounded-md border border-hairline bg-white px-3 py-2 text-sm text-ink outline-none focus:border-brand focus:ring-1 focus:ring-brand/20">
                                    </div>
                                    <div>
                                        <label class="mb-1 block text-xs font-medium text-ink">লিংক</label>
                                        <input type="text" id="footerLinkUrl" placeholder="/page-slug"
                                            class="w-full rounded-md border border-hairline bg-white px-3 py-2 text-sm text-ink outline-none focus:border-brand focus:ring-1 focus:ring-brand/20">
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button type="button" id="saveFooterLink" class="inline-flex items-center gap-1.5 rounded-md bg-brand px-3 py-1.5 text-xs font-medium text-white hover:bg-brand-deep">যোগ করুন</button>
                                    <button type="button" id="cancelFooterLink" class="text-xs text-faint hover:text-ink">বাতিল করুন</button>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" id="footerMenuItemsJson" name="footer_menu_items_json" value="{{ json_encode($footerMenuItems) }}">

                        <ul id="footerMenuList" class="mt-3 space-y-2">
                            @forelse ($footerMenuItems as $index => $item)
                                <li class="footer-menu-item flex items-center gap-3 rounded-lg border border-hairline bg-white px-4 py-3 transition-colors hover:border-brand/40"
                                    data-index="{{ $index }}">
                                    <span class="sortable-handle cursor-grab text-faint hover:text-ink">
                                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M8 6a2 2 0 1 1 0 4 2 2 0 0 1 0-4zm0 6a2 2 0 1 1 0 4 2 2 0 0 1 0-4zm0 6a2 2 0 1 1 0 4 2 2 0 0 1 0-4zm8-14a2 2 0 1 1 0 4 2 2 0 0 1 0-4zm0 6a2 2 0 1 1 0 4 2 2 0 0 1 0-4zm0 6a2 2 0 1 1 0 4 2 2 0 0 1 0-4z"/></svg>
                                    </span>
                                    <input type="text" class="footer-menu-label flex-1 rounded-md border border-hairline bg-gray-50/50 px-3 py-1.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20"
                                        value="{{ $item['label'] ?? '' }}" placeholder="মেনু টেক্সট">
                                    <input type="text" class="footer-menu-url w-40 rounded-md border border-hairline bg-gray-50/50 px-3 py-1.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20"
                                        value="{{ $item['url'] ?? '/' }}" placeholder="/path">
                                    <button type="button" class="remove-footer-menu-item shrink-0 rounded-lg p-1.5 text-faint transition-colors hover:bg-red-50 hover:text-red-500" title="মুছে ফেলুন">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18M6 6l12 12"/></svg>
                                    </button>
                                </li>
                            @empty
                                <li class="py-8 text-center text-sm text-faint">কোনো মেনু আইটেম নেই। "লিংক যোগ করুন" বাটনে ক্লিক করুন।</li>
                            @endforelse
                        </ul>
                    </div>

                    {{-- Footer Copyright --}}
                    <div class="mt-6">
                        <label for="footer_copyright" class="mb-1.5 block text-sm font-medium text-ink">কপিরাইট টেক্সট</label>
                        <input type="text" id="footer_copyright" name="footer_copyright" value="{{ old('footer_copyright', $settings['footer_copyright'] ?? '') }}"
                            class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20" placeholder="© ২০২৬ উসুলি। সর্বস্বত্ব সংরক্ষিত।">
                        @error('footer_copyright')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Buttons --}}
                    <div class="flex items-center gap-3 pt-4 mt-4 border-t border-hairline">
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
            </div>

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
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.6/Sortable.min.js"></script>
    <script>
        $(function() {
            var searchUrl = '{{ route("admin.settings.posts.search") }}';
            var catSearchUrl = '{{ route("admin.settings.categories.search") }}';
            var debounceTimer;

            {{-- ========== Navbar Tab Logic ========== --}}
            if ($('#navbarList').length) {
                var sortable = new Sortable(document.getElementById('navbarList'), {
                    handle: '.sortable-handle',
                    animation: 150,
                    ghostClass: 'opacity-40',
                    onEnd: function() {
                        syncNavbarForm();
                    }
                });

                function syncNavbarForm() {
                    var items = [];
                    $('#navbarList .navbar-item').each(function() {
                        var $el = $(this);
                        var type = $el.data('type');
                        var urlMap = { home: '/', blog: '/blog', about: '/about', contact: '/contact' };
                        var $toggle = $el.find('.navbar-enabled');
                        var enabled = type === 'category' ? true : ($toggle.length ? $toggle.prop('checked') : true);
                        var item = {
                            type: type,
                            label: $el.find('.navbar-label').val(),
                            url: urlMap[type] || null,
                            category_id: $el.data('category-id') || null,
                            enabled: enabled
                        };
                        items.push(item);
                    });
                    $('#navbarItemsJson').val(JSON.stringify(items));
                }

                $('#navbarForm').on('submit', function() {
                    syncNavbarForm();
                    var items = JSON.parse($('#navbarItemsJson').val() || '[]');
                    var $form = $(this);
                    $.each(items, function(i, item) {
                        $form.append('<input type="hidden" name="navbar_items[' + i + '][type]" value="' + (item.type || '') + '">');
                        $form.append('<input type="hidden" name="navbar_items[' + i + '][label]" value="' + (item.label || '') + '">');
                        $form.append('<input type="hidden" name="navbar_items[' + i + '][url]" value="' + (item.url || '') + '">');
                        if (item.category_id) {
                            $form.append('<input type="hidden" name="navbar_items[' + i + '][category_id]" value="' + item.category_id + '">');
                        }
                        if (item.type !== 'category') {
                            $form.append('<input type="hidden" name="navbar_items[' + i + '][enabled]" value="' + (item.enabled ? '1' : '0') + '">');
                        }
                    });
                });

                var protectedTypes = [
                    { type: 'about', label: 'আমাদের সম্পর্কে', badge: 'আমাদের সম্পর্কে', badgeClass: 'bg-amber-50 text-amber-700' },
                    { type: 'contact', label: 'যোগাযোগ', badge: 'যোগাযোগ', badgeClass: 'bg-rose-50 text-rose-700' }
                ];
                var existingTypes = [];
                $('#navbarList .navbar-item').each(function() {
                    existingTypes.push($(this).data('type'));
                });
                $.each(protectedTypes, function(i, p) {
                    if (existingTypes.indexOf(p.type) === -1) {
                        var html = '<li class="navbar-item flex items-center gap-3 rounded-lg border border-hairline bg-white px-4 py-3 transition-colors hover:border-brand/40" data-type="' + p.type + '" data-category-id="">' +
                            '<span class="sortable-handle cursor-grab text-faint hover:text-ink"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M8 6a2 2 0 1 1 0 4 2 2 0 0 1 0-4zm0 6a2 2 0 1 1 0 4 2 2 0 0 1 0-4zm0 6a2 2 0 1 1 0 4 2 2 0 0 1 0-4zm8-14a2 2 0 1 1 0 4 2 2 0 0 1 0-4zm0 6a2 2 0 1 1 0 4 2 2 0 0 1 0-4zm0 6a2 2 0 1 1 0 4 2 2 0 0 1 0-4z"/></svg></span>' +
                            '<span class="shrink-0 rounded-md ' + p.badgeClass + ' px-2 py-0.5 text-xs font-medium">' + p.badge + '</span>' +
                            '<input type="text" class="navbar-label flex-1 rounded-md border border-hairline bg-gray-50/50 px-3 py-1.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20" value="' + p.label + '">' +
                            '<label class="relative inline-flex shrink-0 cursor-pointer items-center"><input type="checkbox" class="navbar-enabled sr-only peer" checked><div class="h-5 w-9 rounded-full bg-gray-200 after:absolute after:left-[2px] after:top-[2px] after:h-4 after:w-4 after:rounded-full after:bg-white after:transition-all peer-checked:bg-brand peer-checked:after:translate-x-full"></div></label>' +
                            '</li>';
                        $('#navbarList').append(html);
                    }
                });
                syncNavbarForm();

                {{-- Remove navbar item --}}
                $('#navbarList').on('click', '.remove-navbar-item', function() {
                    $(this).closest('.navbar-item').fadeOut(200, function() {
                        $(this).remove();
                        syncNavbarForm();
                    });
                });

                {{-- Add Category --}}
                var existingCatIds = [];
                $('#navbarList .navbar-item').each(function() {
                    if ($(this).data('category-id')) {
                        existingCatIds.push($(this).data('category-id'));
                    }
                });

                $('#addCategoryBtn').on('click', function() {
                    $('#addCategoryModal').removeClass('hidden');
                    $('#catSearchInput').focus();
                });

                $('#cancelAddCategory').on('click', function() {
                    $('#addCategoryModal').addClass('hidden');
                    $('#catSearchInput').val('');
                    $('#catSearchResults').addClass('hidden').empty();
                });

                $('#catSearchInput').on('keyup', function() {
                    var q = $(this).val().trim();
                    clearTimeout(debounceTimer);
                    if (q.length < 1) {
                        $('#catSearchResults').addClass('hidden').empty();
                        return;
                    }
                    debounceTimer = setTimeout(function() {
                        $.get(catSearchUrl, { q: q, existing: existingCatIds }, function(data) {
                            var $results = $('#catSearchResults');
                            $results.empty();
                            if (data.length === 0) {
                                $results.append('<div class="px-4 py-3 text-sm text-faint">কোনো ক্যাটাগরি পাওয়া যায়নি।</div>');
                            } else {
                                $.each(data, function(i, cat) {
                                    $results.append(
                                        '<div class="flex items-center gap-3 px-4 py-3 cursor-pointer transition-colors hover:bg-gray-50 cat-select-item" data-id="' + cat.id + '" data-name="' + cat.name.replace(/"/g, '&quot;') + '">' +
                                        '<span class="shrink-0 rounded-md bg-purple-50 px-2 py-0.5 text-xs font-medium text-purple-700">ক্যাটাগরি</span>' +
                                        '<span class="text-sm font-medium text-ink">' + cat.name + '</span>' +
                                        '</div>'
                                    );
                                });
                            }
                            $results.removeClass('hidden');
                        });
                    }, 300);
                });

                $('#catSearchResults').on('click', '.cat-select-item', function() {
                    var id = $(this).data('id');
                    var name = $(this).data('name');
                    var index = $('#navbarList .navbar-item').length;

                    var html = '<li class="navbar-item flex items-center gap-3 rounded-lg border border-hairline bg-white px-4 py-3 transition-colors hover:border-brand/40" data-type="category" data-category-id="' + id + '" data-index="' + index + '">' +
                        '<span class="sortable-handle cursor-grab text-faint hover:text-ink"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M8 6a2 2 0 1 1 0 4 2 2 0 0 1 0-4zm0 6a2 2 0 1 1 0 4 2 2 0 0 1 0-4zm0 6a2 2 0 1 1 0 4 2 2 0 0 1 0-4zm8-14a2 2 0 1 1 0 4 2 2 0 0 1 0-4zm0 6a2 2 0 1 1 0 4 2 2 0 0 1 0-4zm0 6a2 2 0 1 1 0 4 2 2 0 0 1 0-4z"/></svg></span>' +
                        '<span class="shrink-0 rounded-md bg-purple-50 px-2 py-0.5 text-xs font-medium text-purple-700">ক্যাটাগরি</span>' +
                        '<input type="text" class="navbar-label flex-1 rounded-md border border-hairline bg-gray-50/50 px-3 py-1.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20" value="' + name + '">' +
                        '<button type="button" class="remove-navbar-item shrink-0 rounded-lg p-1.5 text-faint transition-colors hover:bg-red-50 hover:text-red-500" title="মুছে ফেলুন"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18M6 6l12 12"/></svg></button>' +
                        '</li>';

                    $('#navbarList').append(html);
                    existingCatIds.push(id);

                    $('#catSearchInput').val('');
                    $('#catSearchResults').addClass('hidden').empty();
                    $('#addCategoryModal').addClass('hidden');
                    syncNavbarForm();
                });

                $(document).on('click', function(e) {
                    if (!$(e.target).closest('#catSearchInput').length && !$(e.target).closest('#catSearchResults').length) {
                        $('#catSearchResults').addClass('hidden');
                    }
                });

                $('#navbarList').on('change', '.navbar-enabled', function() {
                    syncNavbarForm();
                });
            }

            {{-- ========== Site Logo Preview ========== --}}
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

            {{-- ========== Footer Menu Logic ========== --}}
            if ($('#footerMenuList').length) {
                var footerSortable = new Sortable(document.getElementById('footerMenuList'), {
                    handle: '.sortable-handle',
                    animation: 150,
                    ghostClass: 'opacity-40',
                    onEnd: function() {
                        syncFooterForm();
                    }
                });

                function syncFooterForm() {
                    var items = [];
                    $('#footerMenuList .footer-menu-item').each(function() {
                        var $el = $(this);
                        items.push({
                            label: $el.find('.footer-menu-label').val(),
                            url: $el.find('.footer-menu-url').val()
                        });
                    });
                    $('#footerMenuItemsJson').val(JSON.stringify(items));
                }

                $('#footerForm').on('submit', function() {
                    syncFooterForm();
                    var items = JSON.parse($('#footerMenuItemsJson').val() || '[]');
                    var $form = $(this);
                    $.each(items, function(i, item) {
                        $form.append('<input type="hidden" name="footer_menu_items[' + i + '][label]" value="' + (item.label || '') + '">');
                        $form.append('<input type="hidden" name="footer_menu_items[' + i + '][url]" value="' + (item.url || '') + '">');
                    });
                });

                $('#footerMenuList').on('click', '.remove-footer-menu-item', function() {
                    $(this).closest('.footer-menu-item').fadeOut(200, function() {
                        $(this).remove();
                        syncFooterForm();
                    });
                });

                $('#addFooterLinkBtn').on('click', function() {
                    $('#addFooterLinkModal').removeClass('hidden');
                    $('#footerLinkLabel').focus();
                });

                $('#cancelFooterLink').on('click', function() {
                    $('#addFooterLinkModal').addClass('hidden');
                    $('#footerLinkLabel').val('');
                    $('#footerLinkUrl').val('');
                });

                $('#saveFooterLink').on('click', function() {
                    var label = $('#footerLinkLabel').val().trim();
                    var url = $('#footerLinkUrl').val().trim() || '/';
                    if (!label) {
                        $('#footerLinkLabel').focus();
                        return;
                    }

                    var index = $('#footerMenuList .footer-menu-item').length;
                    var html = '<li class="footer-menu-item flex items-center gap-3 rounded-lg border border-hairline bg-white px-4 py-3 transition-colors hover:border-brand/40" data-index="' + index + '">' +
                        '<span class="sortable-handle cursor-grab text-faint hover:text-ink"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M8 6a2 2 0 1 1 0 4 2 2 0 0 1 0-4zm0 6a2 2 0 1 1 0 4 2 2 0 0 1 0-4zm0 6a2 2 0 1 1 0 4 2 2 0 0 1 0-4zm8-14a2 2 0 1 1 0 4 2 2 0 0 1 0-4zm0 6a2 2 0 1 1 0 4 2 2 0 0 1 0-4zm0 6a2 2 0 1 1 0 4 2 2 0 0 1 0-4z"/></svg></span>' +
                        '<input type="text" class="footer-menu-label flex-1 rounded-md border border-hairline bg-gray-50/50 px-3 py-1.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20" value="' + label.replace(/"/g, '&quot;') + '">' +
                        '<input type="text" class="footer-menu-url w-40 rounded-md border border-hairline bg-gray-50/50 px-3 py-1.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20" value="' + url.replace(/"/g, '&quot;') + '">' +
                        '<button type="button" class="remove-footer-menu-item shrink-0 rounded-lg p-1.5 text-faint transition-colors hover:bg-red-50 hover:text-red-500" title="মুছে ফেলুন"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18M6 6l12 12"/></svg></button>' +
                        '</li>';

                    $('#footerMenuList').append(html);
                    syncFooterForm();

                    $('#footerLinkLabel').val('');
                    $('#footerLinkUrl').val('');
                    $('#addFooterLinkModal').addClass('hidden');
                });
            }
        });

            {{-- ========== About Values Logic ========== --}}
            if ($('#valuesList').length) {
                function syncValuesForm() {
                    var items = [];
                    $('#valuesList .value-item').each(function() {
                        var $el = $(this);
                        items.push({
                            title: $el.find('.value-title').val(),
                            description: $el.find('.value-description').val(),
                            icon: $el.find('.value-icon').val()
                        });
                    });
                    $('#aboutValuesJson').val(JSON.stringify(items));
                }

                $('#aboutForm, form').last().on('submit', function() {
                    if ($('#valuesList').length) {
                        syncValuesForm();
                        var items = JSON.parse($('#aboutValuesJson').val() || '[]');
                        var $form = $(this);
                        $.each(items, function(i, item) {
                            $form.append('<input type="hidden" name="about_values[' + i + '][title]" value="' + (item.title || '').replace(/"/g, '&quot;') + '">');
                            $form.append('<input type="hidden" name="about_values[' + i + '][description]" value="' + (item.description || '').replace(/"/g, '&quot;') + '">');
                            $form.append('<input type="hidden" name="about_values[' + i + '][icon]" value="' + (item.icon || 'book') + '">');
                        });
                    }
                });

                $('#valuesList').on('click', '.remove-value-item', function() {
                    $(this).closest('.value-item').fadeOut(200, function() {
                        $(this).remove();
                        syncValuesForm();
                    });
                });

                $('#addValueBtn').on('click', function() {
                    var index = $('#valuesList .value-item').length;
                    var html = '<li class="value-item rounded-lg border border-hairline bg-white px-4 py-4 transition-colors hover:border-brand/40" data-index="' + index + '">' +
                        '<div class="grid gap-3 sm:grid-cols-2">' +
                        '<div><label class="mb-1 block text-xs font-medium text-ink">শিরোনাম</label>' +
                        '<input type="text" class="value-title w-full rounded-md border border-hairline bg-gray-50/50 px-3 py-1.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20" value="" placeholder="মূল্যবোধের নাম"></div>' +
                        '<div><label class="mb-1 block text-xs font-medium text-ink">আইকন</label>' +
                        '<select class="value-icon w-full rounded-md border border-hairline bg-gray-50/50 px-3 py-1.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20">' +
                        '<option value="book">বই (book)</option><option value="users">ব্যক্তি (users)</option><option value="globe">গ্লোব (globe)</option>' +
                        '<option value="heart">হৃদয় (heart)</option><option value="star">তারা (star)</option><option value="lightbulb">বাতি (lightbulb)</option></select></div>' +
                        '</div>' +
                        '<div class="mt-3"><label class="mb-1 block text-xs font-medium text-ink">বিবরণ</label>' +
                        '<textarea class="value-description w-full rounded-md border border-hairline bg-gray-50/50 px-3 py-1.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20" rows="2" placeholder="মূল্যবোধের বিবরণ"></textarea></div>' +
                        '<div class="mt-2 flex justify-end"><button type="button" class="remove-value-item rounded-lg p-1.5 text-faint transition-colors hover:bg-red-50 hover:text-red-500" title="মুছে ফেলুন">' +
                        '<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18M6 6l12 12"/></svg></button></div></li>';

                    $('#valuesList').append(html);
                    syncValuesForm();
                });

                $('#valuesList').on('change', '.value-title, .value-description, .value-icon', function() {
                    syncValuesForm();
                });

                syncValuesForm();
            }

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
