@extends('admin.layouts.app')

@section('title', 'ভূমিকা সম্পাদনা — উসুলি অ্যাডমিন')

@section('content')
    <div>

        {{-- Breadcrumbs --}}
        <nav class="mb-4 text-sm text-faint">
            <a href="{{ route('admin.roles.view') }}" class="hover:text-brand">ভূমিকাসমূহ</a>
            <span class="mx-1.5">/</span>
            <span class="text-ink">সম্পাদনা</span>
        </nav>

        <h1 class="mb-6 font-serif text-2xl font-semibold text-ink">ভূমিকা সম্পাদনা</h1>

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

        <form action="{{ route('admin.roles.update') }}" method="POST"
              class="rounded-xl border border-hairline bg-white p-6">
            @csrf
            <input type="hidden" name="id" value="{{ $role->id }}">

            <div class="mb-5">
                <label for="name" class="mb-1.5 block text-sm font-medium text-ink">নাম <span class="text-red-500">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name', $role->name) }}" required
                       class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20"
                       placeholder="ভূমিকার নাম লিখুন">
            </div>

            <div class="mb-5">
                <label for="description" class="mb-1.5 block text-sm font-medium text-ink">বর্ণনা</label>
                <textarea id="description" name="description" rows="3"
                          class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20"
                          placeholder="ভূমিকার বর্ণনা লিখুন (ঐচ্ছিক)">{{ old('description', $role->description) }}</textarea>
            </div>

            <div class="mb-6">
                <label for="status" class="mb-1.5 block text-sm font-medium text-ink">অবস্থা <span class="text-red-500">*</span></label>
                <select id="status" name="status"
                        class="w-full rounded-lg border border-hairline bg-gray-50/50 px-4 py-2.5 text-sm text-ink outline-none transition-colors focus:border-brand focus:bg-white focus:ring-1 focus:ring-brand/20">
                    <option value="Active" {{ old('status', $role->status) === 'Active' ? 'selected' : '' }}>সক্রিয়</option>
                    <option value="Inactive" {{ old('status', $role->status) === 'Inactive' ? 'selected' : '' }}>নিষ্ক্রিয়</option>
                </select>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit"
                        class="inline-flex items-center gap-2 rounded-lg bg-brand px-5 py-2.5 text-sm font-medium text-white transition-colors hover:bg-brand-deep">
                    আপডেট করুন
                </button>
                <a href="{{ route('admin.roles.view') }}"
                   class="inline-flex items-center gap-2 rounded-lg border border-hairline px-5 py-2.5 text-sm font-medium text-faint transition-colors hover:bg-gray-50">
                    বাতিল
                </a>
            </div>
        </form>
    </div>
@endsection
