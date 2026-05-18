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

        .p-no-margin {
            margin: 0;
            padding: 0;
        }

        .content-margin-bottom {
            margin-bottom: 88px;
        }

        @media (max-width: 767.98px) {
            .lagramma-h1 {
                font-size: 0.875rem !important;
                border-bottom: 1px solid #000;
            }

            .lagramma-h2 {
                font-size: 1.25rem !important;
                padding-bottom: 0.5rem !important;
            }

            .contact-table {
                font-size: 1.25rem !important;
                padding-bottom: 0.75rem !important;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container container-1440 content-margin-bottom">
        <h1 class="lagramma-h1 pb-5 mt-5">Contact Us</h1>

        <h2 class="lagramma-h2">Contact Us</h2>
        <p class="contact-table">We're here to help you with orders, questions, and special requests.</p>

        <h2 class="lagramma-h2">Phone</h2>
        <p class="contact-table">Our customer service team will be happy to assist you on whatsapp chat in <a target="_blank" href="https://wa.me/6282213706036?text=Hello%20Lagramma!%20Saya%20ingin%20bertanya%20terkait">082213706036</a></p>

        <h2 class="lagramma-h2">Email</h2>
        <div class="contact-table pb-5">
            <div class="contact-row">
                <div class="contact-cell">For customer service & order inquiries</div>
                <div class="contact-sep">:</div>
                <div class="contact-cell">
                    <a target="_blank" href="mailto:lagrammahomemade@gmail.com">lagrammahomemade@gmail.com</a>
                </div>
            </div>
            <div class="contact-row">
                <div class="contact-cell">For business & collaboration inquiries</div>
                <div class="contact-sep">:</div>
                <div class="contact-cell">
                    <a target="_blank" href="mailto:lagrammahomemade@gmail.com">lagrammahomemade@gmail.com</a>
                </div>
            </div>
        </div>

        <h2 class="lagramma-h2">Online Chat</h2>
        <div class="contact-table">
            <p class="p-no-margin">Our team is available via online chat during the following hours :</p>
            <p class="p-no-margin">Monday – Sunday: 09.00 – 17.00 WIB</p>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
