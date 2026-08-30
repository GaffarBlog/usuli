@extends('admin.layouts.app')

@section('title', 'প্রোফাইল — উসুলি অ্যাডমিন')

@section('content')
    <div class="space-y-6">
        {{-- Breadcrumbs --}}
        <nav class="flex items-center gap-2 text-sm text-faint">
            <a href="{{ route('admin.dashboard.view') }}" class="transition-colors hover:text-brand">ড্যাশবোর্ড</a>
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M9 18l6-6-6-6" />
            </svg>
            <span class="text-ink">প্রোফাইল</span>
        </nav>

        {{-- Header --}}
        <h1 class="text-2xl font-semibold text-ink">প্রোফাইল</h1>

        {{-- Flash Message --}}
        @if (session('success'))
            <div id="flash-message" class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        {{-- Profile Info + Photo Form --}}
        <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data" class="space-y-6 rounded-xl border border-hairline bg-white p-6">
            @csrf
            @method('PUT')

            <h2 class="text-lg font-semibold text-ink">তথ্য আপডেট করুন</h2>

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
                {{-- Username --}}
                <div>
                    <label for="username" class="mb-1.5 block text-sm font-medium text-ink">
                        ইউজারনেম <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="username" name="username" value="{{ old('username', $user->username) }}" required
                        class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20" placeholder="ইউজারনেম লিখুন">
                    @error('username')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Phone --}}
                <div>
                    <label for="phone" class="mb-1.5 block text-sm font-medium text-ink">ফোন</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                        class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20" placeholder="০১XXXXXXXXX">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                {{-- Date of Birth --}}
                <div>
                    <label for="date_of_birth" class="mb-1.5 block text-sm font-medium text-ink">জন্ম তারিখ</label>
                    <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $user->date_of_birth) }}"
                        class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20">
                    @error('date_of_birth')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Gender --}}
                <div>
                    <label for="gender" class="mb-1.5 block text-sm font-medium text-ink">লিঙ্গ</label>
                    <select id="gender" name="gender"
                        class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20">
                        <option value="">নির্বাচন করুন</option>
                        <option value="Male" {{ old('gender', $user->gender) === 'Male' ? 'selected' : '' }}>পুরুষ</option>
                        <option value="Female" {{ old('gender', $user->gender) === 'Female' ? 'selected' : '' }}>নারী</option>
                        <option value="Third Gender" {{ old('gender', $user->gender) === 'Third Gender' ? 'selected' : '' }}>অন্যান্য</option>
                    </select>
                    @error('gender')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                {{-- Country --}}
                <div>
                    <label for="country" class="mb-1.5 block text-sm font-medium text-ink">দেশ</label>
                    <input type="text" id="country" name="country" value="{{ old('country', $user->country) }}"
                        class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20" placeholder="দেশের নাম">
                    @error('country')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- City --}}
                <div>
                    <label for="city" class="mb-1.5 block text-sm font-medium text-ink">শহর</label>
                    <input type="text" id="city" name="city" value="{{ old('city', $user->city) }}"
                        class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20" placeholder="শহরের নাম">
                    @error('city')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                {{-- Zip --}}
                <div>
                    <label for="zip" class="mb-1.5 block text-sm font-medium text-ink">পোস্ট কোড</label>
                    <input type="text" id="zip" name="zip" value="{{ old('zip', $user->zip) }}" maxlength="10"
                        class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20" placeholder="পোস্ট কোড">
                    @error('zip')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Address --}}
            <div>
                <label for="address" class="mb-1.5 block text-sm font-medium text-ink">ঠিকানা</label>
                <textarea id="address" name="address" rows="3"
                    class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20"
                    placeholder="সম্পূর্ণ ঠিকানা">{{ old('address', $user->address) }}</textarea>
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

        {{-- Password Change Form --}}
        <form method="POST" action="{{ route('admin.profile.password') }}" class="space-y-6 rounded-xl border border-hairline bg-white p-6">
            @csrf
            @method('PUT')

            <h2 class="text-lg font-semibold text-ink">পাসওয়ার্ড পরিবর্তন করুন</h2>

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
