@extends('layouts.master')

@section('title')
    Contact Us
@endsection

@section('css')
    <style>
        .contact-table {
            overflow: hidden;
            font-weight: 300;
            font-style: normal;
            font-size: 2rem;
            padding-bottom: 32px;
        }

        .contact-row {
            display: grid;
            grid-template-columns: 560px 16px 1fr;
        }

        .contact-cell {
            line-height: 1.5;
        }

        .contact-header {
            letter-spacing: 0.05em;
        }

        .contact-email {
            word-break: break-all;
        }

        @media (max-width: 1280px) {
            .contact-row {
                grid-template-columns: 1fr;
                padding-bottom: 16px;
            }

            .contact-sep {
                display: none;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container container-1440">
        <h1 class="lagramma-h1 pb-4 mt-5">Contact Us</h1>

        <h2 class="lagramma-h2">Contact Us</h2>
        <p class="lagramma-p">We're here to help you with orders, questions, and special requests.</p>

        <h2 class="lagramma-h2">Phone</h2>
        <p class="lagramma-p">Our customer service team will be happy to assist you on whatsapp chat in 082213706036</p>

        <h2 class="lagramma-h2">Email</h2>
        <div class="contact-table">
            <div class="contact-row">
                <div class="contact-cell">For customer service & order inquiries</div>
                <div class="contact-sep">:</div>
                <div class="contact-cell">lagrammahomemade@gmail.com</div>
            </div>
            <div class="contact-row">
                <div class="contact-cell">For business & collaboration inquiries</div>
                <div class="contact-sep">:</div>
                <div class="contact-cell">lagrammahomemade@gmail.com</div>
            </div>
        </div>

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
