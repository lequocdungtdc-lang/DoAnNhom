<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('web.layouts.head')
    <body class="min-h-screen bg-[#170f2f] text-white antialiased">
        <div class="min-h-screen bg-[radial-gradient(circle_at_top_left,_rgba(138,43,226,0.38),_transparent_30%),radial-gradient(circle_at_top_right,_rgba(236,72,153,0.25),_transparent_25%),linear-gradient(180deg,_#1b1239_0%,_#100b22_55%,_#090613_100%)] @hasSection('player') pb-32 @endif">
            <div class="mx-auto grid min-h-screen max-w-[1500px] grid-cols-1 lg:grid-cols-[260px_minmax(0,1fr)]">
                @include('web.layouts.sidebar')

                <div class="flex min-w-0 flex-col px-4 py-5 sm:px-6 lg:px-8">
                    @include('web.layouts.header')

                    <main class="min-w-0 flex-1">
                        @yield('content')
                    </main>

                    @include('web.layouts.footer')
                </div>
            </div>
        </div>

        <div id="webToast" class="pointer-events-none fixed right-4 top-4 z-[100] hidden max-w-sm rounded-2xl border px-4 py-3 text-sm shadow-2xl shadow-black/30 backdrop-blur-xl"></div>
        @yield('player')
        <script>
            window.showWebToast = function (message, status = 'success') {
                const toast = document.getElementById('webToast');

                if (!toast || !message) {
                    return;
                }

                toast.textContent = message;
                toast.className = [
                    'pointer-events-none fixed right-4 top-4 z-[100] max-w-sm rounded-2xl border px-4 py-3 text-sm shadow-2xl shadow-black/30 backdrop-blur-xl transition',
                    status === 'success'
                        ? 'border-emerald-400/30 bg-emerald-500/15 text-emerald-100'
                        : 'border-red-400/30 bg-red-500/15 text-red-100',
                ].join(' ');

                clearTimeout(window.webToastTimer);
                window.webToastTimer = setTimeout(() => {
                    toast.classList.add('hidden');
                }, 2600);
            };

            document.querySelectorAll('.favorite-toggle-form').forEach((form) => {
                form.addEventListener('submit', async (event) => {
                    event.preventDefault();

                    const button = form.querySelector('[data-favorite-button]');
                    button?.setAttribute('disabled', 'disabled');

                    try {
                        const response = await fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                            },
                        });

                        if (!response.ok) {
                            throw new Error('Không thể cập nhật yêu thích.');
                        }

                        const data = await response.json();
                        const sameSongForms = document.querySelectorAll(`.favorite-toggle-form[data-song-id="${form.dataset.songId}"]`);

                        sameSongForms.forEach((item) => {
                            const itemButton = item.querySelector('[data-favorite-button]');

                            if (!itemButton) {
                                return;
                            }

                            itemButton.textContent = data.liked ? '♥' : '♡';
                            itemButton.title = data.liked ? 'Bỏ yêu thích' : 'Thêm yêu thích';
                            itemButton.className = data.liked
                                ? itemButton.dataset.likedClass
                                : itemButton.dataset.unlikedClass;
                        });

                        if (!data.liked && form.dataset.removeOnUnlike === 'true') {
                            form.closest('[data-favorite-row]')?.remove();

                            const count = document.getElementById('favoriteSongCount');
                            if (count) {
                                count.textContent = document.querySelectorAll('[data-favorite-row]').length;
                            }

                            if (!document.querySelector('[data-favorite-row]')) {
                                document.getElementById('favoriteEmptyState')?.classList.remove('hidden');
                            }
                        }

                        window.showWebToast(data.message, 'success');
                    } catch (error) {
                        window.showWebToast(error.message || 'Có lỗi xảy ra, vui lòng thử lại.', 'error');
                    } finally {
                        button?.removeAttribute('disabled');
                    }
                });
            });

            @if (session('message'))
                window.showWebToast(@json(session('message')), @json(session('status') ?? 'success'));
            @endif

            // AJAX Add to Playlist
            document.querySelectorAll('.add-to-playlist-btn').forEach((btn) => {
                btn.addEventListener('click', async function() {
                    const wrapper = this.closest('.add-to-playlist-wrapper');
                    const songId = wrapper.dataset.songId;
                    const select = wrapper.querySelector('.playlist-select');
                    const playlistId = select.value;

                    if (!playlistId) {
                        window.showWebToast('Vui lòng chọn playlist.', 'error');
                        return;
                    }

                    const selectedOption = select.options[select.selectedIndex];
                    if (selectedOption.dataset.added === '1') {
                        window.showWebToast('Bài hát đã có trong playlist này.', 'info');
                        return;
                    }

                    btn.disabled = true;
                    btn.textContent = '...';

                    try {
                        const response = await fetch(`/playlists/songs/${songId}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify({ playlist_id: playlistId })
                        });

                        const data = await response.json();

                        if (response.ok && data.status === 'success') {
                            selectedOption.dataset.added = '1';
                            selectedOption.textContent = selectedOption.textContent.replace(' ✓', '') + ' ✓';
                            window.showWebToast(data.message, 'success');
                        } else {
                            window.showWebToast(data.message || 'Có lỗi xảy ra.', 'error');
                        }
                    } catch (error) {
                        window.showWebToast('Có lỗi xảy ra. Vui lòng thử lại.', 'error');
                    } finally {
                        btn.disabled = false;
                        btn.textContent = 'Thêm';
                    }
                });
            });
        </script>
        @stack('scripts')
    </body>
</html>
