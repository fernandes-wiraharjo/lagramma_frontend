<div class="row">
    <div class="col-12">
        <h2 class="lagramma-green-font"
            style="border-bottom: 2px solid #0c3e3c; font-weight: 700; font-size: 1.5rem; padding-bottom: 16px;">
            Payment Info</h2>

        <div>
            Order ID <strong>{{ $order->invoice_number }}</strong><br>
            Order Total <strong>IDR{{ number_format($order->order_price, 0, ',', '.') }}</strong><br>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card overflow-hidden rounded-4 shadow-blur p-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="fs-18 fw-bold">Unique Code</div>
                <div class="fs-18 fw-bold">{{ $orderPayment->unique_code }}</div>
            </div>
            <small class="fs-14">Please transfer the exact amount including the unique code so we can automatically
                match your payment.</small>
        </div>

        <div class="card overflow-hidden rounded-4 shadow-blur p-4">
            <h5>Bank Account Info</h5>
            @foreach ($bankAccounts as $bank)
                <div class="mb-2">
                    <strong>{{ $bank['bank'] }}</strong><br>
                    {{ $bank['account_name'] }}<br>
                    Account No: <strong>{{ $bank['account_number'] }}</strong>
                    {{-- @if (!empty($bank['branch'])) <div class="text-muted">{{ $bank['branch'] }}</div> @endif --}}
                </div>
            @endforeach
        </div>

        <div>
            <h2 class="lagramma-green-font"
                style="border-bottom: 2px solid #0c3e3c; font-weight: 700; font-size: 1.5rem; padding-bottom: 16px;">Upload Payment Proof</h2>

            @if ($orderPayment->status === 'APPROVED')
                <div class="alert alert-success">Payment already approved by admin.</div>
            @elseif($orderPayment->status === 'REJECTED')
                <div class="alert alert-danger">Payment is rejected by admin, please reupload or contact
                    admin.</div>
            @endif

            <form
                action="{{ route('payment.confirmation.upload', ['invoiceNo' => $order->invoice_number]) }}"
                method="post" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="payer_name" class="form-control"
                        value="{{ old('payer_name', $orderPayment->payer_name) }}"
                        {{ $orderPayment->status === 'APPROVED' ? 'disabled' : '' }}>
                </div>
            </form>
        </div>
    </div>
</div>
