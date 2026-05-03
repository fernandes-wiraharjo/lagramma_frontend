@extends('layouts.master')
@section('title')
    Order Completed
@endsection
@section('css')
    <style>
        .action-button {
                width: 320px;
            }
    </style>
@endsection
@section('content')
    <div class="position-relative" style="padding-top: 40px; padding-bottom: 40px;">
        <div class="container container-1440">
            {{-- Top Section --}}
            <div class="row" style="font-size: 1.25rem; font-weight: 400; padding-bottom: 20px;">
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
                        class="w-50 d-block mx-auto">

                    <h4 class="mb-3 text-capitalize text-center lagramma-green-font"
                        style="font-size: 2.5rem; font-weight: 700;">Your Order Is Completed!</h4>
                    <p class="text-muted mb-0 text-center" style="font-size: 2rem; font-weight: 300;">Invoice No:
                        {{ $invoiceNo }}</p>
                    <div class="mt-4 pt-2 hstack gap-2 justify-content-center w-100 mx-auto d-flex flex-column flex-md-row" style="gap: 20px;">
                        <a href="{{ config('app.backend_url') }}/orders"
                            class="text-center rounded-4 solid-border-green lagramma-button-solid py-3 action-button" style="font-size: 1.5rem; color: #ffffff;">View
                            Order</a>
                        <a href="/" class="text-center solid-border-green rounded-4 lagramma-button-outline py-3 action-button" style="font-size: 1.5rem; color: #0c3e3c;">Back To
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
