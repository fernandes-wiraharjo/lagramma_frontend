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
                                    <a href="/" class="btn btn-danger btn-hover w-100">
                                        Back To Shopping
                                    </a>
                                    <button id="btn-add-to-cart" type="button" class="btn btn-success btn-hover w-100">
                                        <i class="bi bi-cart2 me-2"></i> Add To Cart
                                    </button>
                                    <button id="btn-buy-now" type="button" class="btn btn-primary btn-hover w-100">
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
                    data-product-id="{{ $product->id }}"
                    data-product-name="{{ $product->name }}"
                    data-category="{{ strtolower($product->category->name) }}"
                    data-main-image="{{ $product->mainImage?->image_path
                        ? asset(config('app.backend_url') . '/storage/' . $product->mainImage->image_path)
                        : asset('images/no_image.jpg') }}"
                    data-weight="{{ $product->weight }}"
                    data-width="{{ $product->width }}"
                    data-height="{{ $product->height }}"
                    data-length="{{ $product->length }}"
                    data-product-variant-count="{{ $product->variants->count() }}"
                    data-product-first-variant-id="{{ $product->variants->first()->id }}"
                    data-product-first-variant-name="{{ $product->variants->first()->name }}"
                    data-product-first-variant-stock="{{ $product->variants->first()->stock }}"
                    @php
                        if ($product->is_sales_type_price === 1) {
                            $salesType = $product->variants->first()->salesTypes->firstWhere('salesType.name', 'Take Away');
                            $firstVariantPrice = $salesType->price ?? 0;
                        } else {
                            $firstVariantPrice = $product->variants->first()->price ?? 0;
                        }
                    @endphp
                    data-product-first-variant-price="{{ $firstVariantPrice }}"
                    @if(strtolower($product->category->name) === 'hampers' && $product->variants->first())
                        data-base-price="{{ $product->variants->first()->price }}"
                        data-stock="{{ $product->variants->first()->stock }}"
                        data-max-items="{{ $product->hamperSetting->max_items }}"
                        data-hampers-variant-id="{{ $product->variants->first()->id }}"
                        data-hampers-variant-name="{{ $product->variants->first()->name }}"
                    @endif
                >
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
                                        IDR {{ number_format($variant->price, 0, ',', '.') }}
                                    @else
                                        Harga tidak tersedia
                                    @endif
                                @elseif($product->variants->count() === 1)
                                    @php
                                        $variant = $product->variants->first();
                                    @endphp

                                    @if ($variant)
                                        IDR {{ number_format($variant->price, 0, ',', '.') }}
                                    @else
                                        Harga tidak tersedia
                                    @endif
                                @else
                                    <p class="text-muted fs-14 fst-italic">Silakan pilih varian terlebih dahulu untuk melihat harga.</p>
                                @endif
                            </h5>
                            <p id="total-price" class="text-muted fs-14 fst-italic d-none">Total Harga: IDR 0</p>
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
                                    @if(strtolower($product->category->name) === 'hampers' && $product->hamperSetting)
                                        @php
                                            $maxItems = $product->hamperSetting->max_items;
                                            $allowedVariants = $product->hamperSetting->items; // This gives allowed ProductVariants
                                        @endphp

                                        <div class="col-md-12">
                                            <!-- <h6 class="fs-14 fw-medium text-muted mb-2">
                                                Max Item's Qty: {{ $maxItems }}
                                            </h6> -->

                                            <table class="table table-sm table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Item</th>
                                                        <th class="d-none">Qty</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($allowedVariants as $variant)
                                                        <tr>
                                                            <td>{{ $variant->name ? $variant->product->name . ' - ' . $variant->name : $variant->product->name }}</td>
                                                            <td style="width: 100px; display:none;">
                                                                <input
                                                                    type="number"
                                                                    name="hamper_items[{{ $variant->id }}]"
                                                                    class="form-control hamper-qty"
                                                                    min="0"
                                                                    max="{{ $maxItems }}"
                                                                    value="1"
                                                                >
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>

                                            <small class="text-muted fst-italic" id="hamper-warning" style="display: none;">
                                                Total item's qty cannot exceed {{ $maxItems }}.
                                            </small>
                                        </div>
                                    @elseif(strtolower($product->category->name) !== 'hampers' && $product->variants->count())
                                        <div class="{{ $product->variants->count() === 1 ? 'd-none' : '' }}">
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
                                                            data-variant-id="{{ $variant->id }}" data-variant-name="{{ $variant->name }}" {{ $isOutOfStock ? 'disabled' : '' }}
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
                                        </div>
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
                                                        data-modifier-id="{{ $productModifier->modifier->id }}" data-modifier-name="{{ $productModifier->modifier->name }}"
                                                    >
                                                    <label
                                                        class="btn btn-outline-primary text-capitalize px-3 py-1 fs-12 d-flex align-items-center justify-content-center rounded-pill"
                                                        for="modifier-option-{{ $option->id }}">
                                                        {{ $productModifier->modifier->name }} - {{ $option->name }} &nbsp
                                                        <span class="text-muted"> (+IDR {{ number_format($option->price, 0, ',', '.') }})</span>
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
