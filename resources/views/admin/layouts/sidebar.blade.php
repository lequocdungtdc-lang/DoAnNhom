<aside class="border-b border-white/8 bg-[#13161d] lg:border-b-0 lg:border-r">
    <div class="flex h-full flex-col p-4 md:p-5">
        <div class="mb-6 flex items-center gap-3 px-2 pt-1">
            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-[#10a37f] font-semibold text-[#08110d]">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 18V5l12-2v13M9 18a3 3 0 1 1-6 0a3 3 0 0 1 6 0Zm12-2a3 3 0 1 1-6 0a3 3 0 0 1 6 0Z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-white">Quản trị hiện đại</p>
                <p class="text-xs text-[#8a93a3]">Gọn, rõ và tập trung</p>
            </div>
        </div>

        <nav class="space-y-1.5">
            <a href="{{ route('admin.dashboard') }}" class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'admin-nav-link-active' : '' }}">
                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-black/20">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.2c0-.63 0-.945.073-1.24a2 2 0 0 1 .313-.668c.18-.244.43-.438.93-.826l5.5-4.278c.82-.638 1.23-.957 1.684-1.08a2 2 0 0 1 1 0c.454.123.864.442 1.684 1.08l5.5 4.278c.5.388.75.582.93.826a2 2 0 0 1 .313.668c.073.295.073.61.073 1.24V18a2 2 0 0 1-2 2h-3v-4.5a1.5 1.5 0 0 0-1.5-1.5h-3A1.5 1.5 0 0 0 9 15.5V20H6a2 2 0 0 1-2-2v-4.8Z" />
                    </svg>
                </span>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('admin.users.index') }}" class="admin-nav-link {{ request()->routeIs('admin.users.*') ? 'admin-nav-link-active' : '' }}">
                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-black/20">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 21v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2m18 0v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75M14 7a4 4 0 1 1-8 0a4 4 0 0 1 8 0Z" />
                    </svg>
                </span>
                <span>Người dùng</span>
            </a>

            <a href="{{ route('admin.categories.index') }}" class="admin-nav-link {{ request()->routeIs('admin.categories.*') ? 'admin-nav-link-active' : '' }}">
                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-black/20">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 7.5A2.5 2.5 0 0 1 6.5 5h11A2.5 2.5 0 0 1 20 7.5v9A2.5 2.5 0 0 1 17.5 19h-11A2.5 2.5 0 0 1 4 16.5v-9ZM9 5v14" />
                    </svg>
                </span>
                <span>Thể loại</span>
            </a>

            <a href="{{ route('admin.songs.index') }}" class="admin-nav-link {{ request()->routeIs('admin.songs.*') ? 'admin-nav-link-active' : '' }}">
                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-black/20">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 18V5l10-2v13M9 18a2 2 0 1 1-4 0a2 2 0 0 1 4 0Zm10-2a2 2 0 1 1-4 0a2 2 0 0 1 4 0Z" />
                    </svg>
                </span>
                <span>Bài hát</span>
            </a>

            <a href="{{ route('admin.artists.index') }}" class="admin-nav-link {{ request()->routeIs('admin.artists.*') ? 'admin-nav-link-active' : '' }}">
                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-black/20">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 21v-2.5a3.5 3.5 0 0 0-3.5-3.5h-3A3.5 3.5 0 0 0 7 18.5V21m10-11a5 5 0 1 1-10 0a5 5 0 0 1 10 0Z" />
                    </svg>
                </span>
                <span>Nghệ sĩ</span>
            </a>

            <a href="{{ route('admin.albums.index') }}" class="admin-nav-link {{ request()->routeIs('admin.albums.*') ? 'admin-nav-link-active' : '' }}">
                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-black/20">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6.8A2.8 2.8 0 0 1 6.8 4h10.4A2.8 2.8 0 0 1 20 6.8v10.4A2.8 2.8 0 0 1 17.2 20H6.8A2.8 2.8 0 0 1 4 17.2V6.8Zm5.5 5.2A2.5 2.5 0 1 0 12 9.5a2.5 2.5 0 0 0-2.5 2.5Z" />
                    </svg>
                </span>
                <span>Album</span>
            </a>
            <a href="{{ route('admin.subscriptions.index') }}" class="admin-nav-link {{ request()->routeIs('admin.subscriptions.*') ? 'admin-nav-link-active' : '' }}">
                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-black/20">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <!-- crown icon -->
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 16l1.5-8 5.5 4 5.5-4L19 16H5Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 19h14" />
                        <circle cx="6.5" cy="8" r="1" />
                        <circle cx="12" cy="12" r="1" />
                        <circle cx="17.5" cy="8" r="1" />
                    </svg>
                </span>
                <span>Subscription</span>
            </a>
            <a href="{{ route('admin.podcasts.index') }}" class="admin-nav-link {{ request()->routeIs('admin.podcasts.*') ? 'admin-nav-link-active' : '' }}">
                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-black/20">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 15a3 3 0 0 0 3-3V7a3 3 0 1 0-6 0v5a3 3 0 0 0 3 3Zm0 0v4m-4-4a4 4 0 0 0 8 0m-8 0H5m11 0h3" />
                    </svg>
                </span>
                <span>Podcast</span>
            </a>
        </nav>

        <div class="mt-auto pt-6">
            <a href="{{ route('home') }}" class="admin-nav-link">
                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-black/20">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m15 18-6-6 6-6" />
                    </svg>
                </span>
                <span>Quay lại trang web</span>
            </a>
        </div>
    </div>
</aside>