@extends('admin.master')

@section('content')
<section class="py-4 md:py-6">
    <div class="mx-auto max-w-4xl admin-card">

        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.24em] text-[#7f8898]">
                    Subscription
                </p>

                <h2 class="mt-2 text-2xl font-semibold text-white">
                    {{ $isEdit ? 'Cập nhật subscription' : 'Tạo subscription mới' }}
                </h2>
            </div>

            <a href="{{ route('admin.subscriptions.index') }}"
               class="rounded-2xl border border-white/10 px-4 py-3 text-sm text-white transition hover:bg-white/5">
                Quay lại
            </a>
        </div>

        <form
            action="{{ $isEdit
                ? route('admin.subscriptions.update', $subscription->id)
                : route('admin.subscriptions.store') }}"
            method="POST"
            class="mt-8 space-y-5"
        >

            @csrf

            @if($isEdit)
                @method('PUT')
            @endif

            <div class="grid gap-5 md:grid-cols-2">

                {{-- USER --}}
                <div>
                    <label class="mb-2 block text-sm text-[#cfd5df]">
                        Người dùng
                    </label>

                    <select
                        name="user_id"
                        class="w-full rounded-2xl border border-white/10 bg-[#13161d] px-4 py-3 text-white outline-none focus:border-[#10a37f]"
                    >

                        <option value="">
                            -- Chọn người dùng --
                        </option>

                        @foreach($users as $user)

                            <option
                                value="{{ $user->id }}"
                                @selected(old('user_id', $subscription->user_id) == $user->id)
                            >
                                {{ $user->fullname }}
                            </option>

                        @endforeach

                    </select>

                    @error('user_id')
                        <p class="mt-2 text-sm text-red-300">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- PLAN --}}
                <div>
                    <label class="mb-2 block text-sm text-[#cfd5df]">
                        Gói cước
                    </label>

                    <select
                        name="plan_id"
                        class="w-full rounded-2xl border border-white/10 bg-[#13161d] px-4 py-3 text-white outline-none focus:border-[#10a37f]"
                    >

                        <option value="">
                            -- Chọn gói --
                        </option>

                        @foreach($plans as $plan)

                            <option
                                value="{{ $plan->id }}"
                                @selected(old('plan_id', $subscription->plan_id) == $plan->id)
                            >
                                {{ $plan->name }}
                                ({{ $plan->duration_days }} ngày)
                            </option>

                        @endforeach

                    </select>

                    @error('plan_id')
                        <p class="mt-2 text-sm text-red-300">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

            </div>

            {{-- START DATE --}}
            <div>
                <label class="mb-2 block text-sm text-[#cfd5df]">
                    Ngày bắt đầu
                </label>

                <input
                    type="datetime-local"
                    name="starts_at"
                    value="{{ old('starts_at',
                        $subscription->starts_at
                            ? \Carbon\Carbon::parse($subscription->starts_at)->format('Y-m-d\TH:i')
                            : ''
                    ) }}"
                    class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none focus:border-[#10a37f]"
                >

                @error('starts_at')
                    <p class="mt-2 text-sm text-red-300">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- STATUS --}}
            <div>
                <label class="mb-2 block text-sm text-[#cfd5df]">
                    Trạng thái
                </label>

                <select
                    name="status"
                    class="w-full rounded-2xl border border-white/10 bg-[#13161d] px-4 py-3 text-white outline-none focus:border-[#10a37f]"
                >
                    <option
                        value="1"
                        @selected(old('status', $subscription->status ?? true))
                    >
                        Hoạt động
                    </option>

                    <option
                        value="0"
                        @selected(old('status', $subscription->status ?? false) == false)
                    >
                        Ngưng hoạt động
                    </option>
                </select>
            </div>

            <button
                type="submit"
                class="rounded-2xl bg-[#10a37f] px-5 py-3 text-sm font-semibold text-[#08110d] transition hover:brightness-110"
            >
                {{ $isEdit ? 'Lưu thay đổi' : 'Tạo subscription' }}
            </button>

        </form>
    </div>
</section>
@endsection