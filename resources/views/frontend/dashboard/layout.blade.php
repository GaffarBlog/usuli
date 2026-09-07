@extends('layouts.main')

@section('content')
    @php
        $currentRoute = request()->route()?->getName() ?? '';
    @endphp

    {{-- Dashboard Tab Navigation --}}
    <div class="border-b border-hairline bg-[rgba(250,250,248,0.6)]">
        <div class="shell">
            <nav class="flex gap-1 overflow-x-auto -mb-px" aria-label="ড্যাশবোর্ড ট্যাব">
                <a href="{{ route('frontend.dashboard.index') }}"
                    class="inline-flex items-center gap-2 whitespace-nowrap border-b-2 px-5 py-4 text-sm font-medium transition-colors duration-200 {{ $currentRoute === 'frontend.dashboard.index' ? 'border-brand text-brand-deep' : 'border-transparent text-faint hover:border-hairline hover:text-ink' }}">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="7" rx="1" />
                        <rect x="14" y="3" width="7" height="7" rx="1" />
                        <rect x="3" y="14" width="7" height="7" rx="1" />
                        <rect x="14" y="14" width="7" height="7" rx="1" />
                    </svg>
                    ড্যাশবোর্ড
                </a>
                <a href="{{ route('frontend.dashboard.profile') }}"
                    class="inline-flex items-center gap-2 whitespace-nowrap border-b-2 px-5 py-4 text-sm font-medium transition-colors duration-200 {{ $currentRoute === 'frontend.dashboard.profile' ? 'border-brand text-brand-deep' : 'border-transparent text-faint hover:border-hairline hover:text-ink' }}">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                    প্রোফাইল
                </a>
                <a href="{{ route('frontend.dashboard.writer') }}"
                    class="inline-flex items-center gap-2 whitespace-nowrap border-b-2 px-5 py-4 text-sm font-medium transition-colors duration-200 {{ $currentRoute === 'frontend.dashboard.writer' ? 'border-brand text-brand-deep' : 'border-transparent text-faint hover:border-hairline hover:text-ink' }}">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 20h9" />
                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z" />
                    </svg>
                    লেখক অনুরোধ
                </a>
            </nav>
        </div>
    </div>

    {{-- Tab Content --}}
    <div class="shell py-8">
        {{-- Flash Messages --}}
        @if (session('success'))
            <div id="flash-message" class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-3.5 text-sm text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        @if (session('warning'))
            <div class="mb-6 rounded-xl border border-amber-200 bg-amber-50 px-5 py-3.5 text-sm text-amber-700">
                {{ session('warning') }}
            </div>
        @endif

        @yield('tab-content')
    </div>

    @push('scripts')
        <script>
            $(function() {
                setTimeout(function() {
                    $('#flash-message').fadeOut(300);
                }, 4000);
            });
        </script>
    @endpush
@endsection
