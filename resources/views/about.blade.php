@extends('layouts.main')

@section('title', 'আমাদের সম্পর্কে — উসুলি')

@section('content')
    <!-- ============ ABOUT HERO ============ -->
    <section class="pb-[clamp(32px,5vw,60px)] pt-[clamp(40px,6vw,72px)]" aria-labelledby="aboutTitle">
        <div class="shell">
            <div class="mx-auto max-w-2xl text-center">
                <span class="mb-5 inline-flex items-center gap-2.5 text-[0.78rem] font-semibold tracking-[0.14em] text-brand-deep">
                    <span class="inline-block h-0.5 w-[22px] bg-brand" aria-hidden="true"></span>{{ $about['hero_label'] }}
                </span>
                <h1 class="mb-5 font-serif text-[clamp(2rem,4vw,3.2rem)] font-semibold leading-[1.3] tracking-[-0.005em] text-ink" id="aboutTitle">
                    {{ $about['hero_title'] }}
                </h1>
                <p class="text-[1.1rem] leading-[1.85] text-body">
                    {{ $about['hero_subtitle'] }}
                </p>
            </div>
        </div>
    </section>

    <!-- ============ MISSION ============ -->
    <section class="pb-[clamp(48px,6vw,86px)]" aria-labelledby="missionTitle">
        <div class="shell">
            <div class="mx-auto max-w-3xl">
                <div class="reveal rounded-2xl border border-hairline bg-white p-[clamp(24px,4vw,48px)] shadow-sm">
                    <h2 class="mb-6 font-serif text-[clamp(1.3rem,2.4vw,1.75rem)] font-semibold tracking-[-0.005em] text-ink" id="missionTitle">
                        {{ $about['mission_title'] }}
                    </h2>
                    <div class="space-y-4 text-[1.05rem] leading-[1.9] text-body">
                        <p>{{ $about['mission_p1'] }}</p>
                        <p>{{ $about['mission_p2'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ VALUES ============ -->
    <section class="pb-[clamp(48px,6vw,86px)]" aria-labelledby="valuesTitle">
        <div class="shell">
            <div class="mx-auto max-w-4xl text-center">
                <h2 class="mb-10 font-serif text-[clamp(1.3rem,2.4vw,1.75rem)] font-semibold tracking-[-0.005em] text-ink" id="valuesTitle">
                    {{ $about['values_title'] }}
                </h2>
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($about['values'] as $value)
                        @php
                            $iconSvgs = [
                                'book' => '<path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />',
                                'users' => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" /><circle cx="9" cy="7" r="4" /><path d="M23 21v-2a4 4 0 0 0-3-3.87" /><path d="M16 3.13a4 4 0 0 1 0 7.75" />',
                                'globe' => '<circle cx="12" cy="12" r="10" /><line x1="2" y1="12" x2="22" y2="12" /><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" />',
                                'heart' => '<path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />',
                                'star' => '<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />',
                                'lightbulb' => '<path d="M9 18h6" /><path d="M10 22h4" /><path d="M15.09 14c.18-.98.65-1.74 1.41-2.5A4.65 4.65 0 0 0 18 8 6 6 0 0 0 6 8c0 1 .23 2.23 1.5 3.5A4.61 4.61 0 0 1 8.91 14" />',
                            ];
                            $icon = $iconSvgs[$value['icon']] ?? $iconSvgs['book'];
                        @endphp
                        <div class="reveal flex flex-col items-center gap-4 rounded-xl border border-hairline bg-white px-6 py-8 text-center transition-shadow duration-300 hover:shadow-md">
                            <div class="grid h-14 w-14 place-items-center rounded-full bg-brand-soft">
                                <svg class="h-6 w-6 text-brand" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                    {!! $icon !!}
                                </svg>
                            </div>
                            <h3 class="text-sm font-semibold text-ink">{{ $value['title'] }}</h3>
                            <p class="text-[0.95rem] leading-relaxed text-body">
                                {{ $value['description'] }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- ============ TEAM / STORY ============ -->
    <section class="pb-[clamp(48px,6vw,86px)]" aria-labelledby="storyTitle">
        <div class="shell">
            <div class="mx-auto max-w-3xl">
                <div class="reveal rounded-2xl border border-hairline bg-white p-[clamp(24px,4vw,48px)] shadow-sm">
                    <h2 class="mb-6 font-serif text-[clamp(1.3rem,2.4vw,1.75rem)] font-semibold tracking-[-0.005em] text-ink" id="storyTitle">
                        {{ $about['story_title'] }}
                    </h2>
                    <div class="space-y-4 text-[1.05rem] leading-[1.9] text-body">
                        <p>{{ $about['story_p1'] }}</p>
                        <p>{{ $about['story_p2'] }}</p>
                        <p>{{ $about['story_p3'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ CTA ============ -->
    <section class="pb-[clamp(48px,6vw,86px)]" aria-label="যোগাযোগের আহ্বান">
        <div class="shell">
            <div class="mx-auto max-w-2xl text-center">
                <div class="reveal rounded-2xl border border-hairline bg-brand-soft/30 px-[clamp(24px,4vw,48px)] py-[clamp(32px,4vw,56px)]">
                    <h2 class="mb-4 font-serif text-[clamp(1.3rem,2.4vw,1.75rem)] font-semibold tracking-[-0.005em] text-ink">
                        {{ $about['cta_title'] }}
                    </h2>
                    <p class="mb-8 text-[1.05rem] leading-[1.85] text-body">
                        {{ $about['cta_subtitle'] }}
                    </p>
                    <div class="flex flex-wrap justify-center gap-4">
                        <a href="{{ route('frontend.register') }}" class="rounded-lg bg-brand px-6 py-3 text-sm font-medium text-white transition-colors hover:bg-brand-deep">
                            {{ $about['cta_register_btn'] }}
                        </a>
                        <a href="{{ route('contact') }}" class="rounded-lg border border-hairline bg-white px-6 py-3 text-sm font-medium text-ink transition-colors hover:bg-gray-50">
                            {{ $about['cta_contact_btn'] }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
