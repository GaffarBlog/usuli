<!DOCTYPE html>
<html lang="bn" dir="ltr" class="scroll-smooth motion-reduce:scroll-auto">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>উসুলি — বাংলায় গল্প, ভাবনা ও মানুষের কথা</title>
    <meta name="description" content="উসুলি একটি স্বাধীন বাংলা ডিজিটাল জার্নাল—নির্বাচিত গল্প, ভাবনা ও মানুষের কথা।">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;500;600;700&family=Noto+Serif+Bengali:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">

    @vite(['resources/css/app.css'])
</head>

<body class="relative bg-page font-sans text-[17px] leading-[1.75] text-body antialiased max-[620px]:text-base">
    <a href="#main" class="absolute left-4 top-[-60px] z-[200] rounded-lg bg-brand px-[18px] py-2.5 font-semibold text-white transition-[top] duration-300 focus:top-3.5">
        মূল অংশে যান
    </a>

    <!-- ============ HEADER ============ -->
    @include('layouts.header')

    <main id="main">
        @yield('content')
    </main>

    <!-- ============ FOOTER ============ -->

    @include('layouts.footer')
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script>
        $(function() {
            /* ---- Mobile menu toggle ---- */
            var $toggle = $('#menuToggle');
            var $panel = $('#mobileNav');

            $toggle.on('click', function() {
                var willOpen = $toggle.attr('aria-expanded') !== 'true';
                $toggle.attr('aria-expanded', String(willOpen));
                $panel.prop('hidden', !willOpen);
            });

            $panel.on('click', 'a', function() {
                $toggle.attr('aria-expanded', 'false');
                $panel.prop('hidden', true);
            });

            $(window).on('resize', function() {
                if ($(window).width() > 1000 && !$panel.prop('hidden')) {
                    $toggle.attr('aria-expanded', 'false');
                    $panel.prop('hidden', true);
                }
            });

            /* ---- Fade photos in over their duotone placeholders ---- */
            $('.ph img').each(function() {
                var $img = $(this);
                var markLoaded = function() {
                    $img.css('opacity', '1');
                };

                if (this.complete && this.naturalWidth > 0) {
                    markLoaded();
                } else {
                    $img.one('load', markLoaded);
                    $img.one('error', function() {
                        $img.remove();
                    });
                }
            });

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

            /* ---- Newsletter demo form ---- */
            $('#newsletterForm').on('submit', function(event) {
                event.preventDefault();
            });
        });
    </script>
</body>

</html>
