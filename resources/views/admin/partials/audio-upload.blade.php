@php
    $fieldName = $name ?? 'audio_upload';
    $currentAudio = trim((string) ($value ?? ''));
    $currentAudioUrl = $currentAudio !== '' ? \App\Support\AudioUpload::url($currentAudio) : null;
    $previewId = 'audio-preview-'.md5($fieldName);
    $inputId = 'audio-input-'.md5($fieldName);
@endphp

<div>
    <label class="mb-2 block text-sm text-[#cfd5df]">{{ $label ?? 'Tệp âm thanh' }}</label>

    <div id="{{ $previewId }}" class="mb-3" style="display: {{ $currentAudioUrl ? 'block' : 'none' }};">
        <audio src="{{ $currentAudioUrl }}" controls class="w-full"></audio>
        <p data-preview-text class="mt-2 text-xs text-[#8a93a3]">{{ $helpCurrent ?? 'Audio hiện tại. Chọn file MP3 mới bên dưới để thay.' }}</p>
    </div>

    <input id="{{ $inputId }}" type="file" name="{{ $fieldName }}" accept="audio/mpeg,audio/mp3,.mp3" class="w-full rounded-2xl border border-dashed border-white/15 bg-white/5 px-4 py-3 text-sm text-[#cfd5df] file:mr-4 file:rounded-xl file:border-0 file:bg-admin-primary/20 file:px-4 file:py-2 file:text-sm file:font-medium file:text-admin-primary outline-none focus:border-admin-primary">
    <p class="mt-2 text-xs text-[#8a93a3]">{{ $help ?? 'MP3 - tối đa 500MB.' }}</p>

    @error($fieldName)
        <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
    @enderror
</div>

<script>
    (() => {
        const audioInput = document.getElementById(@json($inputId));

        if (audioInput) {
            audioInput.addEventListener('change', function () {
                const file = this.files && this.files[0];
                const preview = document.getElementById(@json($previewId));

                if (! file || ! preview) {
                    return;
                }

                const audio = preview.querySelector('audio');
                const text = preview.querySelector('[data-preview-text]');

                if (audio) {
                    audio.src = URL.createObjectURL(file);
                }

                if (text) {
                    text.textContent = 'Audio vừa chọn. Bấm lưu để cập nhật.';
                }

                preview.style.display = 'block';
            });
        }
    })();
</script>
