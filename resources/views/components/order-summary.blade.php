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
                            <td class="order-summary-label no-padding-top">Shipping</td>
                            <td class="text-end order-summary-value cart-shipping">-</td>
                        </tr>
                        <tr>
                            <td class="order-summary-total-label">Total</td>
                            <td class="text-end order-summary-total-value">
                                <span class="fw-semibold cart-total">Rp
                                    {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- end table-responsive -->

            <div class="hstack gap-2 justify-content-between justify-content-end mt-4">
                <a href="view-cart" class="btn-back-cart rounded-4 text-center">Back To Cart <img
                        src="{{ URL::asset('/build/images/icons/cart-01.svg') }}" /></a>
                <button id="create-order-btn" class="btn-payment rounded-4" disabled>
                    <span id="btn-text">Payment</span>
                    <img src="{{ URL::asset('/build/images/icons/payment-01.svg') }}" />
                    <span id="loading-spinner"
                        class="d-none spinner-border spinner-border-sm text-light spinner-checkout"
                        role="status"></span>
                </button>
            </div>
        </div>
    </div>
</div>
