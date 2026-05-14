@php
    $fieldName = $name ?? 'image_upload';
    $currentImage = trim((string) ($value ?? ''));
    $currentImageUrl = \App\Support\ImageUpload::url($currentImage);
    $previewId = 'image-preview-'.md5($fieldName);
    $inputId = 'image-input-'.md5($fieldName);
@endphp

<div>
    <label class="mb-2 block text-sm text-[#cfd5df]">{{ $label ?? 'Ảnh' }}</label>

    <div id="{{ $previewId }}" class="mb-3 items-center gap-4" style="display: {{ $currentImageUrl ? 'flex' : 'none' }};">
        <img src="{{ $currentImageUrl }}" alt="" class="h-20 w-20 rounded-2xl border border-white/10 object-cover">
        <p data-preview-text class="text-xs text-[#8a93a3]">{{ $helpCurrent ?? 'Ảnh hiện tại. Chọn file mới bên dưới để thay.' }}</p>
    </div>

    <input id="{{ $inputId }}" type="file" name="{{ $fieldName }}" accept="image/jpeg,image/png,image/gif,image/webp" class="w-full rounded-2xl border border-dashed border-white/15 bg-white/5 px-4 py-3 text-sm text-[#cfd5df] file:mr-4 file:rounded-xl file:border-0 file:bg-admin-primary/20 file:px-4 file:py-2 file:text-sm file:font-medium file:text-admin-primary outline-none focus:border-admin-primary">
    <p class="mt-2 text-xs text-[#8a93a3]">{{ $help ?? 'JPEG, PNG, GIF hoặc WebP - tối đa 4MB.' }}</p>

    @error($fieldName)
        <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
    @enderror
</div>

<script>
    (() => {
        const imageInput = document.getElementById(@json($inputId));

        if (imageInput) {
            imageInput.addEventListener('change', function () {
                const file = this.files && this.files[0];
                const preview = document.getElementById(@json($previewId));

                if (! file || ! preview || ! file.type.startsWith('image/')) {
                    return;
                }

                const image = preview.querySelector('img');
                const text = preview.querySelector('[data-preview-text]');

                if (image) {
                    image.src = URL.createObjectURL(file);
                }

                if (text) {
                    text.textContent = 'Ảnh vừa chọn. Bấm lưu để cập nhật.';
                }

                preview.style.display = 'flex';
            });
        }
    })();
</script>
