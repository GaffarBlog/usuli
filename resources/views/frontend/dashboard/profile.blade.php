@extends('frontend.dashboard.layout')

@section('title', 'প্রোফাইল — উসুলি')

@section('tab-content')
    <div class="space-y-6">
        {{-- Profile Info Form --}}
        <form method="POST" action="{{ route('frontend.dashboard.profile.update') }}" enctype="multipart/form-data" class="space-y-6 rounded-xl border border-hairline bg-white p-6">
            @csrf

            <h3 class="text-lg font-semibold text-ink">তথ্য আপডেট করুন</h3>

            {{-- Avatar --}}
            <div>
                <label for="avatar" class="mb-1.5 block text-sm font-medium text-ink">প্রোফাইল ছবি</label>
                <div class="flex items-center gap-4">
                    <div class="shrink-0">
                        @if (!empty($user->images))
                            <img id="avatarPreview" src="{{ $user->images }}" alt="{{ $user->name }}" class="h-20 w-20 rounded-full object-cover">
                        @else
                            <span id="avatarPreview" class="grid h-20 w-20 place-items-center rounded-full bg-linear-160 from-brand to-brand-deep font-serif text-2xl font-semibold text-white">
                                {{ mb_substr($user->name, 0, 1, 'UTF-8') }}
                            </span>
                        @endif
                    </div>
                    <div class="flex-1">
                        <input type="file" id="avatar" name="avatar" accept="image/*"
                            class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20 file:mr-3 file:rounded-lg file:border-0 file:bg-brand/10 file:px-3 file:py-1.5 file:text-sm file:font-medium file:text-brand hover:file:bg-brand/20">
                        <p class="mt-1 text-xs text-faint">JPG, PNG অথবা WebP। সর্বোচ্চ 2MB।</p>
                    </div>
                </div>
                @error('avatar')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                {{-- Name --}}
                <div>
                    <label for="name" class="mb-1.5 block text-sm font-medium text-ink">
                        নাম <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                        class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20" placeholder="পুরো নাম লিখুন">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="mb-1.5 block text-sm font-medium text-ink">
                        ইমেইল <span class="text-red-500">*</span>
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                        class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20" placeholder="user@example.com">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                {{-- Phone --}}
                <div>
                    <label for="phone" class="mb-1.5 block text-sm font-medium text-ink">ফোন</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                        class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20" placeholder="০১XXXXXXXXX">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Writer Badge --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-ink">লেখক স্ট্যাটাস</label>
                    <div class="flex items-center gap-2 rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5">
                        @if ($user->is_writer)
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-3 py-1 text-xs font-medium text-emerald-700">
                                <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12" />
                                </svg>
                                সক্রিয় লেখক
                            </span>
                        @elseif ($user->writer_request_status === 'pending')
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-100 px-3 py-1 text-xs font-medium text-amber-700">
                                <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10" />
                                    <line x1="12" y1="8" x2="12" y2="12" />
                                    <line x1="12" y1="16" x2="12.01" y2="16" />
                                </svg>
                                পর্যালোচনাধীন
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600">
                                সাধারণ পাঠক
                            </span>
                        @endif
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

        {{-- Password Change Form --}}
        <form method="POST" action="{{ route('frontend.dashboard.password.update') }}" class="space-y-6 rounded-xl border border-hairline bg-white p-6">
            @csrf

            <h3 class="text-lg font-semibold text-ink">পাসওয়ার্ড পরিবর্তন করুন</h3>

            <div class="grid gap-6 sm:grid-cols-2">
                {{-- Current Password --}}
                <div>
                    <label for="current_password" class="mb-1.5 block text-sm font-medium text-ink">
                        বর্তমান পাসওয়ার্ড <span class="text-red-500">*</span>
                    </label>
                    <input type="password" id="current_password" name="current_password" required
                        class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20" placeholder="বর্তমান পাসওয়ার্ড লিখুন">
                    @error('current_password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                {{-- New Password --}}
                <div>
                    <label for="password" class="mb-1.5 block text-sm font-medium text-ink">
                        নতুন পাসওয়ার্ড <span class="text-red-500">*</span>
                    </label>
                    <input type="password" id="password" name="password" required minlength="6"
                        class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20" placeholder="নতুন পাসওয়ার্ড লিখুন">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password Confirmation --}}
                <div>
                    <label for="password_confirmation" class="mb-1.5 block text-sm font-medium text-ink">
                        পাসওয়ার্ড নিশ্চিত করুন <span class="text-red-500">*</span>
                    </label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required minlength="6"
                        class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20" placeholder="পাসওয়ার্ড আবার লিখুন">
                </div>
            </div>

            {{-- Buttons --}}
            <div class="flex items-center gap-3 pt-4 border-t border-hairline">
                <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-brand px-5 py-2.5 text-sm font-medium text-white transition-colors hover:bg-brand-deep">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                    </svg>
                    পাসওয়ার্ড পরিবর্তন করুন
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        $(function() {
            $('#avatar').on('change', function(e) {
                var file = e.target.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(ev) {
                        var $preview = $('#avatarPreview');
                        if ($preview.is('span')) {
                            var $img = $('<img>').attr({
                                id: 'avatarPreview',
                                src: ev.target.result,
                                alt: 'প্রোফাইল',
                                'class': 'h-20 w-20 rounded-full object-cover'
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
