@extends('layouts.master')

@section('title', 'Payment Confirmation')

@section('content')
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
        <!-- @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif -->
        @if(session('error'))
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
                            <small class="text-muted">Please transfer the exact amount including the unique code so we can automatically match your payment.</small>
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
                        @foreach($bankAccounts as $bank)
                            <div class="mb-2">
                                <strong>{{ $bank['bank'] }}</strong><br>
                                {{ $bank['account_name'] }}<br>
                                Account No: <strong>{{ $bank['account_number'] }}</strong>
                                <!-- @if(!empty($bank['branch']))<div class="text-muted">{{ $bank['branch'] }}</div>@endif -->
                            </div>
                            <hr>
                        @endforeach
                    </div>
                </div>

                {{-- Upload proof form --}}
                <div class="card">
                    <div class="card-body">
                        <h5>Upload Payment Proof</h5>

                        @if($orderPayment->status === 'APPROVED')
                            <div class="alert alert-success">Payment already approved by admin.</div>
                        @endif

                        <form action="{{ route('payment.confirmation.upload', ['invoiceNo' => $order->invoice_number]) }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Sender Name</label>
                                <input type="text" name="payer_name" class="form-control" value="{{ old('payer_name', $orderPayment->payer_name) }}" {{ $orderPayment->status === 'APPROVED' ? 'disabled' : '' }}>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Sender Account Number</label>
                                <input type="text" name="payer_account_number" class="form-control" value="{{ old('payer_account_number', $orderPayment->payer_account_number) }}" {{ $orderPayment->status === 'APPROVED' ? 'disabled' : '' }}>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Proof of Payment (jpg, png, pdf) — max 5MB</label>
                                @if($orderPayment->proof_file)
                                    <div class="mb-2">
                                        Current proof:
                                        <a href="{{ asset('storage/' . $orderPayment->proof_file) }}" target="_blank">View file</a>
                                    </div>
                                @endif
                                <input type="file" name="proof_file" class="form-control" {{ $orderPayment->status === 'APPROVED' ? 'disabled' : '' }}>
                            </div>

                            <div class="d-flex gap-2">
                                @if($orderPayment->status !== 'APPROVED')
                                    <button type="submit" class="btn btn-primary">Upload & Submit</button>
                                @endif

                                {{-- Skip button: lets user proceed without uploading now --}}
                                <a href="{{ config('app.backend_url') }}/orders" class="btn btn-outline-secondary">
                                    Skip for now
                                </a>

                                {{-- Optionally add a "Edit later" note --}}
                                <div class="ms-auto text-muted align-self-center">
                                    You can upload or edit payment proof later from <a href="{{ config('app.backend_url') }}/orders">My Orders</a> until admin approves.
                                </div>
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
