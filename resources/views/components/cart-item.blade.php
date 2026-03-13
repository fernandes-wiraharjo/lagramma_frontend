@props(['item', 'key'])

<div class="card product rounded-4 shadow-blur">
    <div class="card-body p-4">
        <div class="row gy-3">
            <div class="col-sm-auto">
                <div class="avatar-lg h-100">
                    <div class="avatar-title bg-danger-subtle rounded py-3">
                        <img src="{{ $item['image'] ?? asset('build/images/products/img-12.png') }}"
                            alt="{{ $item['name'] ?? 'Product Image' }}" class="avatar-md">
                    </div>
                </div>
            </div>
            <div class="col-sm d-flex flex-column justify-content-between">
                {{-- <div class="row">
                    <div class="col-12 d-flex justify-center-between align-items-center">
                        <h5 class="fs-16 lh-base mb-1">
                            {{ $item['product_name'] }}
                        </h5>

                        <div class="input-step">
                            <button type="button" class="cart-header-minus" data-key="{{ $key }}">–</button>
                            <input type="number" class="product-quantity" value="{{ $item['quantity'] ?? 1 }}"
                                min="0" max="100" data-key="{{ $key }}" readonly>
                            <button type="button" class="cart-header-plus" data-key="{{ $key }}">+</button>
                        </div>
                    </div>
                </div> --}}

                <a href="#!">
                    <h5 class="product-title">
                        {{ $item['product_name'] }}
                    </h5>
                </a>

                <div class="product-title">
                    {{ !empty($item['product_variant_name']) ? $item['product_variant_name'] : '' }}
                </div>

                <div><span class="product-price">Rp {{ number_format($item['price'], 0, ',', '.') }}</span>
                </div>

                {{-- Show Modifiers if available --}}
                @if (!empty($item['modifiers']))
                    <div class="mt-2">
                        <ul class="mb-2 ps-3">
                            @foreach ($item['modifiers'] as $modifier)
                                <li>
                                    {{ $modifier['modifier_name'] }}: {{ $modifier['modifier_option_name'] }}
                                    <span class="text-muted">(+IDR
                                        {{ number_format($modifier['price'], 0, ',', '.') }})</span>
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
                                    {{ $subItem['product_name'] }}{{ !empty($subItem['name']) ? ' - ' . $subItem['name'] : '' }}
                                    x {{ $subItem['quantity'] }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <div class="col-sm-auto">
                <div class="text-lg-end d-flex flex-column justify-content-between h-100 ">
                    {{-- <div class="d-flex align-items-center">
                        <div class="input-step-product">
                            <button type="button" class="minus" id="btn-minus">−</button>
                            <input type="number" class="product-quantity1" value="1" min="1"
                                max="100" readonly="">
                            <button type="button" class="plus" id="btn-plus">+</button>
                        </div>
                    </div> --}}

                    <div class="input-step-product">
                        <button type="button" class="cart-header-minus" data-key="{{ $key }}">–</button>
                        <input type="number" class="product-quantity" value="{{ $item['quantity'] ?? 1 }}"
                            min="0" max="100" data-key="{{ $key }}" readonly>
                        <button type="button" class="cart-header-plus" data-key="{{ $key }}">+</button>
                    </div>

                    <div>
                        <a href="#!" class="d-block text-body p-1 px-2 remove-item-btn"
                            data-key="{{ $key }}"><i
                                class="ri-delete-bin-fill align-bottom me-1" style="color: #FF0404; font-size: 1.5rem;"></i></a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Hidden element for JavaScript price calculation --}}
        <span class="product-line-price d-none" data-key="{{ $key }}"
            data-price="{{ ($item['price'] ?? 0) + (!empty($item['modifiers']) ? array_sum(array_column($item['modifiers'], 'price')) : 0) }}">
            {{ number_format($item['total_price'], 0, ',', '.') }}
        </span>
    </div>
</div>
