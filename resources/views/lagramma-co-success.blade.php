@extends('layouts.master')
@section('title')
    Order Completed
@endsection
@section('css')
    <style>
        .action-button {
            width: 320px;
        }
        .checkout-success-section {
            padding-top: 40px;
            padding-bottom: 40px;
        }
        .checkout-success-breadcrumb {
            font-size: 1.25rem;
            font-weight: 400;
            padding-bottom: 20px;
        }
        .checkout-success-title {
            font-size: 2.5rem;
            font-weight: 700;
        }
        .checkout-success-invoice {
            font-size: 2rem;
            font-weight: 300;
        }
        .checkout-success-actions {
            gap: 20px;
        }
        .checkout-success-actions a {
            font-size: 1.5rem;
        }
        .payment-complete-img {
            width: 50%;
        }
        @media (max-width: 767.98px) {
            .payment-complete-img {
                width: 100% !important;
            }

            .checkout-success-title {
                font-size: 2rem;
                font-weight: 600;
            }

            .checkout-success-invoice {
                font-size: 1rem;
                font-weight: 300;
            }
            .action-button {
                width: 100% !important;
                font-size: 1.25rem !important;
            }
        }
    </style>
@endsection
@section('content')
    <div class="position-relative checkout-success-section">
        <div class="container container-1440">
            {{-- Top Section --}}
            <div class="row checkout-success-breadcrumb">
                {{-- Bread Crumbs --}}
                <div class="col-12 col-md-6">
                    <div>Shop > Confirmation</div>
                </div>
            </div>

            <a href="/" class="w-20 py-2 px-4 mb-3 lagramma-button-solid rounded-4">
                < Back To Shop</a>
        </div>
    </div>

    <section class="py-5">
        <div class="container container-1440">
            <div class="row">
                <div class="col-12 mx-auto">
                    <img src="{{ URL::asset('build/images/assets/payment-complete.png') }}" alt=""
                        class="payment-complete-img d-block mx-auto">

                    <h4 class="mb-3 text-capitalize text-center lagramma-green-font checkout-success-title">Your Order Is Completed!</h4>
                    <p class="text-muted mb-0 text-center checkout-success-invoice">Invoice No:
                        {{ $invoiceNo }}</p>
                    <div class="mt-4 pt-2 hstack justify-content-center w-100 mx-auto d-flex flex-column flex-md-row checkout-success-actions">
                        <a href="{{ config('app.backend_url') }}/orders"
                            class="text-center rounded-4 solid-border-green lagramma-button-solid py-2 py-md-3 action-button" style="color: #ffffff;">View
                            Order</a>
                        <a href="/" class="text-center solid-border-green rounded-4 lagramma-button-outline py-2 py-md-3 action-button" style="color: #0c3e3c;">Back To
                            Shopping</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <!-- landing-index js -->
    <script src="{{ URL::asset('build/js/frontend/menu.init.js') }}"></script>
@endsection
