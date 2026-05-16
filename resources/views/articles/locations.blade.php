@extends('layouts.master')
@section('title')
    Location
@endsection
@section('css')
    <style>
        .contact-table {
            overflow: hidden;
            font-weight: 300;
            font-style: normal;
            font-size: 1.5rem;
            padding-bottom: 32px;
        }

        .contact-row {
            display: grid;
            grid-template-columns: 0.5fr 16px 1fr;
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

        .location-title {
            font-weight: 400;
            font-size: 1.5rem;
            padding-bottom: 4px;
            margin: 0;
        }

        .location-address {
            font-weight: 300;
            font-size: 1.5rem;
            line-height: 1.25;
        }

        .location-list {
            display: flex;
            flex-direction: column;
            gap: 56px;
        }

        .background-page-wrapper {
            position: relative;
        }

        .background-left {
            position: absolute;
            top: 0;
            left: 0;
            width: 50%;
            height: 100%;
            background-image: url("{{ URL::asset('build/images/assets/locations.png') }}");
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            z-index: 0;
        }

        @media (max-width: 767px) {
            .background-left {
                display: none;
            }

            .location-content {
                padding-left: 0 !important;
                padding-top: 32px;
            }

            .location-title,
            .location-address {
                font-size: 1.125rem;
            }

            .contact-table {
                font-size: 1.125rem;
            }

            .location-list {
                gap: 28px;
            }
        }
    </style>
@endsection
@section('content')
    {{-- Mobile Breadcrumb --}}
    <x-breadcrumb-mobile :items="[['label' => 'Home', 'url' => '/'], ['label' => 'Location']]" />

    <img src="{{ URL::asset('build/images/assets/locations.png') }}" alt="Locations"
        class="w-100 d-md-none" />

    <div class="background-page-wrapper px-2">
        <div class="background-left"></div>

        <div class="container container-1440">
            <div class="position-relative checkout-page-wrapper d-none d-md-block">
                <div class="container container-1440">
                    {{-- Top Section --}}
                    <div class="row breadcrumb-spacing">
                        {{-- Bread Crumbs --}}
                        <div class="col-12 col-md-6">
                            <x-breadcrumb :items="[['label' => 'Home', 'url' => '/'], ['label' => 'Location']]" color="#909090" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6 d-none d-md-block"></div>
                <div class="col-12 col-md-6 location-content px-2" style="padding-left: 56px; padding-bottom: 64px;">
                    {{-- Location List --}}
                    <section class="location-list">
                        <div class="d-flex align-items-start gap-3">
                            <div style="padding-top: 4px;">
                                <img src="{{ URL::asset('build/images/icons/pinpoint.svg') }}" alt="Location Icon"
                                    class="location-icon" width="32" height="32" />
                            </div>
                            <div>
                                <h2 class="location-title">La Gramma GAMA</h2>
                                <p class="location-address">Jl.Gajahmada 151B, Benua Melayu Darat,<br />Kec. Pontianak Sel,
                                    Kota
                                    Pontianak,<br />Kalimantan Barat 78121</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-start gap-3">
                            <div style="padding-top: 4px;">
                                <img src="{{ URL::asset('build/images/icons/pinpoint.svg') }}" alt="Location Icon"
                                    class="location-icon" width="32" height="32" />
                            </div>
                            <div>
                                <h2 class="location-title">La Gramma GAIA</h2>
                                <p class="location-address">Gaia Mall, Jalan Arteri Supadio<br />Kubu Raya, Kalbar</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-start gap-3">
                            <div style="padding-top: 4px;">
                                <img src="{{ URL::asset('build/images/icons/pinpoint.svg') }}" alt="Location Icon"
                                    class="location-icon" width="32" height="32" />
                            </div>
                            <div>
                                <h2 class="location-title">La Gramma BPP (Soon)</h2>
                                <p class="location-address">Jl. Tjutjup Suparna Blok G1 no 2A & 2B.<br />Gunung Samarinda,
                                    Balikpapan Utara</p>
                            </div>
                        </div>
                    </section>

                    {{-- Open Hour Information --}}
                    <section class="location-list" style="margin-top: 64px;">
                        <div class="d-flex align-items-start gap-3">
                            <div>
                                <img src="{{ URL::asset('build/images/icons/watch.svg') }}" alt="Open Hour Icon"
                                    width="32" height="32" />
                            </div>
                            <div>
                                <p class="location-address">Monday - Sunday • 07.00 - 24.00 WIB</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-start gap-3">
                            <div>
                                <img src="{{ URL::asset('build/images/icons/whatsapp.svg') }}" alt="WhatsApp Icon"
                                    width="32" height="32" />
                            </div>
                            <div>
                                <div class="contact-table pb-2">
                                    <div class="contact-row">
                                        <div class="contact-cell">Dalam Kota</div>
                                        <div class="contact-sep">:</div>
                                        <div class="contact-cell">
                                            <a target="_blank" href="https://wa.me/6281952684970"><u>081952684970</u></a> /
                                            <a target="_blank" href="https://wa.me/6282213706036"><u>082213706036</u></a>
                                        </div>
                                    </div>
                                    <div class="contact-row">
                                        <div class="contact-cell">Luar Kota</div>
                                        <div class="contact-sep">:</div>
                                        <div class="contact-cell">
                                            <a target="_blank" href="https://wa.me/6282254485151"><u>082254485151</u></a>
                                        </div>
                                    </div>
                                    <div class="contact-row">
                                        <div class="contact-cell">Balikpapan</div>
                                        <div class="contact-sep">:</div>
                                        <div class="contact-cell">
                                            <a target="_blank" href="https://wa.me/6282254485151"><u>082254485151</u></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-start gap-3">
                            <div>
                                <img src="{{ URL::asset('build/images/icons/instagram.svg') }}" alt="Instagram Icon" />
                            </div>
                            <div>
                                <p class="location-address">
                                    <a class="lagramma-green-font" target="_blank"
                                        href="https://www.instagram.com/lagrammahomemade/">Lagrammahomemade</a>
                                </p>
                            </div>
                        </div>

                        <div class="d-flex align-items-start gap-3">
                            <div>
                                <img src="{{ URL::asset('build/images/icons/tiktokshop.svg') }}" alt="TikTok Shop Icon"
                                    width="32" height="32" />
                            </div>
                            <div>
                                <p class="location-address">
                                    <a class="lagramma-green-font" target="_blank"
                                        href="https://www.tiktok.com/@lagrammahomemade_">La Gramma Homemade</a>
                                </p>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@endsection
