@extends('admin.layouts.app')

@section('title', $pageTitle . ' — উসুলি অ্যাডমিন')

@section('content')
    <div class="space-y-6">
        {{-- Flash Message --}}
        @if (session('success'))
            <div id="flash-message" class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        {{-- Header --}}
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.contacts.index') }}" class="grid h-10 w-10 place-items-center rounded-lg border border-hairline text-faint transition-colors hover:bg-gray-50 hover:text-ink">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 12H5M12 19l-7-7 7-7" />
                    </svg>
                </a>
                <h1 class="text-2xl font-semibold text-ink">{{ $pageTitle }}</h1>
            </div>
            <form method="POST" action="{{ route('admin.contacts.destroy', $contact) }}" onsubmit="return confirm('আপনি কি নিশ্চিত এই যোগাযোগটি মুছে ফেলতে চান?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center gap-2 rounded-lg border border-red-200 bg-red-50 px-4 py-2.5 text-sm font-medium text-red-600 transition-colors hover:bg-red-100">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                    </svg>
                    মুছুন
                </button>
            </form>
        </div>

        <div class="grid gap-6 min-[901px]:grid-cols-[1fr_320px]">
            {{-- Main: Message --}}
            <div class="rounded-xl border border-hairline bg-white p-6">
                <div class="mb-6 flex items-center gap-4">
                    <span class="grid h-12 w-12 shrink-0 place-items-center rounded-full bg-linear-160 from-brand to-brand-deep font-serif text-lg font-semibold text-white">
                        {{ mb_substr($contact->name, 0, 1, 'UTF-8') }}
                    </span>
                    <div>
                        <h2 class="text-lg font-semibold text-ink">{{ $contact->name }}</h2>
                        <p class="text-xs text-faint">{{ $contact->created_at->format('d M Y, h:i A') }}</p>
                    </div>
                </div>

                <div class="mb-6 space-y-3 rounded-lg border border-hairline bg-gray-50/50 p-4">
                    <div>
                        <span class="text-xs font-medium text-faint">বিষয়</span>
                        <p class="text-sm font-medium text-ink">{{ $contact->subject }}</p>
                    </div>
                </div>

                <div class="prose prose-sm max-w-none">
                    <p class="whitespace-pre-wrap text-[0.95rem] leading-[1.85] text-body">{{ $contact->body }}</p>
                </div>
            </div>

            {{-- Sidebar: Contact Details --}}
            <aside class="min-w-0">
                <div class="min-[901px]:sticky min-[901px]:top-[92px] space-y-6">
                    <div class="rounded-xl border border-hairline bg-white p-5">
                        <h3 class="mb-4 text-sm font-semibold text-ink">যোগাযোগের তথ্য</h3>
                        <div class="space-y-4">
                            <div>
                                <p class="text-xs text-faint">নাম</p>
                                <p class="text-sm font-medium text-ink">{{ $contact->name }}</p>
                            </div>
                            @if ($contact->email)
                                <div>
                                    <p class="text-xs text-faint">ইমেইল</p>
                                    <a href="mailto:{{ $contact->email }}" class="text-sm font-medium text-brand-deep hover:underline">{{ $contact->email }}</a>
                                </div>
                            @endif
                            @if ($contact->phone)
                                <div>
                                    <p class="text-xs text-faint">ফোন</p>
                                    <a href="tel:{{ $contact->phone }}" class="text-sm font-medium text-brand-deep hover:underline">{{ $contact->phone }}</a>
                                </div>
                            @endif
                            <div>
                                <p class="text-xs text-faint">অবস্থা</p>
                                @if ($contact->is_seen)
                                    <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-medium text-emerald-700">
                                        দেখা হয়েছে
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-amber-50 px-2.5 py-0.5 text-xs font-medium text-amber-700">
                                        নতুন
                                    </span>
                                @endif
                            </div>
                            <div>
                                <p class="text-xs text-faint">পাঠানো হয়েছে</p>
                                <p class="text-sm text-ink">{{ $contact->created_at->format('d M Y, h:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#flash-message').delay(3000).fadeOut(300);
        });
    </script>
@endsection
