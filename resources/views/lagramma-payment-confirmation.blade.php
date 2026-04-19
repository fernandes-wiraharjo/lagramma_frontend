@php
    $items = $checkoutData ?? [];
    $itemCount = count($items);
    $subtotal = $order->order_price;
    $totalWeight = collect($items)->sum('total_weight');
    $hasAddress = auth()->user()->addresses->count() > 0;
@endphp

@extends('layouts.master')

@section('title', 'Payment Confirmation')

@section('content')
    <div class="position-relative checkout-page-wrapper">
        <div class="container container-1440">
            {{-- Top Section --}}
            <div class="row breadcrumb-spacing">
                {{-- Bread Crumbs --}}
                <div class="col-12 col-md-6">
                    <div>Home > Shop > Cart > Checkout > Payment</div>
                </div>
            </div>

            {{-- TODO: change breadcrumb to this format --}}
            {{-- <div class="d-flex align-items-center justify-content-start mb-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-light justify-content-center mb-0 fs-15" style="color: black;">
                        <li class="breadcrumb-item"><a href="#!">Shop</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Payment</li>
                    </ol>
                </nav>
            </div> --}}
            <a href="/" class="btn-hover w-20 py-2 px-4 mb-3 lagramma-button-solid rounded-4">
                < Back To Shop</a>
        </div>
    </div>

    <div class="container container-1440 pb-4">
        <div class="row">
            <section class="col-xl-7 pe-5">
                <x-payment-info :order="$order" :orderPayment="$orderPayment" :bankAccounts="$bankAccounts" />
            </section>

            <section class="col-xl-5">
                <x-order-summary :subtotal="$subtotal"/>
            </section>
        </div>
    </div>

    <section class="page-wrapper bg-primary">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center d-flex align-items-center justify-content-between">
                        <h4 class="text-white mb-0">Payment Confirmation</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-light justify-content-center mb-0 fs-15">
                                <li class="breadcrumb-item"><a href="#!">Shop</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Payment</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section pb-4">
        <div class="container">
            {{--
            @if (session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
            --}}

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="row">
                <div class="col-lg-8">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5>Order #{{ $order->invoice_number }}</h5>
                            <p>Order total: <strong>IDR{{ number_format($order->order_price, 0, ',', '.') }}</strong></p>

                            <div class="mb-3">
                                <h6>Unique Code (3 digits)</h6>
                                <p class="fs-18 fw-bold">{{ $orderPayment->unique_code }}</p>
                                <small class="text-muted">Please transfer the exact amount including the unique code so we
                                    can automatically match your payment.</small>
                            </div>

                            <div class="mb-3">
                                <h6>Total to Transfer</h6>
                                <p class="fs-20 fw-bold">
                                    {{-- assuming integer currency (e.g. IDR) --}}
                                    IDR{{ number_format($transferAmount, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Bank account info --}}
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5>Bank Account Info</h5>
                            @foreach ($bankAccounts as $bank)
                                <div class="mb-2">
                                    <strong>{{ $bank['bank'] }}</strong><br>
                                    {{ $bank['account_name'] }}<br>
                                    Account No: <strong>{{ $bank['account_number'] }}</strong>
                                    {{-- @if (!empty($bank['branch'])) <div class="text-muted">{{ $bank['branch'] }}</div> @endif --}}
                                </div>
                                <hr>
                            @endforeach
                        </div>
                    </div>

                    {{-- Upload proof form --}}
                    <div class="card">
                        <div class="card-body">
                            <h5>Upload Payment Proof</h5>

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
                                    <label class="form-label">Sender Name</label>
                                    <input type="text" name="payer_name" class="form-control"
                                        value="{{ old('payer_name', $orderPayment->payer_name) }}"
                                        {{ $orderPayment->status === 'APPROVED' ? 'disabled' : '' }}>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Sender Account Number</label>
                                    <input type="text" name="payer_account_number" class="form-control"
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
                                    <label class="form-label">Proof of Payment (jpg, jpeg, png, pdf) — max 5MB</label>

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
                                        <input type="file" name="proof_file" class="form-control"
                                            accept=".jpg,.jpeg,.png,.pdf"
                                            {{ $orderPayment->status === 'APPROVED' ? 'disabled' : '' }}>
                                    </div>
                                </div>

                                <div class="d-flex gap-2" id="payment-action-buttons">
                                    {{-- Default content while waiting for userRole --}}
                                    <div class="text-muted">Loading actions...</div>
                                    {{-- @if ($orderPayment->status !== 'APPROVED')
                                        <button type="submit" class="btn btn-primary">Upload & Submit</button>
                                    @endif --}}

                                    {{-- Skip button: lets user proceed without uploading now --}}
                                    {{-- <a href="{{ config('app.backend_url') }}/orders" class="btn btn-outline-secondary">
                                        Skip for now
                                    </a> --}}

                                    {{-- Optionally add a "Edit later" note --}}
                                    {{-- <div class="ms-auto text-muted align-self-center">
                                        You can upload or edit payment proof later from <a href="{{ config('app.backend_url') }}/orders">My Orders</a> until admin approves.
                                    </div> --}}
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- order summary right column --}}
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5>Order Summary</h5>
                            <div class="mb-2">Items: {{ $order->order_quantity }}</div>
                            <div class="mb-2">Subtotal: IDR{{ number_format($order->order_price, 0, ',', '.') }}</div>
                            <div class="mb-2">Unique code: {{ $orderPayment->unique_code }}</div>
                            <hr>
                            <div class="fs-18 fw-bold">Total: IDR{{ number_format($transferAmount, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Wait until userRole is available (from layout script)
            const checkUserRole = setInterval(() => {
                clearInterval(checkUserRole);
                const container = document.getElementById('payment-action-buttons');

                if (userRole === 'admin') {
                    const invoiceNumber = @json($order->invoice_number);
                    // alert(invoiceNumber);

                    // Admin view: Approve & Reject buttons
                    container.innerHTML = `
                     @if ($orderPayment->status !== 'APPROVED')
                        <button type="button" class="btn btn-success" id="approve-btn">
                            <span class="btn-text">Approve</span>
                            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        </button>
                        <button type="button" class="btn btn-danger" id="reject-btn">
                            <span class="btn-text">Reject</span>
                            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        </button>
                    @endif
                `;

                    // Helper function to show loader
                    function showLoader(button, isLoading) {
                        const text = button.querySelector('.btn-text');
                        const spinner = button.querySelector('.spinner-border');
                        if (isLoading) {
                            text.textContent = 'Processing...';
                            spinner.classList.remove('d-none');
                            button.disabled = true;
                        } else {
                            text.textContent = button.id === 'approve-btn' ? 'Approve' : 'Reject';
                            spinner.classList.add('d-none');
                            button.disabled = false;
                        }
                    }

                    document.querySelector('#approve-btn').addEventListener('click', async function() {
                        const xsrfToken = await getCSRFToken();
                        const btn = this;
                        showLoader(btn, true);

                        try {
                            const response = await fetch(
                                `${backendUrl}/api/payments/${invoiceNumber}/approve`, {
                                    method: 'POST',
                                    headers: {
                                        'Accept': 'application/json',
                                        'X-XSRF-TOKEN': xsrfToken
                                    },
                                    credentials: 'include'
                                });
                            const data = await response.json();
                            alert(data.message);
                            window.location.reload();
                        } catch (err) {
                            alert('Failed to approve payment.');
                            showLoader(btn, false);
                        }
                    });

                    document.querySelector('#reject-btn').addEventListener('click', async function() {
                        const xsrfToken = await getCSRFToken();
                        const btn = this;
                        showLoader(btn, true);

                        try {
                            const response = await fetch(
                                `${backendUrl}/api/payments/${invoiceNumber}/reject`, {
                                    method: 'POST',
                                    headers: {
                                        'Accept': 'application/json',
                                        'X-XSRF-TOKEN': xsrfToken
                                    },
                                    credentials: 'include'
                                });
                            const data = await response.json();
                            alert(data.message);
                            window.location.reload();
                        } catch (err) {
                            alert('Failed to reject payment.');
                            showLoader(btn, false);
                        }
                    });
                } else if (userRole === '' || userRole === 'customer') {
                    // Customer view: Upload & Submit / Skip
                    container.innerHTML = `
                    <div class="d-flex gap-2">
                        @if ($orderPayment->status !== 'APPROVED')
                            <button type="submit" class="rounded-4 solid-border py-3 w-100 lagramma-button-solid solid-border">Upload & Submit</button>
                        @endif

                        <a href="{{ config('app.backend_url') }}/orders" class="text-center rounded-4 lagramma-button-outline solid-border py-3 w-100">
                            Skip for now
                        </a>
                    </div>

                    <div class="ms-auto text-danger align-self-center mt-2 fst-italic">
                        You can upload or edit payment proof later from
                        <a href="{{ config('app.backend_url') }}/orders" class="text-danger fst-bold">My Orders</a> until admin approves.
                    </div>
                `;
                }
            }, 200); // check every 200ms until userRole is fetched
        });
    </script>
@endsection
