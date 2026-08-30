@extends('admin.layouts.app')

@section('title', 'ভূমিকাসমূহ — উসুলি অ্যাডমিন')

@section('content')
    <div>

        {{-- Success Message --}}
        @if (session('success'))
            <div id="flash-msg" class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        {{-- Header --}}
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="font-serif text-2xl font-semibold text-ink">ভূমিকাসমূহ</h1>
                <p class="mt-1 text-sm text-faint">ব্যবহারকারীর ভূমিকা পরিচালনা করুন</p>
            </div>
            <a href="{{ route('admin.roles.createPage') }}"
               class="inline-flex items-center gap-2 rounded-lg bg-brand px-4 py-2.5 text-sm font-medium text-white transition-colors hover:bg-brand-deep">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                নতুন ভূমিকা
            </a>
        </div>

        {{-- Table --}}
        <div class="overflow-hidden rounded-xl border border-hairline bg-white">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-hairline bg-gray-50/60">
                        <th class="px-5 py-3 font-semibold text-ink">#</th>
                        <th class="px-5 py-3 font-semibold text-ink">নাম</th>
                        <th class="px-5 py-3 font-semibold text-ink">স্লাগ</th>
                        <th class="px-5 py-3 font-semibold text-ink">বর্ণনা</th>
                        <th class="px-5 py-3 font-semibold text-ink">অবস্থা</th>
                        <th class="px-5 py-3 text-right font-semibold text-ink">কার্যক্রম</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($roles as $index => $role)
                        <tr class="border-b border-hairline last:border-0 transition-colors hover:bg-gray-50/40">
                            <td class="px-5 py-3.5 text-faint">{{ $index + 1 }}</td>
                            <td class="px-5 py-3.5 font-medium text-ink">{{ $role->name }}</td>
                            <td class="px-5 py-3.5 text-faint">{{ $role->slug }}</td>
                            <td class="px-5 py-3.5 text-faint">{{ $role->description ?? '—' }}</td>
                            <td class="px-5 py-3.5">
                                <button type="button" data-id="{{ $role->id }}"
                                    data-status="{{ $role->status === 'Active' ? 'Inactive' : 'Active' }}"
                                    class="toggle-status inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium cursor-pointer transition-colors
                                        {{ $role->status === 'Active'
                                            ? 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100'
                                            : 'bg-gray-100 text-gray-500 hover:bg-gray-200' }}">
                                    {{ $role->status === 'Active' ? 'সক্রিয়' : 'নিষ্ক্রিয়' }}
                                </button>
                            </td>
                            <td class="px-5 py-3.5 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('admin.permissions.view', $role->id) }}"
                                       class="grid h-8 w-8 place-items-center rounded-lg text-faint transition-colors hover:bg-brand/10 hover:text-brand"
                                       title="অনুমতি">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.roles.edit', $role->id) }}"
                                       class="grid h-8 w-8 place-items-center rounded-lg text-faint transition-colors hover:bg-brand/10 hover:text-brand"
                                       title="সম্পাদনা">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M17 3a2.83 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.roles.delete') }}" method="POST"
                                          onsubmit="return confirm('আপনি কি নিশ্চিত এই ভূমিকাটি মুছে ফেলতে চান?')">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $role->id }}">
                                        <button type="submit"
                                                class="grid h-8 w-8 place-items-center rounded-lg text-faint transition-colors hover:bg-red-50 hover:text-red-600"
                                                title="মুছুন">
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                                                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-16 text-center text-faint">
                                কোনো ভূমিকা তৈরি হয়নি।
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        $(function () {
            if ($('#flash-msg').length) {
                setTimeout(function () {
                    $('#flash-msg').fadeOut(400, function () { $(this).remove(); });
                }, 3000);
            }

            $('.toggle-status').on('click', function () {
                var $btn = $(this);
                $.ajax({
                    url: '{{ route("admin.roles.status") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: $btn.data('id'),
                        status: $btn.data('status')
                    },
                    success: function (res) {
                        if (res.status) {
                            var newStatus = $btn.data('status');
                            $btn.data('status', newStatus === 'Active' ? 'Inactive' : 'Active');
                            $btn.text(newStatus === 'Active' ? 'সক্রিয়' : 'নিষ্ক্রিয়');
                            $btn.toggleClass('bg-emerald-50 text-emerald-700 bg-gray-100 text-gray-500');
                        }
                    }
                });
            });
        });
    </script>
@endsection
