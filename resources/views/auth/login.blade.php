<!DOCTYPE html>
<html lang="bn" dir="ltr" class="scroll-smooth motion-reduce:scroll-auto">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>লগইন — উসুলি</title>
    <meta name="description" content="উসুলিতে লগইন করুন।">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;500;600;700&family=Noto+Serif+Bengali:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">

    @vite(['resources/css/app.css'])
</head>

<body class="relative bg-page font-sans text-[17px] leading-[1.75] text-body antialiased max-[620px]:text-base">
    @php
        $brandMarkPath = 'M41 9 C 36 24 30 33 31 46 C 32 57 44 60 47 69 C 49 76 42 83 30 82 C 20 81 13 74 12 64';
        $brandAccentPath = 'M40 6 C 42 4 45 4 46 7';
    @endphp

    <main class="flex min-h-screen items-center justify-center px-5 py-12">
        <div class="w-full max-w-[440px]">
            {{-- Logo --}}
            <div class="mb-10 flex justify-center">
                <a href="{{ route('home.index') }}" aria-label="উসুলি — প্রচ্ছদ" class="inline-flex items-center gap-3">
                    <svg class="h-[54px] w-[36px] shrink-0 overflow-visible" viewBox="0 0 60 90" aria-hidden="true" focusable="false">
                        <path class="[stroke-dasharray:240] [stroke-dashoffset:240] animate-draw motion-reduce:animate-none motion-reduce:[stroke-dashoffset:0]" d="{{ $brandMarkPath }}" fill="none" stroke="#2b8ca4" stroke-width="6.5"
                            stroke-linecap="round" stroke-linejoin="round" />
                        <path class="opacity-0 animate-fade-in-late motion-reduce:animate-none motion-reduce:opacity-100" d="{{ $brandAccentPath }}" fill="none" stroke="#2b8ca4" stroke-width="4" stroke-linecap="round" />
                    </svg>
                    <span class="font-serif text-[2rem] font-semibold leading-none tracking-[-0.01em] text-ink">উসুলি</span>
                </a>
            </div>

            {{-- Form Card --}}
            <div class="rounded-[14px] border border-hairline bg-white px-[clamp(24px,5vw,40px)] py-[clamp(32px,5vw,48px)]">
                <h1 class="mb-2 text-center font-serif text-[1.65rem] font-semibold tracking-[-0.005em] text-ink">
                    অ্যাকাউন্টে প্রবেশ
                </h1>
                <p class="mb-8 text-center text-[0.98rem] text-faint">
                    আপনার অ্যাকাউন্টে লগইন করুন
                </p>

                {{-- Errors --}}
                @if ($errors->any())
                    <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login.post') }}">
                    @csrf

                    {{-- Email --}}
                    <div class="mb-5">
                        <label for="email" class="mb-2 block text-[0.9rem] font-medium text-ink">ইমেইল</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email" placeholder="আপনার ইমেইল"
                            class="w-full rounded-full border border-brand-line bg-[#fafaf8] px-5 py-3.5 text-base text-body outline-none transition-[border-color,box-shadow] duration-300 placeholder:text-faint focus:border-brand focus:ring-3 focus:ring-brand/15">
                        @error('email')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="mb-5">
                        <label for="password" class="mb-2 block text-[0.9rem] font-medium text-ink">পাসওয়ার্ড</label>
                        <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="আপনার পাসওয়ার্ড"
                            class="w-full rounded-full border border-brand-line bg-[#fafaf8] px-5 py-3.5 text-base text-body outline-none transition-[border-color,box-shadow] duration-300 placeholder:text-faint focus:border-brand focus:ring-3 focus:ring-brand/15">
                        @error('password')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Remember & Forgot --}}
                    <div class="mb-8 flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="remember" class="h-4 w-4 rounded border-brand-line text-brand focus:ring-brand/20">
                            <span class="text-[0.9rem] text-body">মনে রাখুন</span>
                        </label>
                        <a href="#" class="text-[0.9rem] font-medium text-brand-deep transition-colors duration-300 hover:text-brand">
                            পাসওয়ার্ড ভুলে গেছেন?
                        </a>
                    </div>

                    {{-- Submit --}}
                    <button type="submit" class="w-full rounded-full bg-brand px-7 py-3.5 text-base font-semibold text-white transition-all duration-300 hover:-translate-y-px hover:bg-brand-deep">
                        প্রবেশ করুন
                    </button>
                </form>

                {{-- Divider --}}
                <div class="my-8 flex items-center gap-4">
                    <div class="h-px flex-1 bg-hairline"></div>
                    <span class="text-[0.85rem] text-faint">অথবা</span>
                    <div class="h-px flex-1 bg-hairline"></div>
                </div>

                {{-- Register Link --}}
                <p class="text-center text-[0.98rem] text-body">
                    অ্যাকাউন্ট নেই?
                    <a href="#" class="font-semibold text-brand-deep transition-colors duration-300 hover:text-brand">
                        নিবন্ধন করুন
                    </a>
                </p>
            </div>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-4.0.0.min.js" integrity="sha256-OaVG6prZf4v69dPg6PhVattBXkcOWQB62pdZ3ORyrao=" crossorigin="anonymous"></script>
    <script>
        $(function() {
            /* ---- Reveal on scroll ---- */
            var $revealables = $('.reveal');

            $revealables.each(function(index) {
                $(this).css('transition-delay', Math.min((index % 6) * 70, 350) + 'ms');
            });

            var revealInView = function() {
                var triggerLine = $(window).scrollTop() + $(window).height() * 0.92;

                $revealables.filter(function() {
                    return !$(this).data('revealed');
                }).each(function() {
                    var $el = $(this);

                    if ($el.offset().top < triggerLine) {
                        $el.data('revealed', true).css({
                            opacity: '1',
                            transform: 'none'
                        });
                    }
                });
            };

            revealInView();
            $(window).on('scroll resize', revealInView);
        });
    </script>
</body>

</html>
