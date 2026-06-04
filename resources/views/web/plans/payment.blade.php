@extends('web.master', ['title' => 'Thanh toán VNPay'])

@section('content')    <div class="mt-8 grid gap-6 lg:grid-cols-2">
        {{-- Thông tin đơn hàng --}}
        <div class="rounded-[2rem] border border-white/10 bg-white/[0.08] p-6 backdrop-blur-xl shadow-2xl shadow-violet-950/30">
            <div class="flex items-center gap-3 border-b border-white/10 pb-4">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#A50064]">
                    <span class="text-sm font-bold text-white">VN</span>
                </div>
                <div>
                    <p class="font-bold text-white">VNPay</p>
                    <p class="text-xs text-white/50">Thanh toán an toàn qua VNPay</p>
                </div>
            </div>

            <div class="mt-5 space-y-4">
                <div class="flex justify-between text-sm">
                    <span class="text-white/50">Mã giao dịch</span>
                    <span class="font-mono text-white">{{ $orderId }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-white/50">Tên gói</span>
                    <span class="font-semibold text-white">{{ $plan->name }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-white/50">Thời hạn</span>
                    <span class="text-white">{{ $plan->duration_days }} ngày</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-white/50">Nội dung</span>
                    <span class="text-white">{{ $orderInfo }}</span>
                </div>
                <div class="flex justify-between border-t border-white/10 pt-4">
                    <span class="font-semibold text-white">Số tiền thanh toán</span>
                    <span class="text-xl font-black text-fuchsia-300">{{ number_format($amount, 0, ',', '.') }}₫</span>
                </div>
            </div>

            <div class="mt-6 rounded-xl border border-yellow-400/20 bg-yellow-500/10 p-3 text-xs text-yellow-200">
                <span class="font-semibold">Lưu ý:</span> Đây là môi trường giả lập VNPay. Nhấn "Thanh toán thành công" để mô phỏng thanh toán thành công.
            </div>
        </div>

        {{-- Phương thức thanh toán --}}
        <div class="rounded-[2rem] border border-white/10 bg-white/[0.08] p-6 backdrop-blur-xl shadow-2xl shadow-violet-950/30">
            <p class="text-xs font-bold uppercase tracking-[0.28em] text-violet-200/70">Phương thức thanh toán</p>

            <div class="mt-5 space-y-3">
                {{-- QR Code --}}
                <label class="payment-method flex cursor-pointer items-center gap-4 rounded-2xl border border-white/10 p-4 transition hover:bg-white/5 has-[:checked]:border-fuchsia-400/50 has-[:checked]:bg-fuchsia-500/10">
                    <input type="radio" name="payment_method" value="qr" class="hidden" checked>
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data=VNPay://pay?order={{ $orderId }}&amount={{ $amount }}" alt="QR Code" class="h-10 w-10 rounded object-contain">
                    </div>
                    <div>
                        <p class="font-semibold text-white">Quét mã QR</p>
                        <p class="text-xs text-white/50">Mở ứng dụng ngân hàng & quét mã</p>
                    </div>
                </label>

                {{-- ATM Card --}}
                <label class="payment-method flex cursor-pointer items-center gap-4 rounded-2xl border border-white/10 p-4 transition hover:bg-white/5 has-[:checked]:border-fuchsia-400/50 has-[:checked]:bg-fuchsia-500/10">
                    <input type="radio" name="payment_method" value="atm" class="hidden">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-600 text-lg font-bold text-white">ATM</div>
                    <div>
                        <p class="font-semibold text-white">Thẻ ATM / Internet Banking</p>
                        <p class="text-xs text-white/50">Thẻ nội địa các ngân hàng Việt Nam</p>
                    </div>
                </label>

                {{-- Credit Card --}}
                <label class="payment-method flex cursor-pointer items-center gap-4 rounded-2xl border border-white/10 p-4 transition hover:bg-white/5 has-[:checked]:border-fuchsia-400/50 has-[:checked]:bg-fuchsia-500/10">
                    <input type="radio" name="payment_method" value="credit" class="hidden">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-orange-500 text-lg font-bold text-white">
                        <span class="text-sm">VISA</span>
                    </div>
                    <div>
                        <p class="font-semibold text-white">Thẻ quốc tế (Visa/Mastercard)</p>
                        <p class="text-xs text-white/50">Thẻ Visa, Mastercard, JCB</p>
                    </div>
                </label>

                {{-- Ví VNPay --}}
                <label class="payment-method flex cursor-pointer items-center gap-4 rounded-2xl border border-white/10 p-4 transition hover:bg-white/5 has-[:checked]:border-fuchsia-400/50 has-[:checked]:bg-fuchsia-500/10">
                    <input type="radio" name="payment_method" value="vnpay_wallet" class="hidden">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#A50064] text-sm font-bold text-white">W</div>
                    <div>
                        <p class="font-semibold text-white">Ví VNPay</p>
                        <p class="text-xs text-white/50">Sử dụng số dư trong ví VNPay</p>
                    </div>
                </label>
            </div>

            <div class="mt-6 space-y-3">
                <form action="{{ route('plans.vnpay.return') }}" method="GET" id="paymentForm">
                    <input type="hidden" name="vnp_ResponseCode" value="00">
                    <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                    <input type="hidden" name="orderId" value="{{ $orderId }}">
                    <input type="hidden" name="payment_method" id="selectedPaymentMethod" value="qr">
                    <button type="submit" class="w-full rounded-full bg-gradient-to-r from-emerald-500 to-green-500 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-emerald-950/40 transition hover:brightness-110">
                        ✓ Thanh toán thành công
                    </button>
                </form>

                <a href="{{ route('plans.vnpay.return', ['vnp_ResponseCode' => '24', 'plan_id' => $plan->id]) }}" class="block w-full rounded-full border border-white/10 px-6 py-3 text-center text-sm font-semibold text-white/60 transition hover:border-red-400/30 hover:text-red-200">
                    Hủy thanh toán
                </a>
            </div>

            <p class="mt-4 text-center text-xs text-white/30">
                <span class="text-[#A50064] font-semibold">VNPay</span> — Mô phỏng thanh toán
            </p>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('input[name="payment_method"]').forEach((radio) => {
            radio.addEventListener('change', function() {
                document.getElementById('selectedPaymentMethod').value = this.value;
            });
        });
    </script>
@endpush
