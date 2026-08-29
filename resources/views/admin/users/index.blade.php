@extends('admin.layouts.app')

@section('title', 'সব সদস্য — উসুলি অ্যাডমিন')

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
            <h1 class="text-2xl font-semibold text-ink">সব সদস্য</h1>
            <a href="{{ route('admin.users.createPage') }}"
               class="inline-flex items-center gap-2 rounded-lg bg-brand px-4 py-2.5 text-sm font-medium text-white transition-colors hover:bg-brand-deep">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 5v14M5 12h14"/>
                </svg>
                নতুন সদস্য
            </a>
        </div>

        {{-- Filters --}}
        <form method="GET" class="flex flex-wrap items-end gap-4 rounded-xl border border-hairline bg-white p-4">
            <div class="flex-1 min-w-[200px]">
                <label class="mb-1.5 block text-sm font-medium text-ink">অনুসন্ধান</label>
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="নাম, ইমেইল বা ইউজারনেম..."
                       class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20">
            </div>
            <div class="min-w-[150px]">
                <label class="mb-1.5 block text-sm font-medium text-ink">ভূমিকা</label>
                <select name="user_role"
                        class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20">
                    <option value="">সব</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" {{ request('user_role') == $role->id ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="min-w-[150px]">
                <label class="mb-1.5 block text-sm font-medium text-ink">অবস্থা</label>
                <select name="status"
                        class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20">
                    <option value="">সব</option>
                    <option value="Active" {{ request('status') === 'Active' ? 'selected' : '' }}>সক্রিয়</option>
                    <option value="Inactive" {{ request('status') === 'Inactive' ? 'selected' : '' }}>নিষ্ক্রিয়</option>
                    <option value="Banned" {{ request('status') === 'Banned' ? 'selected' : '' }}>নিষিদ্ধ</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit"
                        class="rounded-lg bg-brand px-4 py-2.5 text-sm font-medium text-white transition-colors hover:bg-brand-deep">
                    ফিল্টার
                </button>
                <a href="{{ route('admin.users.view') }}"
                   class="rounded-lg border border-hairline px-4 py-2.5 text-sm font-medium text-faint transition-colors hover:bg-gray-50">
                    রিসেট
                </a>
            </div>
        </form>

        {{-- Bulk Delete --}}
        <form id="bulkDeleteForm" method="POST" action="{{ route('admin.users.bulkDelete') }}">
            @csrf
            <input type="hidden" name="ids" id="bulkDeleteIds" value="">

            {{-- Users Table --}}
            <div class="overflow-hidden rounded-xl border border-hairline bg-white">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-hairline bg-gray-50/50">
                            <th class="px-4 py-3">
                                <input type="checkbox"
                                       id="selectAll"
                                       class="h-4 w-4 rounded border-hairline text-brand focus:ring-brand/20">
                            </th>
                            <th class="px-4 py-3 font-medium text-ink">নাম</th>
                            <th class="px-4 py-3 font-medium text-ink">ইমেইল</th>
                            <th class="px-4 py-3 font-medium text-ink">ইউজারনেম</th>
                            <th class="px-4 py-3 font-medium text-ink">ভূমিকা</th>
                            <th class="px-4 py-3 font-medium text-ink">অবস্থা</th>
                            <th class="px-4 py-3 text-right font-medium text-ink">কার্যক্রম</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-hairline">
                        @forelse ($users as $user)
                            <tr class="transition-colors hover:bg-gray-50/50">
                                <td class="px-4 py-3">
                                    <input type="checkbox"
                                           name="user_ids[]"
                                           value="{{ $user->id }}"
                                           class="user-checkbox h-4 w-4 rounded border-hairline text-brand focus:ring-brand/20">
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        @if (!empty($user->images))
                                            <img src="{{ $user->images }}" alt="{{ $user->name }}" class="h-8 w-8 rounded-full object-cover">
                                        @else
                                            <span class="grid h-8 w-8 place-items-center rounded-full bg-brand/15 font-serif text-sm font-semibold text-brand">
                                                {{ mb_substr($user->name, 0, 1) }}
                                            </span>
                                        @endif
                                        <span class="font-medium text-ink">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-faint">{{ $user->email }}</td>
                                <td class="px-4 py-3 text-faint">{{ $user->username }}</td>
                                <td class="px-4 py-3 text-faint">{{ $user->Role->name ?? '—' }}</td>
                                <td class="px-4 py-3">
                                    @if ($user->status === 'Active')
                                        <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-medium text-emerald-700">
                                            সক্রিয়
                                        </span>
                                    @elseif ($user->status === 'Inactive')
                                        <span class="inline-flex items-center rounded-full bg-amber-50 px-2.5 py-0.5 text-xs font-medium text-amber-700">
                                            নিষ্ক্রিয়
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-red-50 px-2.5 py-0.5 text-xs font-medium text-red-700">
                                            নিষিদ্ধ
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('admin.users.edit', $user->id) }}"
                                           class="rounded-lg p-2 text-faint transition-colors hover:bg-brand/10 hover:text-brand"
                                           title="সম্পাদনা">
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M17 3a2.83 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/>
                                            </svg>
                                        </a>
                                        <form method="POST"
                                              action="{{ route('admin.users.delete') }}"
                                              onsubmit="return confirm('আপনি কি নিশ্চিত এই সদস্যটি মুছে ফেলতে চান?')">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $user->id }}">
                                            <button type="submit"
                                                    class="rounded-lg p-2 text-faint transition-colors hover:bg-red-50 hover:text-red-600"
                                                    title="মুছুন">
                                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-12 text-center text-faint">
                                    কোনো সদস্য পাওয়া যায়নি।
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>

        {{-- Bulk Delete Button --}}
        <div id="bulkDeleteWrapper" class="hidden">
            <button type="submit" form="bulkDeleteForm"
                    class="inline-flex items-center gap-2 rounded-lg bg-red-600 px-4 py-2.5 text-sm font-medium text-white transition-colors hover:bg-red-700">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                </svg>
                নির্বাচিত মুছুন
            </button>
        </div>

        {{-- Pagination --}}
        @if ($users->hasPages())
            <div class="flex justify-center">
                {{ $users->links() }}
            </div>
        @endif
    </div>

    <script>
        $(document).ready(function() {
            $('#flash-message').delay(3000).fadeOut(300);

            $('#selectAll').on('change', function() {
                $('.user-checkbox').prop('checked', this.checked);
                updateBulkDelete();
            });

            $(document).on('change', '.user-checkbox', function() {
                updateBulkDelete();
            });

            function updateBulkDelete() {
                var selected = [];
                $('.user-checkbox:checked').each(function() {
                    selected.push($(this).val());
                });
                $('#bulkDeleteIds').val(selected.join(','));
                if (selected.length > 0) {
                    $('#bulkDeleteWrapper').removeClass('hidden');
                } else {
                    $('#bulkDeleteWrapper').addClass('hidden');
                }
            }
        });
    </script>
@endsection
