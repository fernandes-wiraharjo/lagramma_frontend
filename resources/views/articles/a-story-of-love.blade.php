@extends('layouts.master')
@section('title')
    A Story of Love
@endsection
@section('css')
    <!-- extra css -->
    <!--Swiper slider css-->

    <style>
        .background-image {
            background-image: url("{{ URL::asset('build/images/assets/a-story-of-love-bg.png') }}");
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            min-height: calc(100vh);
        }
    </style>
@endsection
@section('content')
    {{-- <img class="w-100" src="{{ URL::asset('build/images/assets/a-story-of-love-bg.png') }}"> --}}
    <div class="background-image">
        <div class="position-relative checkout-page-wrapper">
            <div class="container container-1440">
                {{-- Top Section --}}
                <div class="row breadcrumb-spacing">
                    {{-- Bread Crumbs --}}
                    <div class="col-12 col-md-6 fw-bold">
                        <div>Home > About</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container container-1440"
            style="font-size: 1.25rem; padding-bottom: 640px;">
            <div style="font-weight: 300; max-width: 860px;">
                <p>It all started with a small notebook left on a sewing table . as he fought back tears and reminisced
                    about the good old days , he was flipping through page after page of that cherished book. never even
                    crossed his mind that his grandma's handwriting would take him far.</p>

                <p>
                    Her words still echo in his memory<br />
                    "You've got to use real butter. The better the butter, the better the cake"<br />
                    "And remember ! Never use any preservatives! They're no good for out health!<br />
                    "If you do it right, the cake will stay fresh"
                </p>

                <p>Losing his grandma was one of the toughest thing he's ever faced. inspired by their close bond, he wanted
                    to preserve their shared memories through La gramma</p>


                <p>
                    From the depths of our hearts<br />
                    We thankyou , our beloved customers for your support all along<br />
                    Let's bring our tradition to the world , together one layer at a time
                </p>
                
                <br />

                <p>in her memory,</p>

                <p>Gramma</p>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@endsection
