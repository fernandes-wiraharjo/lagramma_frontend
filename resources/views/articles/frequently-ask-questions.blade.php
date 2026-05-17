@extends('layouts.master')
@section('title')
    Frequently Asked Questions
@endsection
@section('css')
    <style>
        @media (max-width: 767.98px) {
            .lagramma-h1 {
                font-size: 0.875rem !important;
                border-bottom: 1px solid #000;
            }

            .lagramma-p,
            .lagramma-h2 {
                font-size: 1.25rem !important;
            }

            .lagramma-p {
                padding-bottom: 0.75rem !important;
            }

            .lagramma-h2 {
                padding-bottom: 0.5rem !important;
            }
        }
    </style>
@endsection
@section('content')
    <div class="container container-1440">
        <h1 class="lagramma-h1 pb-4 mt-5 mb-5">Frequently Asked Questions</h1>
        <h2 class="lagramma-h2">1. How do I place an order?</h2>
        <p class="lagramma-p">You can order directly through our website.<br />Simply choose your favorite products, add to
            cart, and proceed to checkout.</p>

        <h2 class="lagramma-h2">2. Do you accept same day orders?</h2>
        <p class="lagramma-p">Since we are based in Pontianak, same day order can be made through GoFood or WhatsApp order.
        </p>


        <h2 class="lagramma-h2">3. Where do we ship our products from?</h2>
        <p class="lagramma-p">Shipping from Pontianak to your location</p>

        <h2 class="lagramma-h2">4. How long can Lapis be stored in room temperature?</h2>
        <p class="lagramma-p">5-7 days in room temperature, 1-2 months in showcase/freezer</p>

        <h2 class="lagramma-h2">5. Can I pick up my order?</h2>
        <p class="lagramma-p">Yes! You can choose self-pickup at checkout and collect your order at our location.</p>

        <h2 class="lagramma-h2">6. What payment methods do you accept?</h2>
        <div class="lagramma-p">
            We accept:
            <ul style="padding-left: 64px;">
                <li>Bank transfer (BCA)</li>
                <li>Other local transfer methods listed at checkout</li>
            </ul>
        </div>

        <h2 class="lagramma-h2">7. How do I confirm my payment?</h2>
        <p class="lagramma-p">After transfer, go to the Payment Confirmation page and upload your payment proof.</p>

        <h2 class="lagramma-h2">8. Can I customize my order?</h2>
        <p class="lagramma-p">Our products are made individually, however, altering some ingredients is not possible during
            this time.</p>

        <h2 class="lagramma-h2">9. How long can other cakes last?</h2>
        <p class="lagramma-p">Cookies can last up to 11-12 months when it's sealed</p>


        <h2 class="lagramma-h2">10. Do you use preservatives or colouring?</h2>
        <p class="lagramma-p">We are proud to say we bake our Lapis and other cakes without using any preservatives or
            artificial colouring.</p>
    </div>
@endsection
@section('scripts')
@endsection
