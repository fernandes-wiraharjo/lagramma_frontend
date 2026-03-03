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
    <section class="section pb-0 mt-4">
        <div class="container-fluid">
        </div>
    </section>

    <div class="position-relative section">
        <div class="container container-1440">
            <div class="ecommerce-product gap-4">
            </div>
        </div>
    </div>

    <main style="min-height: 80vh;">
        <div class="container container-1440">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="display-4">COMING SOON</h1>
                    <p class="lead">Our website is under construction. Stay tuned for updates!</p>
                </div>
            </div>
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
