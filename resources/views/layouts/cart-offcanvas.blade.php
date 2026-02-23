@php
    $cart = session('shopping_cart', []);
    $cartCount = count($cart);
    $subtotal = collect($cart)->sum('total_price');
@endphp

<!--cart -->
<div class="offcanvas offcanvas-end product-list" tabindex="-1" id="ecommerceCart" aria-labelledby="ecommerceCartLabel">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title" id="ecommerceCartLabel">My Cart
            @if ($cartCount > 0)
                <span class="badge bg-danger align-middle ms-1 lg-cartitem-badge">{{ $cartCount }}</span>
            @endif
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body px-0">
        <div data-simplebar  class="h-100">
            <ul class="list-group list-group-flush cartlist">
                @foreach ($cart as $key => $item)
                    <li class="list-group-item product">
                        <div class="d-flex gap-3">
                            <div class="flex-shrink-0">
                                <div class="avatar-md" style="height: 100%;">
                                    <div class="avatar-title bg-warning-subtle rounded-3">
                                        <img src="{{ $item['image'] }}" alt="{{ $item['product_name'] }}" class="avatar-sm">
                                    </div>
                                </div>
                            </div>

                            <div class="flex-grow-1">
                                <a href="#!">
                                    <h5 class="fs-15">
                                        {{ $item['product_name'] }}{{ !empty($item['product_variant_name']) ? ' - ' . $item['product_variant_name'] : '' }}
                                    </h5>
                                </a>
                                <div class="d-flex mb-3 gap-2">
                                    <div class="text-muted fw-medium mb-0">IDR<span class="product-price">{{ number_format($item['price'], 0, ',', '.') }}</span></div>
                                    <div class="vr"></div>
                                </div>

                                {{-- Show Modifiers if available --}}
                                @if (!empty($item['modifiers']))
                                <div class="mt-2">
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
                                    <input type="number" class="product-quantity" data-key="{{ $key }}" value="{{ $item['quantity'] }}" min="1" max="100" readonly>
                                    <button type="button" class="cart-header-plus" data-key="{{ $key }}">+</button>
                                </div>
                            </div>

                            <div class="flex-shrink-0 d-flex flex-column justify-content-between align-items-end">
                                <button type="button" class="btn btn-icon btn-sm btn-ghost-secondary remove-item-btn" data-key="{{ $key }}">
                                    <i class="ri-close-fill fs-16"></i>
                                </button>
                                <div class="fw-medium mb-0 fs-16">
                                    IDR<span class="product-line-price" data-key="{{ $key }}"
                                        data-price="{{ ($item['price'] ?? 0) + (!empty($item['modifiers']) ? array_sum(array_column($item['modifiers'], 'price')) : 0) }}">
                                        {{ number_format($item['total_price'], 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>

            <div class="table-responsive mx-2 border-top border-top-dashed">
                <table class="table table-borderless mb-0 fs-14 fw-semibold">
                    <tbody>
                        <tr>
                            <td>Sub Total :</td>
                            <td class="text-end cart-lg-subtotal">IDR{{ number_format($subtotal, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Shipping Charge :</td>
                            <td class="text-end cart-shipping">-</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="offcanvas-footer border-top p-3 text-center">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="m-0 fs-16 text-muted">Total:</h6>
            <div class="px-2">
                <h6 class="m-0 fs-16 cart-total">-</h6>
            </div>
        </div>
        <div class="row g-2">
            <div class="col-6">
                <a href="{{ route('view-cart') }}" class="btn btn-light w-100" id="reset-layout">View Cart</a>
            </div>
            <div class="col-6">
                <button type="button" id="lg-continue-to-co-btn" class="btn btn-info w-100" @if($cartCount == 0) disabled @endif>
                    Continue to Checkout
                </button>
            </div>
        </div>
    </div>
</div>

<!-- removeItemModal -->
<div id="removeItemModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>
            <div class="modal-body">
                <div class="mt-2 text-center">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                        <h4>Are you sure ?</h4>
                        <p class="text-muted mx-4 mb-0">Are you sure you want to remove this product ?</p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn w-sm btn-danger" id="remove-product">Yes, Delete It!</button>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
