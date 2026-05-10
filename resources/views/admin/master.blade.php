<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('admin.layouts.head')
    <body>
        <div class="admin-frame">
            <div class="mx-auto max-w-[1600px] px-4 py-4 md:px-6 md:py-6">
                <div class="admin-panel grid min-h-[calc(100vh-2rem)] grid-cols-1 overflow-hidden lg:grid-cols-[280px_minmax(0,1fr)]">
                    @include('admin.layouts.sidebar')
                    <div class="flex min-w-0 flex-col">
                        @include('admin.layouts.header')
                        <main class="min-h-0 flex-1 overflow-auto px-4 pb-4 md:px-6 md:pb-6">
                            @if (session('status'))
                                <div class="mt-4 rounded-2xl border border-emerald-400/20 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-200">
                                    {{ session('status') }}
                                </div>
                            @endif
                            @yield('content')
                        </main>
                        @include('admin.layouts.footer')
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
