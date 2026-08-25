@extends('admin.layouts.app')

@section('title', 'ড্যাশবোর্ড — উসুলি অ্যাডমিন')

@section('content')
    <section class="reveal mx-auto flex w-full max-w-3xl flex-col items-center rounded-[14px] border border-dashed border-brand-line bg-white px-6 py-[clamp(48px,8vw,96px)] text-center">
        <div class="mb-5 opacity-30" aria-hidden="true">
            <svg class="h-14 w-auto overflow-visible" viewBox="0 0 60 90">
                <path d="M41 9 C 36 24 30 33 31 46 C 32 57 44 60 47 69 C 49 76 42 83 30 82 C 20 81 13 74 12 64"
                      fill="none" stroke="#2b8ca4" stroke-width="6.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
        <h2 class="font-serif text-[clamp(1.35rem,2.4vw,1.75rem)] font-semibold tracking-[-0.005em] text-ink">
            কনটেন্ট এখানে আসবে
        </h2>
        <p class="mt-2.5 max-w-md text-[1.02rem] leading-[1.8] text-body">
            ড্যাশবোর্ডের প্রধান অংশ—এখানে পরিসংখ্যান, সাম্প্রতিক কার্যক্রম ও দ্রুত শর্টকাট থাকবে।
        </p>
    </section>
@endsection
