@extends('layouts.master')
@section('title')
    Product Details
@endsection
@section('css')
    <!-- extra css -->
    <link href="{{ URL::asset('build/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css">
@endsection
@section('content')
    <section class="section mt-5">
        <div class="container">
            <div class="row gx-2">
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-md-2">
                            <div thumbsSlider="" class="swiper productSwiper mb-3 mb-lg-0">
                                <div class="swiper-wrapper">
                                    {{-- Show main image first --}}
                                    @if($product->mainImage)
                                        <div class="swiper-slide">
                                            <div class="product-thumb rounded cursor-pointer">
                                                <img src="{{ asset(config('app.backend_url') . '/storage/' . ($product->mainImage->image_path ?? '')) }}" alt="" class="img-fluid" />
                                            </div>
                                        </div>
                                    @endif

                                    {{-- Show the rest of the images, excluding the main one --}}
                                    @foreach($product->images->where('is_main', false)->sortBy('id') as $image)
                                        <div class="swiper-slide">
                                            <div class="product-thumb rounded cursor-pointer">
                                                <img src="{{ asset(config('app.backend_url') . '/storage/' . ($image->image_path ?? '')) }}" alt="" class="img-fluid" />
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-md-10">
                            <div class="bg-light rounded-2 position-relative ribbon-box overflow-hidden">
                                <!-- <div class="ribbon ribbon-danger ribbon-shape trending-ribbon">
                                    <span class="trending-ribbon-text">Trending</span> <i
                                        class="ri-flashlight-fill text-white align-bottom float-end ms-1"></i>
                                </div> -->
                                <div class="swiper productSwiper2">
                                    <div class="swiper-wrapper">
                                        {{-- Show main image first --}}
                                        @if($product->mainImage)
                                            <div class="swiper-slide">
                                                <img src="{{ asset(config('app.backend_url') . '/storage/' . ($product->mainImage->image_path ?? '')) }}" alt="" class="img-fluid" />
                                            </div>
                                        @endif

                                        {{-- Show the rest of the images, excluding the main one --}}
                                        @foreach($product->images->where('is_main', false)->sortBy('id') as $image)
                                            <div class="swiper-slide">
                                                <img src="{{ asset(config('app.backend_url') . '/storage/' . ($image->image_path ?? '')) }}" alt="" class="img-fluid" />
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="swiper-button-next bg-transparent"></div>
                                    <div class="swiper-button-prev bg-transparent"></div>
                                </div>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-lg-12">
                            <div class="mt-3">
                                <div class="hstack gap-2">
                                    <button type="button" class="btn btn-success btn-hover w-100">
                                        <i class="bi bi-basket2 me-2"></i> Add To Cart
                                    </button>
                                    <button type="button" class="btn btn-primary btn-hover w-100">
                                        <i class="bi bi-cart2 me-2"></i> Buy Now
                                    </button>
                                    <!-- <button class="btn btn-soft-danger custom-toggle btn-hover" data-bs-toggle="button"
                                        aria-pressed="true"> <span class="icon-on"><i class="ri-heart-line"></i></span>
                                        <span class="icon-off"><i class="ri-heart-fill"></i></span> </button> -->
                                </div>
                            </div>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </div>
                <!--end col-->
                <div class="col-lg-5 ms-auto">
                    <div class="ecommerce-product-widgets mt-4 mt-lg-0">
                        <div class="mb-4">
                            <div class="d-flex gap-3 mb-2">
                                <div class="fs-15 text-warning">
                                    <i class="ri-star-fill align-bottom"></i>
                                    <i class="ri-star-fill align-bottom"></i>
                                    <i class="ri-star-fill align-bottom"></i>
                                    <i class="ri-star-fill align-bottom"></i>
                                    <i class="ri-star-half-fill align-bottom"></i>
                                </div>
                                <span class="fw-medium"> (50 Review)</span>
                            </div>
                            <h4 class="lh-base mb-1">Opinion Striped Round Neck Green T-shirt</h4>
                            <p class="text-muted mb-4">The best part about stripped t shirt denim & white sneakers or wear
                                it with a cool chinos and blazer to dress up <a href="javascript:void(0);"
                                    class="link-info">Read More</a></p>
                            <h5 class="fs-24 mb-4">$185.79 <span class="text-muted fs-14"><del>$280.99</del></span> <span
                                    class="fs-14 ms-2 text-danger"> (50% off)</span></h5>
                            <ul class="list-unstyled vstack gap-2">
                                <li class=""><i class="bi bi-check2-circle me-2 align-middle text-success"></i>In
                                    stock</li>
                                <li class=""><i class="bi bi-check2-circle me-2 align-middle text-success"></i>Free
                                    delivery available</li>
                                <li class=""><i class="bi bi-check2-circle me-2 align-middle text-success"></i>Sales
                                    10% Off Use Code: <b>FASHION10</b></li>
                            </ul>
                            <h6 class="fs-14 text-muted mb-3">Available offers :</h6>
                            <ul class="list-unstyled vstack gap-2 mb-0">
                                <li>
                                    <div class="d-flex gap-3">
                                        <div class="flex-shrink-0">
                                            <i class="bi bi-tag-fill text-success align-middle fs-15"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <b>Bank Offer</b> 10% instant discount on Federal Bank Debit Cards, up to ₹3000
                                            on orders of ₹5,000 and above <a href="#!" data-bs-toggle="tooltip"
                                                data-bs-title="Terms & Conditions">T&C</a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex gap-3">
                                        <div class="flex-shrink-0">
                                            <i class="bi bi-tag-fill text-success align-middle fs-15"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <b>Bank Offer</b> 10% instant discount on Federal Bank Debit Cards, up to ₹3000
                                            on orders of ₹5,000 and above <a href="#!" data-bs-toggle="tooltip"
                                                data-bs-title="Terms & Conditions">T&C</a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="d-flex align-items-center mb-4">
                            <h5 class="fs-15 mb-0">Quantity:</h5>
                            <div class="input-step ms-2">
                                <button type="button" class="minus">–</button>
                                <input type="number" class="product-quantity1" value="1" min="0"
                                    max="100" readonly="">
                                <button type="button" class="plus">+</button>
                            </div>
                        </div>
                        <div class="row gy-3">
                            <div class="col-md-6">
                                <div>
                                    <h6 class="fs-14 fw-medium text-muted">Sizes:</h6>
                                    <ul class="clothe-size list-unstyled hstack gap-2 mb-0 flex-wrap">
                                        <li> <input type="radio" name="sizes7" id="product-color-72"> <label
                                                class="avatar-xs btn btn-soft-primary text-uppercase p-0 fs-12 d-flex align-items-center justify-content-center rounded-circle"
                                                for="product-color-72">s</label> </li>
                                        <li> <input type="radio" name="sizes7" id="product-color-73"> <label
                                                class="avatar-xs btn btn-soft-primary text-uppercase p-0 fs-12 d-flex align-items-center justify-content-center rounded-circle"
                                                for="product-color-73">m</label> </li>
                                        <li> <input type="radio" name="sizes7" checked id="product-color-74"> <label
                                                class="avatar-xs btn btn-soft-primary text-uppercase p-0 fs-12 d-flex align-items-center justify-content-center rounded-circle"
                                                for="product-color-74">l</label> </li>
                                        <li> <input type="radio" name="sizes7" id="product-color-75"> <label
                                                class="avatar-xs btn btn-soft-primary text-uppercase p-0 fs-12 d-flex align-items-center justify-content-center rounded-circle"
                                                for="product-color-75">xl</label> </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="fs-14 fw-medium text-muted">Colors: </h6>
                                <ul class="clothe-colors list-unstyled hstack gap-1 mb-0 flex-wrap ms-2">
                                    <li>
                                        <input type="radio" name="sizes" id="product-color-2">
                                        <label
                                            class="avatar-xs btn btn-info p-0 d-flex align-items-center justify-content-center rounded-circle"
                                            for="product-color-2"></label>
                                    </li>
                                    <li>
                                        <input type="radio" name="sizes" id="product-color-3">
                                        <label
                                            class="avatar-xs btn btn-light p-0 d-flex align-items-center justify-content-center rounded-circle"
                                            for="product-color-3"></label>
                                    </li>
                                    <li>
                                        <input type="radio" name="sizes" id="product-color-4" checked>
                                        <label
                                            class="avatar-xs btn btn-primary p-0 d-flex align-items-center justify-content-center rounded-circle"
                                            for="product-color-4"></label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end col-->
            </div>
            <!--end row-->
        </div>
        <!--end container-->
    </section>
@endsection
@section('scripts')
    <!--Swiper slider js-->
    <script src="{{ URL::asset('build/libs/swiper/swiper-bundle.min.js') }}"></script>

    <script src="{{ URL::asset('build/js/frontend/product-details.init.js') }}"></script>

    <!-- landing-index js -->
    <script src="{{ URL::asset('build/js/frontend/menu.init.js') }}"></script>
@endsection
