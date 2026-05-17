@extends('layouts.master')
@section('title')
    Checkout
@endsection
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    @php
        $items = $checkoutData ?? [];
        $itemCount = count($items);
        $subtotal = collect($items)->sum('total_price');
        $totalWeight = collect($items)->sum('total_weight');
        $hasAddress = auth()->user()->addresses->count() > 0;
    @endphp

    <div class="position-relative checkout-page-wrapper">
        <div class="container container-1440">
            {{-- Top Section --}}
            <div class="row breadcrumb-spacing">
                {{-- Bread Crumbs --}}
                <div class="col-12 col-md-6">
                    <x-breadcrumb :items="[['label' => 'Home', 'url' => '/'], ['label' => 'Checkout']]" />
                </div>
            </div>
            <a href="/" class="btn btn-danger btn-hover w-20 py-2 px-4 mb-3 lagramma-button-solid rounded-4">< Back To Shop</a>
        </div>
    </div>

    {{-- <section class="page-wrapper bg-primary">
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
    </section> --}}

    <section class="pb-5">
        <div class="container container-1440 pb-4">
            <div class="row">
                <div class="col-xl-8">
                    <div class="card rounded-4 shadow-blur p-4">
                        <div class="card-body">
                            <div class="table-responsive table-card">
                                <table class="table align-middle table-borderless table-nowrap text-center mb-0">
                                    <thead class="checkout-table-head">
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
                                                                class="avatar-sm">
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="checkout-table-product-name">
                                                            {{ $item['product_name'] }}
                                                            @if (!empty($item['modifiers']))
                                                                <span class="text-checkout-primary-semibold">( Rp {{ number_format($item['price'], 0, ',', '.') }} )</span>
                                                            @endif
                                                        </h6>
                                                        <h7 class="checkout-table-product-variant">{{ !empty($item['product_variant_name']) ? $item['product_variant_name'] : '' }}</h7>
                                                        <p class="text-muted mb-0">
                                                            {{-- Show Modifiers if available --}}
                                                            @if (!empty($item['modifiers']))
                                                            <div class="mt-2">
                                                                <!-- <h6 class="fs-13 fw-semibold text-muted mb-1">Topping:</h6> -->
                                                                <ul class="mb-2 ps-3">
                                                                    @foreach ($item['modifiers'] as $modifier)
                                                                        <li>
                                                                            {{ $modifier['modifier_name'] }}: {{ $modifier['modifier_option_name'] }}
                                                                            <span class="checkout-table-modifier-price">(+Rp {{ number_format($modifier['price'], 0, ',', '.') }})</span>
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
                                            <td class="checkout-table-cell-rate">
                                                @php
                                                    $modifierPrice = !empty($item['modifiers']) ? $item['modifiers'][0]['price'] : 0;
                                                    $rate = $item['price'] + $modifierPrice;
                                                @endphp
                                                Rp {{ number_format($rate, 0, ',', '.') }}
                                            </td>
                                            <td class="checkout-table-cell-qty">
                                                {{ $item['quantity'] ?? 0 }}
                                            </td>
                                            <td class="text-end checkout-table-cell-price">
                                                Rp {{ number_format($item['total_price'], 0, ',', '.') }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- Order Summary: Mobile --}}
                    <div class="d-lg-none">
                        <x-order-summary-card :subtotal="$subtotal" />
                    </div>

                    <div class="mt-4 pt-2">
                        <div class="d-flex align-items-center mb-4">
                            <div class="flex-shrink-0">
                                <button class="btn-add-address rounded-4" id="feAddAddressButton">
                                    Add Address{{ " " }} <img src="{{ URL::asset('/build/images/icons/loc-point-01.svg') }}" />
                                </button>
                                {{-- <a href="javascript:location.reload()" class="badge bg-primary-subtle text-primary link-primary">
                                    Reload
                                </a>
                                <a href="{{ config('app.backend_url') }}/account-setting" target="_blank"
                                    rel="noopener noreferrer" class="badge bg-secondary-subtle text-secondary link-secondary">
                                    Manage Address
                                </a>  --}}
                            </div>

                            {{-- <div class="flex-grow-1">
                                <h5 class="mb-0">Shipping Address</h5>
                            </div> --}}
                        </div>

                        <!-- Add Address Modal -->
                        <div class="modal fade" id="feAddAddressModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title lagramma-green-font modal-title-checkout">Add Address</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <form id="feCreateAddressForm" autocomplete="off">

                                            <!-- Name -->
                                            <div class="mb-3">
                                                <label class="form-label modal-form-label">Name</label>
                                                <input id="fe-name" type="text" class="form-control checkout-form-input shadow-blur" required>
                                            </div>

                                            <!-- Search Address -->
                                            <div class="mb-3">
                                                <label class="form-label modal-form-label">Search Address</label>
                                            </div>

                                            <!-- Google Maps -->
                                            <div id="fe-map" class="checkout-map"></div>

                                            <div class="mb-3 mt-3">
                                                <input type="text" id="fe-search-address" class="form-control checkout-form-input shadow-blur"
                                                    placeholder="Search location…">
                                                <div class="mt-1" style="font-size: 1rem; font-weight: 300; line-height: 1.2; text-align: justify; color: #000000;">
                                                    Mohon letakkan titik map sesuai dengan lokasi anda dengan sempurna, kesalahan dalam memasukkan titik akan menghambat kecepatan dan ketepatan dalam proses pengiriman
                                                </div>
                                            </div>

                                            <!-- Latitude -->
                                            <div class="mb-3 mt-3">
                                                <label class="form-label modal-form-label">Latitude</label>
                                                <input id="fe-latitude" type="text" class="form-control checkout-form-input shadow-blur" readonly required>
                                            </div>

                                            <!-- Longitude -->
                                            <div class="mb-3">
                                                <label class="form-label modal-form-label">Longitude</label>
                                                <input id="fe-longitude" type="text" class="form-control checkout-form-input shadow-blur" readonly required>
                                            </div>

                                            <!-- Region Select -->
                                            <div class="mb-3">
                                                <label class="form-label modal-form-label">
                                                    Region
                                                    <span class="small lagramma-green-color" style="font-weight: 400; font-size: 1.5rem;">(search city/district/subdistrict/postal code)</span>
                                                </label>

                                                <select id="fe-region-select" class="form-control checkout-form-input shadow-blur" style="width: 100%;"></select>
                                                <input type="hidden" id="fe-region-id">
                                                <input type="hidden" id="fe-region-label">
                                            </div>

                                            <!-- Address Text -->
                                            <div class="mb-3">
                                                <label class="form-label modal-form-label">Address</label>
                                                <textarea id="fe-address" class="form-control checkout-form-input shadow-blur" rows="2" required></textarea>
                                            </div>
                                            <button class="lagramma-button-solid w-100 py-2 my-2 rounded-4 fs-18" type="submit">Save</button>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- loop the user address -->
                        <div class="row gy-3">
                            <h6 class="shipping-address-heading">Shipping Address</h6>
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
                                            <div class="d-flex align-items-center mb-2">
                                                <img src="{{ URL::asset('/build/images/icons/home-icon-01.svg') }}" class="address-icon" />
                                                <span class="address-label">{{ $address->label ?? 'Address' }}</span>
                                            </div>
                                            <span class="fw-normal text-wrap d-block address-text">{{ $address->address }}</span>
                                            <span class="fw-normal d-block text-wrap address-text">{{ $address->region_label }}</span>
                                        </label>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="alert alert-warning mb-0">
                                        <strong>No shipping address found.</strong><br>
                                        Please add your address to proceed checkout.
                                            <!-- <a href="{{ config('app.backend_url') }}/account-setting" target="_blank"
                                            rel="noopener noreferrer" class="link-secondary text-decoration-underline">
                                                manage your address
                                            </a> and click
                                            <a href="javascript:location.reload()" class="link-secondary text-decoration-underline">
                                                reload
                                            </a>  -->
                                    </div>
                                </div>
                            @endforelse
                        </div>
                        <div class="mt-3" id="shippingOptionWrapper">
                            <label for="shippingOption" class="checkout-form-label pb-2">*Shipping Option</label>
                            <select id="shippingOption" class="form-select shadow-blur shipping-option-select"></select>
                        </div>
                        <div class="mt-3" id="sendToOtherContainer">
                            <label class="d-flex align-items-center checkout-form-label">
                                <input type="checkbox" id="cbSendToOther" class="checkout-checkbox"><span class="checkbox-label-text">Send to Other?</span>
                            </label>
                        </div>
                        <!-- Conditional sender/receiver fields -->
                        <div id="sto_fields">
                            <div class="form-group">
                                <label for="sto_pic_name" class="checkout-form-label">Nama Pengirim</label>
                                <input type="text" id="sto_pic_name" class="form-control shadow-blur checkout-form-input">
                            </div>

                            <div class="form-group">
                                <label for="sto_pic_phone" class="checkout-form-label">Nomor Pengirim</label>
                                <input type="text" id="sto_pic_phone" class="form-control shadow-blur checkout-form-input">
                            </div>

                            <div class="form-group">
                                <label for="sto_receiver_name" class="checkout-form-label">Nama Penerima</label>
                                <input type="text" id="sto_receiver_name" class="form-control shadow-blur checkout-form-input">
                            </div>

                            <div class="form-group">
                                <label for="sto_receiver_phone" class="checkout-form-label">Nomor Penerima</label>
                                <input type="text" id="sto_receiver_phone" class="form-control shadow-blur checkout-form-input">
                            </div>

                            <div class="form-group">
                                <label for="sto_note" class="checkout-form-label">Note di Kartu Ucapan (Opsional)</label>
                                <textarea id="sto_note" class="form-control shadow-blur checkout-form-input" rows="10"></textarea>
                            </div>
                        </div>

                        <!-- Term & Condition -->
                        <div class="mt-3" id="termConditionContainer">
                            <label class="d-flex align-items-center checkout-form-label">
                                <input type="checkbox" id="cbTermCondition" class="checkout-checkbox"><span class="checkbox-label-text">I agree to <a href="/e-commerce-term-and-condition" target="_blank">the term and conditions</a></span>
                            </label>
                        </div>
                    </div>
                </div>
                <!-- end col -->
                {{-- Order Summary: Desktop --}}
                <div class="col-lg-4 d-none d-lg-block">
                    <div class="sticky-side-div">
                        <x-order-summary-card :subtotal="$subtotal" />
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
        const komerceApiKey = @json(config('app.komerce_api_key'));
        let shippingCost = 0;
        let grandTotal = 0;
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- page js -->
    <script src="{{ URL::asset('build/js/frontend/lagramma-checkout.init.js') }}"></script>
    <!-- form wizard init -->
    <script src="{{ URL::asset('build/js/pages/form-wizard.init.js') }}"></script>
    <!-- landing-index js -->
    <script src="{{ URL::asset('build/js/frontend/menu.init.js') }}"></script>
    <!-- maps js -->
     <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=feInitMap&libraries=places&v=weekly"></script>
@endsection
