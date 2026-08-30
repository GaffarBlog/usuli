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
        });
    </script>
    @endpush
@endsection
