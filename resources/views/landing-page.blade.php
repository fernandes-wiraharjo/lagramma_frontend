@extends('layouts.master')
@section('title')
    Catalogue
@endsection
@section('css')
    <!-- extra css -->

    <!-- nouisliderribute css -->
    <link rel="stylesheet" href="{{ URL::asset('build/libs/nouislider/nouislider.min.css') }}">

    <style>
        .filter-list a.active {
            background-color: #94DA25;
            /* highlight background */
        }
    </style>
@endsection
@section('content')
    <div class="position-relative section">
        <div class="container container-1440">
            <div class="ecommerce-product gap-4">
            </div>
        </div>
    </div>

    <main class="lagramma-main-content">
        <div class="container container-1440">
            {{-- Hero Image section --}}
            <div class="row">
                <div class="col-12 p-0 hero-image-container overflow-hidden">
                    <img class="w-100 h-100 object-fit-cover d-block"
                        src="{{ URL::asset('build/images/assets/hero-idul-fitri.png') }}" alt="Idul Fitri">
                </div>
            </div>

            {{-- Product Variant Section --}}
            <div class="row mx-0 my-lg-1 pt-5 px-lg-4 gy-4">
                <div class="col-6 col-md-6 col-lg-3">
                    <img class="w-100"
                        src="{{ URL::asset('build/images/assets/collect-1-full-house-hampers.png') }}"
                        alt="Idul Fitri Variant">
                </div>
                <div class="col-6 col-md-6 col-lg-3">
                    <img class="w-100"
                        src="{{ URL::asset('build/images/assets/collect-2-traditional-cookies.png') }}"
                        alt="Idul Fitri Variant">
                </div>
                <div class="col-6 col-md-6 col-lg-3">
                    <img class="w-100" src="{{ URL::asset('build/images/assets/collect-3-nastar-keju.png') }}"
                        alt="Idul Fitri Variant">
                </div>
                <div class="col-6 col-md-6 col-lg-3">
                    <img class="w-100" src="{{ URL::asset('build/images/assets/collect-4-lapis-legit.png') }}"
                        alt="Idul Fitri Variant">
                </div>
            </div>

            {{-- Discover Us --}}
            <x-section-title title="Discover Us" />

            {{-- Slider Product Variant --}}
            <div class="row">
                <div class="col-12 p-0">
                    @include('components.carousel')
                </div>
            </div>

            {{-- Discover Us --}}
            <x-section-title title="Our Commitments" />
            <x-side-image-info image="build/images/assets/info-1-egg.png" alt="All Naturals" title="All Natural"
                description="We bake with real, honest ingredients<br /> &mdash; nothing artificial, ever." />

            <x-side-image-info image="build/images/assets/info-2-no-preservative.png" alt="No Preservatives" title="No Preservatives"
                description="No shortcuts. No chemical shelf-life <br />tricks. Just pure freshness." />

            <x-side-image-info image="build/images/assets/info-3-highest-quality-ingredients.png" alt="Highest - Quality Ingredients" title="Highest - Quality Ingredients"
                description="We bake with real, honest ingredients — nothing <br />artificial, ever." />

            <x-side-image-info image="build/images/assets/info-4-a-promise-to-grandma-legacy.png" alt="A Promise to Grandma’s Legacy" title="A Promise to Grandma’s Legacy"
                description="Every layer carries her spirit : Do it sincerely,<br />do it properly and never compromise on quality" />
        </div>
    </main>
@endsection
@section('scripts')
    <!-- nouisliderribute js -->
    <script src="{{ URL::asset('build/libs/nouislider/nouislider.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/wnumb/wNumb.min.js') }}"></script>

    <!-- Catalogue init js -->
    <script src="{{ URL::asset('build/js/frontend/catalogue.init.js') }}"></script>
    <!-- coming-soon -->
    <script src="{{ URL::asset('build/js/pages/coming-soon.init.js') }}"></script>

    <!-- landing-index js -->
    <script src="{{ URL::asset('build/js/frontend/menu.init.js') }}"></script>
@endsection

