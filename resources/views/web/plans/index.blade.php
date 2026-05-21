@extends('web.master', ['title' => 'Gói đăng ký'])

@section('content')
    <section class="mt-8 rounded-[2rem] border border-white/10 bg-white/[0.08] p-6 shadow-2xl shadow-violet-950/30 backdrop-blur-xl sm:p-8">
        <p class="text-xs font-bold uppercase tracking-[0.35em] text-fuchsia-200/80">Gói đăng ký</p>
        <h1 class="mt-3 text-4xl font-extrabold leading-tight">Nâng cấp tài khoản của bạn</h1>
        <p class="mt-3 max-w-2xl text-sm leading-6 text-violet-100/75">
            Đăng ký gói VIP để nghe không giới hạn các bài hát VIP và tắt hoàn toàn quảng cáo.
        </p>
    </section>

    @if ($hasActiveSubscription && $currentSubscription)
        <section class="mt-6 rounded-2xl border border-emerald-400/30 bg-emerald-500/10 p-4 text-sm text-emerald-100">
            Bạn đang sử dụng gói <strong>{{ $currentSubscription->plan->name }}</strong>.
            Hạn sử dụng đến: <strong>{{ $currentSubscription->expires_at->format('d/m/Y') }}</strong>.
            Đăng ký thêm sẽ gia hạn thời gian sử dụng.
        </section>
    @endif

    @if (session('message'))
        <div class="mt-6 rounded-2xl border {{ session('status') === 'error' ? 'border-red-400/30 bg-red-500/15 text-red-100' : 'border-emerald-400/30 bg-emerald-500/15 text-emerald-100' }} p-4 text-sm">
            {{ session('message') }}
        </div>
    @endif

    <section class="mt-8 grid gap-6 sm:grid-cols-2 xl:grid-cols-4">
        @foreach ($plans as $plan)
            <div class="relative flex flex-col rounded-[2rem] border border-white/10 bg-black/20 p-6 backdrop-blur-xl transition hover:border-fuchsia-400/40 hover:bg-white/[0.06]">
                @if ($plan->duration_days >= 365)
                    <span class="absolute -top-2 right-4 rounded-full bg-linear-to-r from-yellow-500 to-amber-500 px-3 py-0.5 text-[10px] font-bold text-black uppercase">Tiết kiệm nhất</span>
                @endif

                <div class="flex-1">
                    <p class="text-xs font-bold uppercase tracking-[0.28em] text-violet-200/70">{{ $plan->name }}</p>

                    <p class="mt-3 text-3xl font-black text-white">
                        {{ number_format($plan->price, 0, ',', '.') }}₫
                    </p>

                    <p class="mt-1 text-xs text-white/50">
                        {{ number_format($plan->price / $plan->duration_days, 0, ',', '.') }}₫ / ngày
                    </p>
                </div>

                <ul class="mt-5 space-y-2 text-sm text-white/70">
                    <li class="flex items-center gap-2">
                        <span class="text-fuchsia-300">✓</span>
                        Nghe không giới hạn
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-fuchsia-300">✓</span>
                        Không quảng cáo
                    </li>
                    @if ($plan->is_vip ?? false)
                        <li class="flex items-center gap-2">
                            <span class="text-yellow-300">★</span>
                            Truy cập bài hát VIP
                        </li>
                    @else
                        <li class="flex items-center gap-2">
                            <span class="text-yellow-300">★</span>
                            Truy cập bài hát VIP
                        </li>
                    @endif
                    <li class="flex items-center gap-2">
                        <span class="text-fuchsia-300">✓</span>
                        Thời hạn: {{ $plan->duration_days }} ngày
                    </li>
                </ul>

                <form action="{{ route('plans.subscribe', $plan->id) }}" method="POST" class="mt-6">
                    @csrf
                    <button type="submit" class="w-full rounded-full bg-gradient-to-r from-fuchsia-500 to-violet-500 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-fuchsia-950/40 transition hover:brightness-110">
                        Đăng ký ngay
                    </button>
                </form>
            </div>
        @endforeach
    </section>
@endsection
