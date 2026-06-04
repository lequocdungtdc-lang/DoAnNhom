@extends('admin.master')

@section('content')
<section class="py-4 md:py-6">

    <div class="mx-auto max-w-4xl admin-card">

        <div class="flex items-center justify-between gap-4">

            <div>

                <p class="text-xs uppercase tracking-[0.24em] text-[#7f8898]">
                    Comment
                </p>

                <h2 class="mt-2 text-2xl font-semibold text-white">
                    {{ $isEdit ? 'Cập nhật comment' : 'Tạo comment mới' }}
                </h2>

            </div>

            <a
                href="{{ route('admin.comments.index') }}"
                class="rounded-2xl border border-white/10 px-4 py-3 text-sm text-white transition hover:bg-white/5">

                Quay lại
            </a>

        </div>

        <form
            action="{{ $isEdit ? route('admin.comments.update', $comment->id) : route('admin.comments.store') }}"
            method="POST"
            class="mt-8 space-y-5">

            @csrf

            @if ($isEdit)
            @method('PUT')
            @endif

            <div>

                <label class="mb-2 block text-sm text-[#cfd5df]">
                   Nguời bình luận
                </label>

                <select
                    name="user_id"
                    class="w-full rounded-2xl border border-white/10 bg-[#13161d] px-4 py-3 text-white">

                    <option value="">-- Chọn người dùng --</option>

                    @foreach ($users as $user)
                    <option value="{{ $user->id }}" @selected((string) old('user_id', (string) $comment->user_id) === (string) $user->id)>
                        {{ $user->fullname }}
                    </option>
                    @endforeach

                </select>

            </div>

            <div>

                <label class="mb-2 block text-sm text-[#cfd5df]">
                    Tin tức
                </label>

                <select
                    name="new_id"
                    class="w-full rounded-2xl border border-white/10 bg-[#13161d] px-4 py-3 text-white">

                    <option value="">-- Chọn tin tức --</option>

                    @foreach ($news as $new)
                    <option value="{{ $new->id }}" @selected((string) old('new_id', (string) $comment->new_id) === (string) $new->id)>
                        {{ $new->title }}
                    </option>
                    @endforeach

                </select>

            </div>

            <div>

                <label class="mb-2 block text-sm text-[#cfd5df]">
                    Nội dung
                </label>

                <textarea
                    name="content"
                    rows="5"
                    class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none">{{ old('content', $comment->content) }}</textarea>

            </div>

            <div>

                <label class="mb-2 block text-sm text-[#cfd5df]">
                    Trạng thái
                </label>

                <select
                    name="status"
                    class="w-full rounded-2xl border border-white/10 bg-[#13161d] px-4 py-3 text-white">

                    <option value="1" @selected((string) old('status', (int) $comment->status) === '1')>
                        Hiển thị
                    </option>

                    <option value="0" @selected((string) old('status', (int) $comment->status) === '0')>
                        Ẩn
                    </option>

                </select>

            </div>

            <button
                type="submit"
                class="rounded-2xl bg-[#10a37f] px-5 py-3 text-sm font-semibold text-[#08110d] transition hover:brightness-110">

                {{ $isEdit ? 'Lưu thay đổi' : 'Tạo comment' }}

            </button>

        </form>

    </div>

</section>
@endsection