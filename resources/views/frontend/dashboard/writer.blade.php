@extends('frontend.dashboard.layout')

@section('title', 'লেখক অনুরোধ — উসুলি')

@section('tab-content')
    <div class="space-y-6">
        {{-- Current Status --}}
        <div class="rounded-xl border border-hairline bg-white p-6">
            <h3 class="text-lg font-semibold text-ink mb-4">আপনার লেখক স্ট্যাটাস</h3>

            <div class="flex items-center gap-4">
                @if ($user->is_writer)
                    <span class="inline-flex items-center gap-2 rounded-full bg-emerald-100 px-4 py-2 text-sm font-medium text-emerald-700">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12" />
                        </svg>
                        আপনি একজন সক্রিয় লেখক
                    </span>
                @elseif ($user->writer_request_status === 'pending')
                    <div class="space-y-2">
                        <span class="inline-flex items-center gap-2 rounded-full bg-amber-100 px-4 py-2 text-sm font-medium text-amber-700">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="12" y1="8" x2="12" y2="12" />
                                <line x1="12" y1="16" x2="12.01" y2="16" />
                            </svg>
                            অনুরোধ পর্যালোচনাধীন
                        </span>
                        @if ($user->writer_request_reason)
                            <div class="rounded-lg bg-gray-50 p-4 mt-3">
                                <p class="text-xs font-medium text-faint mb-1">আপনার প্রেরিত কারণ:</p>
                                <p class="text-sm text-body">{{ $user->writer_request_reason }}</p>
                            </div>
                        @endif
                        @if ($user->writer_requested_at)
                            <p class="text-xs text-faint">জমা দেওয়া হয়েছে: {{ $user->writer_requested_at->diffForHumans() }}</p>
                        @endif
                    </div>
                @elseif ($user->writer_request_status === 'rejected')
                    <div class="space-y-3">
                        <span class="inline-flex items-center gap-2 rounded-full bg-red-100 px-4 py-2 text-sm font-medium text-red-700">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="15" y1="9" x2="9" y2="15" />
                                <line x1="9" y1="9" x2="15" y2="15" />
                            </svg>
                            আপনার পূর্ববর্তী অনুরোধ প্রত্যাখ্যাত হয়েছে
                        </span>
                        <p class="text-sm text-body">আপনি নতুন করে অনুরোধ জমা দিতে পারেন।</p>
                    </div>
                @else
                    <div>
                        <span class="inline-flex items-center gap-2 rounded-full bg-gray-100 px-4 py-2 text-sm font-medium text-gray-600">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                            সাধারণ পাঠক
                        </span>
                        <p class="mt-2 text-sm text-body">আপনি এখনো লেখক নন। নিচের ফর্ম পূরণ করে লেখক হতে আবেদন করুন।</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Writer Request Form --}}
        @if (!$user->is_writer && $user->writer_request_status !== 'pending')
            <form method="POST" action="{{ route('frontend.dashboard.writer.submit') }}" class="space-y-6 rounded-xl border border-hairline bg-white p-6">
                @csrf

                <div>
                    <h3 class="text-lg font-semibold text-ink">লেখক অনুরোধ জমা দিন</h3>
                    <p class="mt-1 text-sm text-faint">উসুলিতে লেখক হিসেবে যোগ দিতে নিচের ফর্মটি পূরণ করুন। অ্যাডমিন আপনার অনুরোধ পর্যালোচনা করবেন।</p>
                </div>

                {{-- Writer Benefits --}}
                <div class="rounded-lg bg-brand/5 border border-brand/20 p-5">
                    <h4 class="text-sm font-semibold text-brand-deep mb-3">লেখক হওয়ার সুবিধা:</h4>
                    <ul class="space-y-2 text-sm text-body">
                        <li class="flex items-start gap-2">
                            <svg class="h-4 w-4 mt-0.5 shrink-0 text-brand" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12" />
                            </svg>
                            নিজের গল্প, কবিতা ও প্রবন্ধ প্রকাশ করতে পারবেন
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="h-4 w-4 mt-0.5 shrink-0 text-brand" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12" />
                            </svg>
                            আপনার প্রোফাইলে "লেখক" ব্যাজ পাবেন
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="h-4 w-4 mt-0.5 shrink-0 text-brand" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12" />
                            </svg>
                            পাঠকদের সাথে সরাসরি যুক্ত হতে পারবেন
                        </li>
                    </ul>
                </div>

                {{-- Reason --}}
                <div>
                    <label for="reason" class="mb-1.5 block text-sm font-medium text-ink">
                        কেন আপনি লেখক হতে চান? <span class="text-red-500">*</span>
                    </label>
                    <textarea id="reason" name="reason" rows="5" required minlength="20" maxlength="1000"
                        class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-3 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20"
                        placeholder="আপনার লেখালেখির অভিজ্ঞতা, আগ্রহ এবং কেন আপনি উসুলিতে লেখক হতে চান তা বিস্তারিত লিখুন...">{{ old('reason') }}</textarea>
                    <div class="mt-1.5 flex items-center justify-between">
                        @error('reason')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @else
                            <p class="text-xs text-faint">সর্বনিম্ন ২০ অক্ষর</p>
                        @enderror
                        <p class="text-xs text-faint"><span id="charCount">0</span>/১০০০</p>
                    </div>
                </div>

                {{-- Submit --}}
                <div class="flex items-center gap-3 pt-4 border-t border-hairline">
                    <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-brand px-6 py-2.5 text-sm font-medium text-white transition-colors hover:bg-brand-deep">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="22" y1="2" x2="11" y2="13" />
                            <polygon points="22 2 15 22 11 13 2 9 22 2" />
                        </svg>
                        অনুরোধ জমা দিন
                    </button>
                </div>
            </form>
        @endif
    </div>

    @push('scripts')
    <script>
        $(function() {
            var $textarea = $('#reason');
            var $charCount = $('#charCount');

            function updateCount() {
                $charCount.text($textarea.val().length);
            }

            $textarea.on('input', updateCount);
            updateCount();
        });
    </script>
    @endpush
@endsection
