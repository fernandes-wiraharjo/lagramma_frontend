@php
    $shippingCost = $delivery->shipping_cost;
@endphp

<div class="sticky-side-div">
    <div class="card overflow-hidden rounded-4 shadow-blur p-4">
        <div class="card-header pb-0 border-0">
            <h5 class="card-title-checkout mb-0">Order Summary</h5>
        </div>
        <div class="card-body pt-4 px-4">
            <div class="table-responsive table-card">
                <table class="table table-borderless mb-0 fs-15">
                    <tbody>
                        <tr>
                            <td class="order-summary-label no-padding">Subtotal</td>
                            <td class="text-end order-summary-value cart-lg-subtotal">Rp
                                {{ number_format($subtotal, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="order-summary-label no-padding">Shipping</td>
                            <td class="text-end order-summary-value cart-shipping">Rp {{ number_format($shippingCost, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="order-summary-label no-padding">Unique Code</td>
                            <td class="text-end order-summary-value cart-shipping">
                                Rp {{ number_format($uniqueCode, 0, ',', '.') }}
                            </td>
                        </tr>
                        <tr>
                            <td class="order-summary-total-label">Total</td>
                            <td class="text-end order-summary-total-value">
                                <span class="fw-semibold cart-total">Rp
                                    {{ number_format($transferAmount, 0, ',', '.') }}</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- end table-responsive -->
        </div>
    </div>
</div>
