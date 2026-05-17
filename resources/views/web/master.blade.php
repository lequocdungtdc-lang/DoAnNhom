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
                        @if (session('message'))
                            <div class="
                                mt-6 rounded-2xl border px-4 py-3 text-sm
                                {{ session('status') === 'success'
                                    ? 'border-emerald-400/30 bg-emerald-500/10 text-emerald-200'
                                    : 'border-red-400/30 bg-red-500/10 text-red-200'
                                }}
                            ">
                                {{ session('message') }}
                            </div>
                        @endif

                        @yield('content')
                    </main>

                    @include('web.layouts.footer')
                </div>
            </div>
        </div>

        @yield('player')
        @stack('scripts')
    </body>
</html>
