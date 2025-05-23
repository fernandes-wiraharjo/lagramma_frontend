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
    <section class="page-wrapper bg-primary">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center d-flex align-items-center justify-content-between">
                        <h4 class="text-white mb-0">Cart</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-light justify-content-center mb-0 fs-15">
                                <!-- <li class="breadcrumb-item"><a href="#!">Shop</a></li> -->
                                <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!--end col-->
            </div>
            <!--end row-->
        </div>
        <!--end container-->
    </section>
    <!--end page-wrapper-->

    <section class="section">
        <div class="container">
            <!-- <div class="row">
                <div class="col-lg-12">
                    <div class="alert alert-danger text-center text-capitalize mb-4 fs-14">
                        save up to <b>30%</b> to <b>40%</b> off omg! just look at the <b>great deals</b>!
                    </div>
                </div>
            </div> -->
            <div class="row product-list justify-content-center">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center mb-4">
                        <h5 class="mb-0 flex-grow-1 fw-medium">There are <span class="fw-bold">{{ $cartCount }}</span>
                            products in your cart</h5>
                        @if($cartCount > 0)
                            <div class="flex-shrink-0">
                                <a href="#!" class="text-decoration-underline link-secondary clear-cart-btn">Clear Cart</a>
                            </div>
                        @endif
                    </div>
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

                    @foreach ($cart as $key => $item)
                    <div class="card product">
                        <div class="card-body p-4">
                            <div class="row gy-3">
                                <div class="col-sm-auto">
                                    <div class="avatar-lg h-100">
                                        <div class="avatar-title bg-danger-subtle rounded py-3">
                                            <img src="{{ $item['image'] ?? asset('build/images/products/img-12.png') }}" alt="{{ $item['name'] ?? 'Product Image' }}" class="avatar-md">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm">
                                    <a href="#!">
                                        <h5 class="fs-16 lh-base mb-1">
                                            {{ $item['product_name'] }}{{ !empty($item['product_variant_name']) ? ' - ' . $item['product_variant_name'] : '' }}
                                        </h5>
                                    </a>

                                    {{-- Show Modifiers if available --}}
                                    @if (!empty($item['modifiers']))
                                    <div class="mt-2">
                                        <!-- <h6 class="fs-13 fw-semibold text-muted mb-1">Topping:</h6> -->
                                        <ul class="mb-2 ps-3">
                                            @foreach ($item['modifiers'] as $modifier)
                                                <li>
                                                    {{ $modifier['modifier_name'] }}: {{ $modifier['modifier_option_name'] }}
                                                    <span class="text-muted">(+IDR {{ number_format($modifier['price'], 0, ',', '.') }})</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif

                                    {{-- For Hampers: Show item details --}}
                                    @if ($item['type'] === 'hampers' && !empty($item['items']))
                                    <div class="mt-2">
                                        <h6 class="fs-13 fw-semibold text-muted mb-1">Items:</h6>
                                        <ul class="mb-2 ps-3">
                                            @foreach ($item['items'] as $subItem)
                                                <li>
                                                    {{ $subItem['product_name'] }}{{ !empty($subItem['name']) ? ' - ' . $subItem['name'] : '' }} x {{ $subItem['quantity'] }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif

                                    <div class="input-step">
                                        <button type="button" class="cart-header-minus" data-key="{{ $key }}">–</button>
                                        <input type="number" class="product-quantity" value="{{ $item['quantity'] ?? 1 }}"
                                            min="0" max="100" data-key="{{ $key }}" readonly>
                                        <button type="button" class="cart-header-plus" data-key="{{ $key }}">+</button>
                                    </div>
                                </div>
                                <div class="col-sm-auto">
                                    <div class="text-lg-end">
                                        <p class="text-muted mb-1 fs-12">Item Price:</p>
                                        <h5 class="fs-16">IDR<span class="product-price">{{ number_format($item['price'], 0, ',', '.') }}</span></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row align-items-center gy-3">
                                <div class="col-sm">
                                    <div class="d-flex flex-wrap my-n1">
                                        <div>
                                            <a href="#!" class="d-block text-body p-1 px-2 remove-item-btn" data-key="{{ $key }}"><i
                                                    class="ri-delete-bin-fill text-muted align-bottom me-1"></i> Remove</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-auto">
                                    <div class="d-flex align-items-center gap-2 text-muted">
                                        <div>Total :</div>
                                        <h5 class="fs-14 mb-0">IDR<span class="product-line-price"
                                            data-key="{{ $key }}" data-price="{{ ($item['price'] ?? 0) + (!empty($item['modifiers']) ? array_sum(array_column($item['modifiers'], 'price')) : 0) }}">
                                            {{ number_format($item['total_price'], 0, ',', '.') }}
                                            </span>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end card footer -->
                    </div>
                    <!--end card-->
                    @endforeach
                </div>
                <!--end col-->
                <div class="col-lg-4">
                    <div class="sticky-side-div">
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
                        <div class="card overflow-hidden">
                            <div class="card-header border-bottom-dashed">
                                <h5 class="card-title mb-0 fs-15">Order Summary</h5>
                            </div>
                            <div class="card-body pt-4">
                                <div class="table-responsive table-card">
                                    <table class="table table-borderless mb-0 fs-15">
                                        <tbody>
                                            <tr>
                                                <td>Sub Total :</td>
                                                <td class="text-end cart-lg-subtotal">IDR{{ number_format($subtotal, 0, ',', '.') }}</td>
                                            </tr>
                                            <!-- <tr>
                                                <td>Discount <span class="text-muted">(Toner15)</span>:</td>
                                                <td class="text-end cart-discount"></td>
                                            </tr> -->
                                            <tr>
                                                <td>Shipping Charge :</td>
                                                <td class="text-end cart-shipping">-</td>
                                            </tr>
                                            <!-- <tr>
                                                <td>Estimated Tax (12.5%) : </td>
                                                <td class="text-end cart-tax"></td>
                                            </tr> -->
                                            <tr class="table-active">
                                                <th>Total (IDR) :</th>
                                                <td class="text-end">
                                                    <span class="fw-semibold cart-total">-</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- end table-responsive -->
                            </div>
                        </div>
                        <div class="hstack gap-2 justify-content-end">
                            <a href="/" class="btn btn-hover btn-danger">Continue Shopping</a>
                            <!-- <button type="button" class="btn btn-hover btn-danger">Continue Shopping</button> -->
                            <button type="button" id="lg-checkout-btn" class="btn btn-hover btn-success" @if($cartCount == 0) disabled @endif>
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
