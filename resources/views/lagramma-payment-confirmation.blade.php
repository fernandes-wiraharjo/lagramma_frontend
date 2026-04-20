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
                <x-payment-info :order="$order" :orderPayment="$orderPayment" :bankAccounts="$bankAccounts" :transferAmount="$transferAmount" />
            </section>

            <section class="col-xl-5">
                <x-order-summary :subtotal="$subtotal" :uniqueCode="$orderPayment->unique_code" :transferAmount="$transferAmount" />
            </section>
        </div>
    </div>
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
