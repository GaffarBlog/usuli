@extends('admin.layouts.app')

@section('title', 'অনুমতি — ' . $role->name . ' — উসুলি অ্যাডমিন')

@section('content')
    <div>

        {{-- Success Message --}}
        @if (session('success'))
            <div id="flash-msg" class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        {{-- Breadcrumbs --}}
        <nav class="mb-4 text-sm text-faint">
            <a href="{{ route('admin.roles.view') }}" class="hover:text-brand">ভূমিকাসমূহ</a>
            <span class="mx-1.5">/</span>
            <span class="text-ink">অনুমতি</span>
        </nav>

        <div class="mb-6">
            <h1 class="font-serif text-2xl font-semibold text-ink">অনুমতি পরিচালনা</h1>
            <p class="mt-1 text-sm text-faint">
                <span class="font-medium text-ink">{{ $role->name }}</span> ভূমিকার জন্য অনুমতি নির্ধারণ করুন
            </p>
        </div>

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

        <form action="{{ route('admin.permissions.update') }}" method="POST"
              class="rounded-xl border border-hairline bg-white p-6">
            @csrf
            <input type="hidden" name="role_id" value="{{ $role->id }}">

            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-sm font-semibold text-ink">রুট অনুযায়ী অনুমতি</h2>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" id="selectAll"
                           class="h-4 w-4 rounded border-gray-300 text-brand focus:ring-brand/20">
                    <span class="text-sm font-medium text-ink">সব নির্বাচন করুন</span>
                </label>
            </div>

            <div class="space-y-5">
                @forelse ($routes as $parent)
                    <div class="rounded-lg border border-hairline bg-gray-50/50 p-4">
                        <div class="mb-3 flex items-center gap-2.5">
                            <input type="checkbox" data-parent="{{ $parent->id }}"
                                   class="parent-check h-4 w-4 rounded border-gray-300 text-brand focus:ring-brand/20">
                            <h3 class="text-sm font-semibold text-ink">{{ $parent->name }}</h3>
                        </div>

                        @if ($parent->Childrens->count())
                            <div class="ml-6 space-y-2">
                                @foreach ($parent->Childrens as $child)
                                    <label class="flex items-center gap-2.5 cursor-pointer">
                                        <input type="checkbox" name="permissions[]" value="{{ $child->route }}"
                                               data-parent="{{ $parent->id }}"
                                               {{ in_array($child->route, $permissions) ? 'checked' : '' }}
                                               class="child-check h-4 w-4 rounded border-gray-300 text-brand focus:ring-brand/20">
                                        <span class="text-sm text-body">{{ $child->name }}</span>
                                        <code class="ml-auto rounded bg-gray-200/60 px-1.5 py-0.5 text-[0.7rem] text-faint">{{ $child->route }}</code>
                                    </label>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @empty
                    <p class="py-8 text-center text-faint">কোনো রুট পাওয়া যায়নি।</p>
                @endforelse
            </div>

            <div class="mt-6 flex items-center gap-3">
                <button type="submit"
                        class="inline-flex items-center gap-2 rounded-lg bg-brand px-5 py-2.5 text-sm font-medium text-white transition-colors hover:bg-brand-deep">
                    অনুমতি সংরক্ষণ করুন
                </button>
                <a href="{{ route('admin.roles.view') }}"
                   class="inline-flex items-center gap-2 rounded-lg border border-hairline px-5 py-2.5 text-sm font-medium text-faint transition-colors hover:bg-gray-50">
                    বাতিল
                </a>
            </div>
        </form>
    </div>

    <script>
        $(function () {
            if ($('#flash-msg').length) {
                setTimeout(function () {
                    $('#flash-msg').fadeOut(400, function () { $(this).remove(); });
                }, 3000);
            }

            $('#selectAll').on('change', function () {
                var checked = $(this).is(':checked');
                $('input[type="checkbox"]').prop('checked', checked);
            });

            $('.parent-check').on('change', function () {
                var parentId = $(this).data('parent');
                $('input.child-check[data-parent="' + parentId + '"]').prop('checked', $(this).is(':checked'));
            });

            $('input[type="checkbox"]').not('#selectAll').on('change', function () {
                var parentId = $(this).data('parent');
                if (parentId) {
                    var total = $('input.child-check[data-parent="' + parentId + '"]').length;
                    var checked = $('input.child-check[data-parent="' + parentId + '"]:checked').length;
                    $('input.parent-check[data-parent="' + parentId + '"]').prop('checked', total === checked);
                }
            });
        });
    </script>
@endsection
