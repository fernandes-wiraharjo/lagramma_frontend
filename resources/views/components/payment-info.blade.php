<div class="row">
    <div class="col-12">
        <h2 class="lagramma-green-font"
            style="border-bottom: 2px solid #0c3e3c; font-weight: 700; font-size: 1.5rem; padding-bottom: 16px;">
            Payment Info</h2>

        <div class="pt-2 pb-4 fs-18">
            <div class="row">
                <div class="col-md-6" style="font-weight: 700;">
                    Order ID
                </div>
                <div class="col-md-6">
                    {{ $order->invoice_number }}
                </div>
            </div>
            <div class="row">
                <div class="col-md-6" style="font-weight: 700;">
                    Order Total
                </div>
                <div class="col-md-6">
                    Rp {{ number_format($order->order_price, 0, ',', '.') }}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card overflow-hidden rounded-4 shadow-blur p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="fs-18 fw-bold">Unique Code</div>
                <div class="fs-18 fw-bold">{{ $orderPayment->unique_code }}</div>
            </div>
            <small class="fs-14">Please transfer the exact amount including the unique code so we can automatically
                match your payment.</small>
        </div>

        <div class="card overflow-hidden rounded-4 shadow-blur p-4">
            @foreach ($bankAccounts as $bank)
                <div class="mb-2">
                    <x-bank-icon :bank="$bank" class="mb-1" /><br>

                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div>
                            <div class="fs-18 fw-bold">{{ $bank['account_name'] }}</div>
                            <div class="py-2">
                                <span class="lagramma-button-solid rounded-4 fs-18 fw-bold py-2 px-3 copy-btn"
                                    role="button" tabindex="0"
                                    data-copy="{{ $bank['account_number'] }}"
                                    title="Copy account number">
                                    <img src="{{ URL::asset('build/images/assets/iconamoon_copy.svg') }}" alt="Copy"
                                        class="me-1" width="20">
                                    <span>{{ $bank['account_number'] }}</span>
                                </span>
                            </div>
                        </div>
                        <div>
                            <div class="fs-18 fw-bold text-end lagramma-green-font">Total Transfer</div>
                            <div class="py-2">
                                <span class="lagramma-button-solid rounded-4 fs-18 fw-bold py-2 px-3 copy-btn"
                                    role="button" tabindex="0"
                                    data-copy="{{ $transferAmount }}"
                                    title="Copy transfer amount">
                                    <img src="{{ URL::asset('build/images/assets/iconamoon_copy.svg') }}" alt="Copy"
                                        class="me-1" width="20">
                                    <span>Rp {{ number_format($transferAmount, 0, ',', '.') }}</span>
                                </span>
                            </div>
                        </div>
                    </div>
                    {{-- @if (!empty($bank['branch'])) <div class="text-muted">{{ $bank['branch'] }}</div> @endif --}}
                </div>
            @endforeach
        </div>

        <div>
            <h2 class="lagramma-green-font"
                style="border-bottom: 2px solid #0c3e3c; font-weight: 700; font-size: 1.5rem; padding-bottom: 16px;">
                Upload Payment Proof</h2>

            @if ($orderPayment->status === 'APPROVED')
                <div class="alert alert-success">Payment already approved by admin.</div>
            @elseif($orderPayment->status === 'REJECTED')
                <div class="alert alert-danger">Payment is rejected by admin, please reupload or contact
                    admin.</div>
            @endif

            <form action="{{ route('payment.confirmation.upload', ['invoiceNo' => $order->invoice_number]) }}"
                method="post" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label" style="color: #0C3E3C; font-size: 1.25rem; font-weight: 400;">Name</label>
                    <input type="text" name="payer_name" class="form-control checkout-form-input shadow-blur"
                        value="{{ old('payer_name', $orderPayment->payer_name) }}"
                        {{ $orderPayment->status === 'APPROVED' ? 'disabled' : '' }}>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="color: #0C3E3C; font-size: 1.25rem; font-weight: 400;">Account
                        Number</label>
                    <input type="text" name="payer_account_number"
                        class="form-control checkout-form-input shadow-blur"
                        value="{{ old('payer_account_number', $orderPayment->payer_account_number) }}"
                        {{ $orderPayment->status === 'APPROVED' ? 'disabled' : '' }}>
                </div>

                @php
                    $filePath = $orderPayment->proof_file;
                    $fileUrl = null;

                    if ($filePath) {
                        $fileUrl = app()->environment('local')
                            ? asset('storage/' . $filePath)
                            : asset('public/storage/' . $filePath);

                        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                    }
                @endphp

                <div class="mb-3">
                    <label class="form-label" style="color: #0C3E3C; font-size: 1.25rem; font-weight: 400;">Proof of Payment (jpg, jpeg, png, pdf) — max 5MB</label>

                    @if ($filePath)
                        <div class="card mt-2" style="max-width: 600px;">
                            <div class="card-body">
                                <h6 class="card-title mb-3">Current Proof</h6>

                                @if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png']))
                                    {{-- Show image preview --}}
                                    <img src="{{ $fileUrl }}" alt="Proof of Payment"
                                        class="img-fluid rounded border"
                                        style="max-height: 400px; width: 100%; object-fit: contain;">
                                @elseif(strtolower($extension) === 'pdf')
                                    {{-- Embed PDF --}}
                                    <iframe src="{{ $fileUrl }}" width="100%" height="400"
                                        class="border rounded"></iframe>
                                @else
                                    {{-- Fallback for other types --}}
                                    <p>
                                        <a href="{{ $fileUrl }}" target="_blank"
                                            class="btn btn-outline-primary btn-sm">
                                            View / Download File
                                        </a>
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endif

                    <div class="mt-3">
                        <input type="file" name="proof_file" class="form-control" accept=".jpg,.jpeg,.png,.pdf"
                            {{ $orderPayment->status === 'APPROVED' ? 'disabled' : '' }}>
                    </div>
                </div>

                <div id="payment-action-buttons" class="d-flex gap-3">
                    {{-- Default content while waiting for userRole --}}
                    <div class="text-muted">Loading actions...</div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function copyToClipboard(text) {
        if (navigator.clipboard && window.isSecureContext) {
            return navigator.clipboard.writeText(text);
        } else {
            var textarea = document.createElement('textarea');
            textarea.value = text;
            textarea.style.position = 'fixed';
            textarea.style.left = '-9999px';
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand('copy');
            document.body.removeChild(textarea);
            return Promise.resolve();
        }
    }

    document.querySelectorAll('.copy-btn').forEach(function(btn) {
        btn.style.cursor = 'pointer';
        btn.addEventListener('click', function() {
            var value = this.getAttribute('data-copy');
            var span = this.querySelector('span');
            var original = span.textContent;
            copyToClipboard(value).then(function() {
                span.textContent = 'Copied!';
                setTimeout(function() { span.textContent = original; }, 1500);
            });
        });
    });
</script>
