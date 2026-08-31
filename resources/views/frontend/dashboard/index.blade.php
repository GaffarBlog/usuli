@extends('frontend.dashboard.layout')

@section('title', 'ড্যাশবোর্ড — উসুলি')

@section('tab-content')
    <div class="space-y-6">
        {{-- Welcome --}}
        <div class="rounded-xl border border-hairline bg-white p-6">
            <h3 class="text-lg font-semibold text-ink">স্বাগতম, {{ $user->name }}!</h3>
            <p class="mt-1 text-sm text-faint">এখান থেকে আপনার অ্যাকাউন্ট পরিচালনা করতে পারবেন।</p>
        </div>

        {{-- Stats --}}
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            {{-- Account Status --}}
            <div class="rounded-xl border border-hairline bg-white p-5">
                <div class="flex items-center gap-3">
                    <div class="grid h-12 w-12 place-items-center rounded-xl bg-brand/10 text-brand">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-faint">অ্যাকাউন্ট</p>
                        <p class="text-base font-semibold text-ink">সক্রিয়</p>
                    </div>
                </div>
            </div>

            {{-- Writer Status --}}
            <div class="rounded-xl border border-hairline bg-white p-5">
                <div class="flex items-center gap-3">
                    <div class="grid h-12 w-12 place-items-center rounded-xl {{ $user->is_writer ? 'bg-emerald-50 text-emerald-600' : 'bg-gray-100 text-gray-500' }}">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 20h9" />
                            <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-faint">লেখক স্ট্যাটাস</p>
                        <p class="text-base font-semibold text-ink">
                            @if ($user->is_writer)
                                সক্রিয় লেখক
                            @elseif ($user->writer_request_status === 'pending')
                                অনুরোধ পর্যালোচনাধীন
                            @elseif ($user->writer_request_status === 'rejected')
                                অনুরোধ প্রত্যাখ্যাত
                            @else
                                সাধারণ পাঠক
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            {{-- Quick Action --}}
            <div class="rounded-xl border border-hairline bg-white p-5 sm:col-span-2 lg:col-span-1">
                <div class="flex items-center gap-3">
                    <div class="grid h-12 w-12 place-items-center rounded-xl bg-brand-deep/10 text-brand-deep">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="8" x2="12" y2="16" />
                            <line x1="8" y1="12" x2="16" y2="12" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-faint">দ্রুত কাজ</p>
                        @if (!$user->is_writer && $user->writer_request_status !== 'pending')
                            <a href="{{ route('frontend.dashboard.writer') }}" class="text-base font-semibold text-brand hover:text-brand-deep transition-colors">লেখক হতে চাই</a>
                        @else
                            <a href="{{ route('frontend.dashboard.profile') }}" class="text-base font-semibold text-brand hover:text-brand-deep transition-colors">প্রোফাইল আপডেট</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Writer Request Pending Notice --}}
        @if ($user->writer_request_status === 'pending')
            <div class="rounded-xl border border-amber-200 bg-amber-50 p-5">
                <div class="flex items-start gap-3">
                    <div class="grid h-10 w-10 shrink-0 place-items-center rounded-lg bg-amber-100 text-amber-600">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="8" x2="12" y2="12" />
                            <line x1="12" y1="16" x2="12.01" y2="16" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-amber-800">লেখক অনুরোধ পর্যালোচনাধীন</h4>
                        <p class="mt-1 text-sm text-amber-700">আপনার লেখক অনুরোধ অ্যাডমিন পর্যালোচনা করছেন। অনুগ্রহ করে অপেক্ষা করুন।</p>
                    </div>
                </div>
            </div>
        @endif

        {{-- Quick Links --}}
        <div class="rounded-xl border border-hairline bg-white p-6">
            <h3 class="text-lg font-semibold text-ink mb-4">দ্রুত লিঙ্ক</h3>
            <div class="grid gap-4 sm:grid-cols-2">
                <a href="{{ route('frontend.dashboard.profile') }}" class="flex items-center gap-3 rounded-lg border border-hairline p-4 transition-colors hover:border-brand hover:bg-brand/5">
                    <svg class="h-5 w-5 text-brand" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-ink">প্রোফাইল সম্পাদনা</p>
                        <p class="text-xs text-faint">আপনার তথ্য আপডেট করুন</p>
                    </div>
                </a>
                <a href="{{ route('frontend.dashboard.writer') }}" class="flex items-center gap-3 rounded-lg border border-hairline p-4 transition-colors hover:border-brand hover:bg-brand/5">
                    <svg class="h-5 w-5 text-brand" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 20h9" />
                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z" />
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-ink">লেখক অনুরোধ</p>
                        <p class="text-xs text-faint">উসুলিতে লেখক হিসেবে যোগ দিন</p>
                    </div>
                </a>
                <a href="{{ route('blog') }}" class="flex items-center gap-3 rounded-lg border border-hairline p-4 transition-colors hover:border-brand hover:bg-brand/5">
                    <svg class="h-5 w-5 text-brand" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z" />
                        <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z" />
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-ink">গল্প পড়ুন</p>
                        <p class="text-xs text-faint">সকল প্রকাশিত গল্প দেখুন</p>
                    </div>
                </a>
                <a href="{{ route('home.index') }}" class="flex items-center gap-3 rounded-lg border border-hairline p-4 transition-colors hover:border-brand hover:bg-brand/5">
                    <svg class="h-5 w-5 text-brand" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                        <polyline points="9 22 9 12 15 12 15 22" />
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-ink">প্রচ্ছদ</p>
                        <p class="text-xs text-faint">মূল পাতায় ফিরে যান</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection
