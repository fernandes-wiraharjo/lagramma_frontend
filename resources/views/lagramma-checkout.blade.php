@extends('layouts.master')
@section('title')
    Checkout
@endsection
@section('css')
    <!-- extra css -->
     <style>
        .spinner-border {
            margin-left: 10px;
        }
     </style>
@endsection
@section('content')
    @php
        $items = $checkoutData ?? [];
        $itemCount = count($items);
        $subtotal = collect($items)->sum('total_price');
        $totalWeight = collect($items)->sum('total_weight');
        $hasAddress = auth()->user()->addresses->count() > 0;
    @endphp
    <section class="page-wrapper bg-primary">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center d-flex align-items-center justify-content-between">
                        <h4 class="text-white mb-0">Checkout</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-light justify-content-center mb-0 fs-15">
                                <li class="breadcrumb-item"><a href="#!">Shop</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Checkout</li>
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

    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive table-card">
                                <table class="table align-middle table-borderless table-nowrap text-center mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col">Product</th>
                                            <th scope="col">Rate</th>
                                            <th scope="col">Qty</th>
                                            <th scope="col">Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- <tr>
                                            <td class="text-start">
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <div class="avatar-title bg-success-subtle rounded-3">
                                                            <img src="{{ URL::asset('build/images/products/img-4.png') }}" alt=""
                                                                class="avatar-xs">
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6>Girls Mint Green & Off-White Solid Open</h6>
                                                        <p class="text-muted mb-0">Graphic Print Men & Women Footwear</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                $24.00
                                            </td>
                                            <td>
                                                02
                                            </td>
                                            <td class="text-end">$48.00</td>
                                        </tr> -->
                                        @foreach ($items as $key => $item)
                                        <tr>
                                            <td class="text-start">
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <div class="avatar-title bg-success-subtle rounded-3">
                                                            <img src="{{ $item['image'] ?? URL::asset('build/images/products/default.png') }}" alt=""
                                                                class="avatar-xs">
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6>
                                                            {{ $item['product_name'] }}{{ !empty($item['product_variant_name']) ? ' - ' . $item['product_variant_name'] : '' }}
                                                            @if (!empty($item['modifiers']))
                                                                <span class="text-muted">( IDR {{ number_format($item['price'], 0, ',', '.') }} )</span>
                                                            @endif
                                                        </h6>
                                                        <p class="text-muted mb-0">
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
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @php
                                                    $modifierPrice = !empty($item['modifiers']) ? $item['modifiers'][0]['price'] : 0;
                                                    $rate = $item['price'] + $modifierPrice;
                                                @endphp
                                                IDR{{ number_format($rate, 0, ',', '.') }}
                                            </td>
                                            <td>
                                                {{ $item['quantity'] ?? 0 }}
                                            </td>
                                            <td class="text-end">
                                                IDR{{ number_format($item['total_price'], 0, ',', '.') }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-2">
                        <div class="d-flex align-items-center mb-4">
                            <div class="flex-grow-1">
                                <h5 class="mb-0">Shipping Address</h5>
                            </div>
                            <div class="flex-shrink-0">
                                <a href="javascript:location.reload()" class="badge bg-primary-subtle text-primary link-primary">
                                    Reload
                                </a>
                                <a href="{{ config('app.backend_url') }}/account-setting" target="_blank"
                                    rel="noopener noreferrer" class="badge bg-secondary-subtle text-secondary link-secondary">
                                    Manage Address
                                </a>
                            </div>
                        </div>
                        <div class="row gy-3">
                            @forelse(auth()->user()->addresses as $address)
                                <div class="col-lg-6 col-12">
                                    <div class="form-check card-radio">
                                        <input id="shippingAddress{{ $address->id }}"
                                            name="shippingAddress"
                                            type="radio"
                                            class="form-check-input"
                                            value="{{ $address->id }}"
                                            data-address='@json($address)'
                                        >
                                        <label class="form-check-label" for="shippingAddress{{ $address->id }}">
                                            <span class="fs-14 mb-2 d-block fw-semibold">{{ $address->label ?? 'Address' }}</span>
                                            <span class="text-muted fw-normal text-wrap mb-1 d-block">{{ $address->address }}</span>
                                            <span class="mt-3 text-muted fw-normal d-block text-wrap">{{ $address->region_label }}</span>
                                        </label>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="alert alert-warning mb-0">
                                        <strong>No shipping address found.</strong><br>
                                        Please <a href="{{ config('app.backend_url') }}/account-setting" target="_blank"
                                            rel="noopener noreferrer" class="link-secondary text-decoration-underline">
                                                manage your address
                                            </a> and click
                                            <a href="javascript:location.reload()" class="link-secondary text-decoration-underline">
                                                reload
                                            </a> to proceed checkout.
                                    </div>
                                </div>
                            @endforelse
                        </div>
                        <div class="mt-3" id="shippingOptionWrapper">
                            <label for="shippingOption">Shipping Option</label>
                            <select id="shippingOption" class="form-select"></select>
                        </div>
                        <div class="mt-3" id="sendToOtherContainer">
                            <label>
                                <input type="checkbox" id="cbSendToOther"> Send to other ?
                            </label>
                        </div>
                        <!-- Conditional sender/receiver fields -->
                        <div id="sto_fields">
                            <div class="form-group">
                                <label for="sto_pic_name">Sender PIC Name</label>
                                <input type="text" id="sto_pic_name" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="sto_pic_phone">Sender PIC Phone</label>
                                <input type="text" id="sto_pic_phone" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="sto_receiver_name">Receiver Name</label>
                                <input type="text" id="sto_receiver_name" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="sto_receiver_phone">Receiver Phone</label>
                                <input type="text" id="sto_receiver_phone" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="sto_note">Note</label>
                                <textarea id="sto_note" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col -->
                <div class="col-lg-4">
                    <div class="sticky-side-div">
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
                                                <td class="text-end cart-subtotal">IDR{{ number_format($subtotal, 0, ',', '.') }}</td>
                                            </tr>
                                            <tr>
                                                <td>Shipping Charge :</td>
                                                <td class="text-end cart-shipping" id="shippingCost">-</td>
                                            </tr>
                                            <tr class="table-active">
                                                <th>Total (IDR) :</th>
                                                <td class="text-end">
                                                    <span class="fw-semibold cart-total" id="grandTotal">-</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- end table-responsive -->
                            </div>
                        </div>
                        <div class="hstack gap-2 justify-content-between justify-content-end">
                            <a href="view-cart" class="btn btn-hover btn-soft-info w-100">Back To Cart <i
                                    class="ri-arrow-right-line label-icon align-middle ms-1"></i></a>
                            <!-- <a href="payment" class="btn btn-hover btn-primary w-100">Create Order</a> -->
                            <button id="create-order-btn" class="btn btn-hover btn-primary w-100" disabled>
                                <span id="btn-text">Create Order</span>
                                <span id="loading-spinner" class="d-none spinner-border spinner-border-sm text-light" role="status"></span>
                            </button>
                        </div>

                    </div>
                    <!-- end stickey -->
                </div>
                <!--end col-->
            </div>
            <!--end row-->
        </div>
        <!--end container-->
    </section>
@endsection
@section('scripts')
    <script>
        const checkoutSource = "{{ $checkoutSource }}";
        const hasAddress = @json($hasAddress);
        const subtotal = @json($subtotal);
        const totalWeight = @json($totalWeight);
        const itemCount = @json($itemCount);
        let shippingCost = 0;
        let grandTotal = 0;
    </script>
    <!-- page js -->
    <script src="{{ URL::asset('build/js/frontend/lagramma-checkout.init.js') }}"></script>
    <!-- form wizard init -->
    <script src="{{ URL::asset('build/js/pages/form-wizard.init.js') }}"></script>
    <!-- landing-index js -->
    <script src="{{ URL::asset('build/js/frontend/menu.init.js') }}"></script>
@endsection
