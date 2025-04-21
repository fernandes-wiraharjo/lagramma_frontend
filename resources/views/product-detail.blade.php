@extends('layouts.master')
@section('title')
    Product Details
@endsection
@section('css')
    <!-- extra css -->
    <link href="{{ URL::asset('build/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css">

    <style>
        .variant-label {
            max-width: 180px;
            min-height: 32px;
            white-space: normal;
            word-break: break-word;
            text-align: center;
            line-height: 1.2;
        }

        .btn-outline-primary {
            white-space: nowrap;
            text-align: center;
        }

        input[name="modifier_option[]"]:checked + label {
            background-color: #0d6efd; /* Bootstrap primary */
            color: #fff;
            border-color: #0d6efd;
        }

        input[name="modifier_option[]"]:checked + label span {
            color: #fff !important;
        }

        @media (max-width: 576px) {
            .variant-label {
                max-width: 100%;
            }
        }
    </style>
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

                                    {{-- Fallback image if no images are present --}}
                                    @if($product->mainImage == null && $product->images->isEmpty())
                                        <div class="swiper-slide">
                                            <div class="product-thumb rounded cursor-pointer">
                                                <img src="{{ asset('images/no_image.jpg') }}" alt="No Image" class="img-fluid" />
                                            </div>
                                        </div>
                                    @endif
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

                                        {{-- Fallback image if no images are present --}}
                                        @if($product->mainImage == null && $product->images->isEmpty())
                                            <div class="swiper-slide">
                                                <img src="{{ asset('images/no_image.jpg') }}" alt="No Image" class="img-fluid" />
                                            </div>
                                        @endif
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
                                        <i class="bi bi-cart2 me-2"></i> Add To Cart
                                    </button>
                                    <button type="button" class="btn btn-primary btn-hover w-100">
                                        <i class="bi bi-basket2 me-2"></i> Buy Now
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

                {{-- Hidden inputs or data attributes for JS --}}
                <div id="product-info" hidden
                    data-category="{{ strtolower($product->category->name) }}"
                    @if(strtolower($product->category->name) === 'hampers' && $product->variants->first())
                        data-base-price="{{ $product->variants->first()->price }}"
                        data-stock="{{ $product->variants->first()->stock }}"
                    @endif>
                </div>

                <div class="col-lg-5 ms-auto">
                    <div class="ecommerce-product-widgets mt-4 mt-lg-0">
                        <div class="mb-4">
                            <h4 class="lh-base mb-1">{{ $product->name }}</h4>
                            <h5 class="fs-24 mb-4" id="base-price">
                                @if(strtolower($product->category->name) === 'hampers')
                                    @php
                                        $variant = $product->variants->first();
                                    @endphp

                                    @if ($variant)
                                        Rp {{ number_format($variant->price, 0, ',', '.') }}
                                    @else
                                        Harga tidak tersedia
                                    @endif
                                @else
                                    <p class="text-muted fs-14 fst-italic">Silakan pilih varian terlebih dahulu untuk melihat harga.</p>
                                @endif
                            </h5>
                            <p id="total-price" class="text-muted fs-14 fst-italic d-none">Total Harga: Rp 0</p>
                        <div class="d-flex align-items-center mb-4">
                            <h5 class="fs-15 mb-0">Quantity:</h5>
                            <div class="input-step ms-2">
                                <button type="button" class="minus" id="btn-minus">–</button>
                                <input type="number" class="product-quantity1" value="1" min="1"
                                    max="100" readonly="">
                                <button type="button" class="plus" id="btn-plus">+</button>
                            </div>
                        </div>
                        <div class="row gy-3">
                            <div class="col-md-12">
                                <div>
                                    @if(strtolower($product->category->name) !== 'hampers' && $product->variants->count())
                                        <h6 class="fs-14 fw-medium text-muted">Variants:</h6>
                                        <ul class="clothe-size list-unstyled hstack gap-2 mb-0 flex-wrap">
                                            @foreach($product->variants as $index => $variant)
                                                @php
                                                    $inputId = 'product-variant-' . $variant->id;
                                                    $variantName = $variant->name ?: $product->name;

                                                    if ($product->is_sales_type_price === 1) {
                                                        $salesType = $variant->salesTypes->firstWhere('salesType.name', 'Take Away');
                                                        $price = $salesType->price ?? 0;
                                                    } else {
                                                        $price = $variant->price ?? 0;
                                                    }

                                                    $isOutOfStock = $variant->stock <= 0;
                                                @endphp
                                                <li>
                                                    <input type="radio" name="variant" id="{{ $inputId }}" value="{{ $price }}"
                                                        data-variant-id="{{ $variant->id }}" {{ $isOutOfStock ? 'disabled' : '' }}
                                                    >
                                                    <label class="variant-label btn btn-soft-primary text-uppercase p-0
                                                     px-3 py-1 fs-12 d-flex align-items-center justify-content-center
                                                     rounded-pill text-wrap text-center {{ $isOutOfStock ? 'disabled text-muted' : '' }}"
                                                        for="{{ $inputId }}">
                                                        {{ $variantName }}
                                                        @if($isOutOfStock)
                                                            <span class="ms-1">(Out of Stock)</span>
                                                        @endif
                                                    </label>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                            @if (strtolower($product->category->name) !== 'hampers' && $product->modifiers->isNotEmpty())
                                <div class="col-md-12">
                                    <h6 class="fs-14 fw-medium text-muted">Modifiers: </h6>
                                    <ul class="clothe-colors list-unstyled hstack gap-2 mb-0 flex-wrap ms-2">
                                        @foreach ($product->modifiers as $productModifier)
                                            @foreach ($productModifier->modifier->options ?? [] as $option)
                                                <li>
                                                    <input type="checkbox" name="modifier_option[]" id="modifier-option-{{ $option->id }}"
                                                        value="{{ $option->price }}" data-option-name="{{ $option->name }}"
                                                    >
                                                    <label
                                                        class="btn btn-outline-primary text-capitalize px-3 py-1 fs-12 d-flex align-items-center justify-content-center rounded-pill"
                                                        for="modifier-option-{{ $option->id }}">
                                                        {{ $productModifier->modifier->name }} - {{ $option->name }} &nbsp
                                                        <span class="text-muted"> (+Rp {{ number_format($option->price, 0, ',', '.') }})</span>
                                                    </label>
                                                </li>
                                            @endforeach
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
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

    <script src="{{ URL::asset('build/js/frontend/product-detail.init.js') }}"></script>

    <!-- landing-index js -->
    <script src="{{ URL::asset('build/js/frontend/menu.init.js') }}"></script>
@endsection
