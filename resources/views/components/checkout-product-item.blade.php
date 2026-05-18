@props(['item', 'layout' => 'table'])

@php
    $modifierPrice = !empty($item['modifiers']) ? $item['modifiers'][0]['price'] : 0;
    $rate = $item['price'] + $modifierPrice;
@endphp

@if ($layout === 'table')
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
                            <span class="text-checkout-primary-semibold">( Rp
                                {{ number_format($item['price'], 0, ',', '.') }} )</span>
                        @endif
                    </h6>
                    <h7 class="checkout-table-product-variant">
                        {{ !empty($item['product_variant_name']) ? $item['product_variant_name'] : '' }}</h7>
                    <p class="text-muted mb-0">
                        @if (!empty($item['modifiers']))
                            <div class="mt-2">
                                <ul class="mb-2 ps-3">
                                    @foreach ($item['modifiers'] as $modifier)
                                        <li>
                                            {{ $modifier['modifier_name'] }}: {{ $modifier['modifier_option_name'] }}
                                            <span class="checkout-table-modifier-price">(+Rp
                                                {{ number_format($modifier['price'], 0, ',', '.') }})</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

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
                    </p>
                </div>
            </div>
        </td>
        <td class="checkout-table-cell-rate">
            Rp {{ number_format($rate, 0, ',', '.') }}
        </td>
        <td class="checkout-table-cell-qty">
            {{ $item['quantity'] ?? 0 }}
        </td>
        <td class="text-end checkout-table-cell-price">
            Rp {{ number_format($item['total_price'], 0, ',', '.') }}
        </td>
    </tr>
@else
    {{-- Mobile Card Layout --}}
    <div class="checkout-mobile-product-card">
        {{-- Row 1: Product Info --}}
        <div class="checkout-mobile-header">
            <div class="checkout-mobile-header-product">Product</div>
        </div>
        <div class="d-flex align-items-top gap-2 mt-2">
            <div class="avatar-xl flex-shrink-0">
                <div class="avatar-title bg-success-subtle rounded-3">
                    <img src="{{ $item['image'] ?? URL::asset('build/images/products/default.png') }}" alt=""
                        class="avatar-xl">
                </div>
            </div>
            <div class="flex-grow-1">
                <h6 class="checkout-table-product-name">
                    {{ $item['product_name'] }}
                    @if (!empty($item['modifiers']))
                        <span class="text-checkout-primary-semibold">( Rp
                            {{ number_format($item['price'], 0, ',', '.') }} )</span>
                    @endif
                </h6>
                <h7 class="checkout-table-product-variant">
                    {{ !empty($item['product_variant_name']) ? $item['product_variant_name'] : '' }}</h7>
                <p class="text-muted mb-0">
                    @if (!empty($item['modifiers']))
                        <div class="mt-2">
                            <ul class="mb-2 ps-3">
                                @foreach ($item['modifiers'] as $modifier)
                                    <li>
                                        {{ $modifier['modifier_name'] }}: {{ $modifier['modifier_option_name'] }}
                                        <span class="checkout-table-modifier-price">(+Rp
                                            {{ number_format($modifier['price'], 0, ',', '.') }})</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

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
                </p>
            </div>
        </div>

        {{-- Row 2: Rate / Qty / Price --}}
        <div class="checkout-mobile-header">
            <div class="checkout-mobile-header-totals d-flex justify-content-between">
                <span>Rate</span>
                <span>Qty</span>
                <span>Price</span>
            </div>
        </div>
        <div class="d-flex justify-content-between mt-2 checkout-mobile-product-totals">
            <div class="text-center">
                <div class="checkout-table-cell-rate">Rp {{ number_format($rate, 0, ',', '.') }}</div>
            </div>
            <div class="text-center">
                <div class="checkout-table-cell-qty">{{ $item['quantity'] ?? 0 }}</div>
            </div>
            <div class="text-center">
                <div class="checkout-table-cell-price">Rp {{ number_format($item['total_price'], 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
@endif
