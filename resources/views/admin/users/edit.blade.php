@extends('admin.layouts.app')

@section('title', 'সদস্য সম্পাদনা — উসুলি অ্যাডমিন')

@section('content')
    <div class="space-y-6">
        {{-- Breadcrumbs --}}
        <nav class="flex items-center gap-2 text-sm text-faint">
            <a href="{{ route('admin.users.view') }}" class="transition-colors hover:text-brand">সব সদস্য</a>
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M9 18l6-6-6-6" />
            </svg>
            <span class="text-ink">সদস্য সম্পাদনা</span>
        </nav>

        {{-- Header --}}
        <h1 class="text-2xl font-semibold text-ink">সদস্য সম্পাদনা</h1>

        {{-- Form --}}
        <form method="POST" action="{{ route('admin.users.update') }}" enctype="multipart/form-data" class="space-y-6 rounded-xl border border-hairline bg-white p-6">
            @csrf
            <input type="hidden" name="id" value="{{ $user->id }}">

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

                {{-- Role --}}
                <div>
                    <label for="role_id" class="mb-1.5 block text-sm font-medium text-ink">
                        ভূমিকা <span class="text-red-500">*</span>
                    </label>
                    <select id="role_id" name="role_id" required
                        class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20">
                        <option value="">ভূমিকা নির্বাচন করুন</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('role_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                {{-- Password --}}
                <div>
                    <label for="password" class="mb-1.5 block text-sm font-medium text-ink">
                        পাসওয়ার্ড
                    </label>
                    <input type="password" id="password" name="password" minlength="6"
                        class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20"
                        placeholder="খালি রাখলে পরিবর্তন হবে না">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password Confirmation --}}
                <div>
                    <label for="password_confirmation" class="mb-1.5 block text-sm font-medium text-ink">
                        পাসওয়ার্ড নিশ্চিত করুন
                    </label>
                    <input type="password" id="password_confirmation" name="password_confirmation" minlength="6"
                        class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20" placeholder="পাসওয়ার্ড আবার লিখুন">
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                {{-- Status --}}
                <div>
                    <label for="status" class="mb-1.5 block text-sm font-medium text-ink">
                        অবস্থা <span class="text-red-500">*</span>
                    </label>
                    <select id="status" name="status" required
                        class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20">
                        <option value="Active" {{ old('status', $user->status) === 'Active' ? 'selected' : '' }}>সক্রিয়</option>
                        <option value="Inactive" {{ old('status', $user->status) === 'Inactive' ? 'selected' : '' }}>নিষ্ক্রিয়</option>
                        <option value="Banned" {{ old('status', $user->status) === 'Banned' ? 'selected' : '' }}>নিষিদ্ধ</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Phone --}}
                <div>
                    <label for="phone" class="mb-1.5 block text-sm font-medium text-ink">
                        ফোন
                    </label>
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
                    <label for="date_of_birth" class="mb-1.5 block text-sm font-medium text-ink">
                        জন্ম তারিখ
                    </label>
                    <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $user->date_of_birth) }}"
                        class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20">
                    @error('date_of_birth')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Gender --}}
                <div>
                    <label for="gender" class="mb-1.5 block text-sm font-medium text-ink">
                        লিঙ্গ
                    </label>
                    <select id="gender" name="gender" class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20">
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
                    <label for="country" class="mb-1.5 block text-sm font-medium text-ink">
                        দেশ
                    </label>
                    <input type="text" id="country" name="country" value="{{ old('country', $user->country) }}"
                        class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20" placeholder="দেশের নাম">
                    @error('country')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- City --}}
                <div>
                    <label for="city" class="mb-1.5 block text-sm font-medium text-ink">
                        শহর
                    </label>
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
                    <label for="zip" class="mb-1.5 block text-sm font-medium text-ink">
                        পোস্ট কোড
                    </label>
                    <input type="text" id="zip" name="zip" value="{{ old('zip', $user->zip) }}" maxlength="10"
                        class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20" placeholder="পোস্ট কোড">
                    @error('zip')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Avatar --}}
                <div>
                    <label for="avatar" class="mb-1.5 block text-sm font-medium text-ink">
                        ছবি
                    </label>
                    @if (!empty($user->images))
                        <div class="mb-2">
                            <img src="{{ $user->images }}" alt="{{ $user->name }}" class="h-16 w-16 rounded-lg object-cover">
                        </div>
                    @endif
                    <input type="file" id="avatar" name="avatar" accept="image/*"
                        class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20">
                    @error('avatar')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Address --}}
            <div>
                <label for="address" class="mb-1.5 block text-sm font-medium text-ink">
                    ঠিকানা
                </label>
                <textarea id="address" name="address" rows="3" class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20"
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
                    আপডেট করুন
                </button>
                <a href="{{ route('admin.users.view') }}" class="rounded-lg border border-hairline px-5 py-2.5 text-sm font-medium text-faint transition-colors hover:bg-gray-50">
                    বাতিল
                </a>
            </div>
        </form>
    </div>
@endsection
