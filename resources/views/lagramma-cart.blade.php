@extends('layouts.master')
@section('title')
    Shop Cart
@endsection
@section('css')
    <!-- extra css -->
@endsection
@section('content')
    @php
        $cart = session('shopping_cart', []);
        $cartCount = count($cart);
        $subtotal = collect($cart)->sum('total_price');
    @endphp
    <div class="position-relative" style="padding-top: 40px; padding-bottom: 40px;">
        <div class="container container-1440">
            {{-- Top Section --}}
            <div class="row" style="font-size: 1.25rem; font-weight: 400; padding-bottom: 20px;">
                {{-- Bread Crumbs --}}
                <div class="col-12 col-md-6">
                    <div>Home > Cart</div>
                </div>
            </div>

            <a href="/" class="btn btn-danger btn-hover w-20 py-2 px-4 mb-3 lagramma-button-solid rounded-4">< Back To Shop</a>
        </div>
    </div>

    <section>
        <div class="container container-1440 pb-4">
            <!-- <div class="row">
                <div class="col-lg-12">
                    <div class="alert alert-danger text-center text-capitalize mb-4 fs-14">
                        save up to <b>30%</b> to <b>40%</b> off omg! just look at the <b>great deals</b>!
                    </div>
                </div>
            </div> -->
            <div class="row product-list justify-content-center">
                <div class="col-lg-8">
                    {{-- <div class="d-flex align-items-center mb-4">
                        <h5 class="mb-0 flex-grow-1 fw-medium">There are <span class="fw-bold">{{ $cartCount }}</span>
                            products in your cart</h5>
                        @if($cartCount > 0)
                            <div class="flex-shrink-0">
                                <a href="#!" class="text-decoration-underline link-secondary clear-cart-btn">Clear Cart</a>
                            </div>
                        @endif
                    </div> --}}
                    <!-- <div class="card product">
                        <div class="card-body p-4">
                            <div class="row gy-3">
                                <div class="col-sm-auto">
                                    <div class="avatar-lg h-100">
                                        <div class="avatar-title bg-danger-subtle rounded py-3">
                                            <img src="{{ URL::asset('build/images/products/img-12.png') }}" alt=""
                                                class="avatar-md">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm">
                                    <a href="#!">
                                        <h5 class="fs-16 lh-base mb-1">Branded Smart Chair Red</h5>
                                    </a>
                                    <ul class="list-inline text-muted fs-13 mb-3">
                                        <li class="list-inline-item">Color : <span class="fw-medium">Red</span></li>
                                        <li class="list-inline-item">Size : <span class="fw-medium">M</span></li>
                                    </ul>
                                    <div class="input-step">
                                        <button type="button" class="minus">–</button>
                                        <input type="number" class="product-quantity" value="3" min="0"
                                            max="100" readonly>
                                        <button type="button" class="plus">+</button>
                                    </div>
                                </div>
                                <div class="col-sm-auto">
                                    <div class="text-lg-end">
                                        <p class="text-muted mb-1 fs-12">Item Price:</p>
                                        <h5 class="fs-16">$<span class="product-price">89.99</span></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row align-items-center gy-3">
                                <div class="col-sm">
                                    <div class="d-flex flex-wrap my-n1">
                                        <div>
                                            <a href="#!" class="d-block text-body p-1 px-2" data-bs-toggle="modal"
                                                data-bs-target="#removeItemModal"><i
                                                    class="ri-delete-bin-fill text-muted align-bottom me-1"></i> Remove</a>
                                        </div>
                                        <div>
                                            <a href="#!" class="d-block text-body p-1 px-2"><i
                                                    class="ri-star-fill text-muted align-bottom me-1"></i> Add Wishlist</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-auto">
                                    <div class="d-flex align-items-center gap-2 text-muted">
                                        <div>Total :</div>
                                        <h5 class="fs-14 mb-0">$<span class="product-line-price">269.97</span></h5>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <!-- end card footer -->
                    <!-- </div> -->
                    <!--end card-->

                    {{-- Cart Items Lagramma Design --}}
                    @foreach ($cart as $key => $item)
                        <x-cart-item :item="$item" :key="$key" />
                    @endforeach
                </div>
                <!--end col-->
                <div class="col-lg-4">
                    <div class="sticky-side-div rounded-4 shadow-blur">
                        <!-- <div class="card">
                            <div class="card-body">
                                <div class="text-center">
                                    <h6 class="mb-3 fs-15">Have a <span class="fw-semibold">promo</span> code ?</h6>
                                </div>
                                <div class="hstack gap-3 px-3 mx-n3">
                                    <input class="form-control me-auto" type="text" placeholder="Enter coupon code"
                                        value="Toner15" aria-label="Add Promo Code here...">
                                    <button type="button" class="btn btn-primary w-xs">Apply</button>
                                </div>
                            </div>
                        </div> -->
                        <div class="card overflow-hidden rounded-4 border-0">
                            <div class="card-header pb-0 border-0">
                                <h5 class="card-title mb-0" style="color: #0C3E3C; font-size: 1.25rem; font-weight: 400;">Order Summary</h5>
                            </div>
                            <div class="card-body pt-4 px-4">
                                <div class="table-responsive table-card">
                                    <table class="table table-borderless mb-0 fs-15">
                                        <tbody>
                                            <tr>
                                                <td style="font-size: 1.25rem; color: #909090; font-weight: 600; padding-bottom: 0;">Subtotal</td>
                                                <td class="text-end cart-lg-subtotal" style="font-size: 1.25rem; color: #0C3E3C; font-weight: 600;">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                            </tr>
                                            <!-- <tr>
                                                <td>Discount <span class="text-muted">(Toner15)</span>:</td>
                                                <td class="text-end cart-discount"></td>
                                            </tr> -->
                                            <tr>
                                                <td style="font-size: 1.25rem; color: #909090; font-weight: 600; padding-top: 0;">Shipping</td>
                                                <td class="text-end cart-shipping" style="font-size: 1.25rem; color: #0C3E3C; font-weight: 600;">-</td>
                                            </tr>
                                            <!-- <tr>
                                                <td>Estimated Tax (12.5%) : </td>
                                                <td class="text-end cart-tax"></td>
                                            </tr> -->
                                            <tr>
                                                <td style="color: #0C3E3C; font-size: 1.25rem; font-weight: 400;">Total</td>
                                                <td class="text-end" style="color: #0C3E3C; font-size: 1.25rem; font-weight: 400;">
                                                    <span class="fw-semibold cart-total">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- end table-responsive -->
                            </div>
                        </div>
                        <div class="hstack gap-2 justify-content-end pb-4" style="padding-right: 16px;">
                            {{-- <a href="/" class="btn btn-hover btn-danger">Continue Shopping</a> --}}
                            <!-- <button type="button" class="btn btn-hover btn-danger">Continue Shopping</button> -->
                            <button type="button" id="lg-checkout-btn" class="lagramma-button-solid rounded-4 btn btn-hover btn-success" @if($cartCount == 0) disabled @endif>
                                Check Out <i class="ri-logout-box-r-line align-bottom ms-1"></i>
                            </button>
                        </div>
                    </div>
                    <!-- end stickey -->
                </div>
            </div>
            <!--end row-->
        </div>
        <!--end container-->
    </section>
@endsection
@section('scripts')
    <!-- page js -->
    <script src="{{ URL::asset('build/js/frontend/lagramma-cart.init.js') }}"></script>
    <!-- landing-index js -->
    <script src="{{ URL::asset('build/js/frontend/menu.init.js') }}"></script>
@endsection
