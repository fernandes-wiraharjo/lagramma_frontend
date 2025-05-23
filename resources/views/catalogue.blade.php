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
            background-color: #94DA25; /* highlight background */
        }
    </style>
@endsection
@section('content')
    <section class="section pb-0 mt-4">
        <div class="container-fluid">
            <!-- <div class="position-relative rounded-3"
                style="background-image: url('build/images/ecommerce/banner.jpg');background-size: cover;background-position: center;">
                <div class="row justify-content-end">
                    <div class="col-xxl-4">
                        <div class="text-end py-4 px-5 mx-xxl-5">
                            <h1 class="text-white display-5 lh-base text-capitalize ff-secondary mb-3 fst-italic">Original
                                sound listem to nature</h1>
                            <div>
                                <a href="#!" class="link-effect link-light text-white">Show Collections <i
                                        class="ri-arrow-right-line align-bottom ms-1"></i></a>
                            </div>
                        </div>
                    </div> -->
                    <!--end col-->
                <!-- </div> -->
                <!--end row-->
            <!-- </div> -->
        </div>
        <!--end container-->
    </section>

    <div class="position-relative section">
        <div class="container-fluid">
            <div class="ecommerce-product gap-4">
                <div class="sidebar flex-shrink-0">
                    <div class="card overflow-hidden">
                        <div class="card-header">
                            <div class="d-flex mb-3">
                                <div class="flex-grow-1">
                                    <h5 class="fs-16">Filters</h5>
                                </div>
                                <div class="flex-shrink-0">
                                    <a href="" class="text-decoration-underline" id="clearall">Clear All</a>
                                </div>
                            </div>
                            <div class="search-box">
                                <input type="text" class="form-control" id="searchProductList" autocomplete="off"
                                    placeholder="Search Products...">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                        <div class="accordion accordion-flush filter-accordion">
                            <div class="card-body border-bottom">
                                <div>
                                    <p class="text-muted text-uppercase fs-12 fw-medium mb-3">Categories</p>
                                    <ul class="list-unstyled mb-0 filter-list">
                                        <li>
                                            <a href="#" class="d-flex py-1 align-items-center">
                                                <div class="flex-grow-1">
                                                    <h5 class="fs-13 mb-0 listname">All</h5>
                                                </div>
                                            </a>
                                        </li>
                                        @foreach($categories as $category)
                                            <li>
                                                <a href="#" class="d-flex py-1 align-items-center">
                                                    <div class="flex-grow-1">
                                                        <h5 class="fs-13 mb-0 listname">{{ $category->name }}</h5>
                                                    </div>
                                                </a>
                                            </li>
                                        @endforeach
                                        <!-- <li>
                                            <a href="#" class="d-flex py-1 align-items-center">
                                                <div class="flex-grow-1">
                                                    <h5 class="fs-13 mb-0 listname">Grocery</h5>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="d-flex py-1 align-items-center">
                                                <div class="flex-grow-1">
                                                    <h5 class="fs-13 mb-0 listname">Fashion</h5>
                                                </div>
                                                <div class="flex-shrink-0 ms-2">
                                                    <span class="badge bg-light text-muted">5</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="d-flex py-1 align-items-center">
                                                <div class="flex-grow-1">
                                                    <h5 class="fs-13 mb-0 listname">Watches</h5>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="d-flex py-1 align-items-center">
                                                <div class="flex-grow-1">
                                                    <h5 class="fs-13 mb-0 listname">Electronics</h5>
                                                </div>
                                                <div class="flex-shrink-0 ms-2">
                                                    <span class="badge bg-light text-muted">5</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="d-flex py-1 align-items-center">
                                                <div class="flex-grow-1">
                                                    <h5 class="fs-13 mb-0 listname">Furniture</h5>
                                                </div>
                                                <div class="flex-shrink-0 ms-2">
                                                    <span class="badge bg-light text-muted">6</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="d-flex py-1 align-items-center">
                                                <div class="flex-grow-1">
                                                    <h5 class="fs-13 mb-0 listname">Automotive Accessories</h5>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="d-flex py-1 align-items-center">
                                                <div class="flex-grow-1">
                                                    <h5 class="fs-13 mb-0 listname">Appliances</h5>
                                                </div>
                                                <div class="flex-shrink-0 ms-2">
                                                    <span class="badge bg-light text-muted">7</span>
                                                </div>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="#" class="d-flex py-1 align-items-center">
                                                <div class="flex-grow-1">
                                                    <h5 class="fs-13 mb-0 listname">Kids</h5>
                                                </div>
                                            </a>
                                        </li> -->
                                    </ul>
                                </div>
                            </div>

                            <!-- <div class="card-body border-bottom">
                                <p class="text-muted text-uppercase fs-12 fw-medium mb-4">Price</p>

                                <div id="product-price-range" data-slider-color="info"></div>
                                <div class="formCost d-flex gap-2 align-items-center mt-3">
                                    <input class="form-control form-control-sm" type="text" id="minCost" value="0" />
                                    <span class="fw-semibold text-muted">to</span>
                                    <input class="form-control form-control-sm" type="text" id="maxCost" value="2000" />
                                </div>
                            </div> -->

                            <!-- <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingColors">
                                    <button class="accordion-button bg-transparent shadow-none" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#flush-collapseColors"
                                        aria-expanded="true" aria-controls="flush-collapseColors">
                                        <span class="text-muted text-uppercase fs-12 fw-medium">Colors</span> <span
                                            class="badge bg-success rounded-pill align-middle ms-1 filter-badge"></span>
                                    </button>
                                </h2>

                                <div id="flush-collapseColors" class="accordion-collapse collapse show"
                                    aria-labelledby="flush-headingColors">
                                    <div class="accordion-body text-body pt-0">
                                        <ul class="clothe-colors list-unstyled hstack gap-3 mb-0 flex-wrap"
                                            id="color-filter">
                                            <li>
                                                <input type="radio" name="colors" value="success" id="color-1">
                                                <label
                                                    class="avatar-xs btn btn-success p-0 d-flex align-items-center justify-content-center rounded-circle"
                                                    for="color-1"></label>
                                            </li>
                                            <li>
                                                <input type="radio" name="colors" value="info" id="color-2">
                                                <label
                                                    class="avatar-xs btn btn-info p-0 d-flex align-items-center justify-content-center rounded-circle"
                                                    for="color-2"></label>
                                            </li>
                                            <li>
                                                <input type="radio" name="colors" value="warning" id="color-3">
                                                <label
                                                    class="avatar-xs btn btn-warning p-0 d-flex align-items-center justify-content-center rounded-circle"
                                                    for="color-3"></label>
                                            </li>
                                            <li>
                                                <input type="radio" name="colors" value="danger" id="color-4">
                                                <label
                                                    class="avatar-xs btn btn-danger p-0 d-flex align-items-center justify-content-center rounded-circle"
                                                    for="color-4"></label>
                                            </li>
                                            <li>
                                                <input type="radio" name="colors" value="primary" id="color-5">
                                                <label
                                                    class="avatar-xs btn btn-primary p-0 d-flex align-items-center justify-content-center rounded-circle"
                                                    for="color-5"></label>
                                            </li>
                                            <li>
                                                <input type="radio" name="colors" value="secondary" id="color-6">
                                                <label
                                                    class="avatar-xs btn btn-secondary p-0 d-flex align-items-center justify-content-center rounded-circle"
                                                    for="color-6"></label>
                                            </li>
                                            <li>
                                                <input type="radio" name="colors" value="dark" id="color-7">
                                                <label
                                                    class="avatar-xs btn btn-dark p-0 d-flex align-items-center justify-content-center rounded-circle"
                                                    for="color-7"></label>
                                            </li>
                                            <li>
                                                <input type="radio" name="colors" value="light" id="color-8">
                                                <label
                                                    class="avatar-xs btn btn-light p-0 d-flex align-items-center justify-content-center rounded-circle"
                                                    for="color-8"></label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div> -->
                            <!-- end accordion-item -->

                            <!-- <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingSize">
                                    <button class="accordion-button bg-transparent shadow-none" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#flush-collapseSize"
                                        aria-expanded="true" aria-controls="flush-collapseSize">
                                        <span class="text-muted text-uppercase fs-12 fw-medium">Sizes</span> <span
                                            class="badge bg-success rounded-pill align-middle ms-1 filter-badge"></span>
                                    </button>
                                </h2>

                                <div id="flush-collapseSize" class="accordion-collapse collapse show"
                                    aria-labelledby="flush-headingSize">
                                    <div class="accordion-body text-body pt-0">
                                        <ul class="clothe-size list-unstyled hstack gap-3 mb-0 flex-wrap"
                                            id="size-filter">
                                            <li>
                                                <input type="radio" name="sizes" value="xs" id="sizeXs">
                                                <label
                                                    class="avatar-xs btn btn-soft-primary p-0 d-flex align-items-center justify-content-center rounded-circle"
                                                    for="sizeXs">XS</label>
                                            </li>
                                            <li>
                                                <input type="radio" name="sizes" value="s" id="sizeS">
                                                <label
                                                    class="avatar-xs btn btn-soft-primary p-0 d-flex align-items-center justify-content-center rounded-circle"
                                                    for="sizeS">S</label>
                                            </li>
                                            <li>
                                                <input type="radio" name="sizes" value="m" id="sizeM">
                                                <label
                                                    class="avatar-xs btn btn-soft-primary p-0 d-flex align-items-center justify-content-center rounded-circle"
                                                    for="sizeM">M</label>
                                            </li>
                                            <li>
                                                <input type="radio" name="sizes" value="l" id="sizeL">
                                                <label
                                                    class="avatar-xs btn btn-soft-primary p-0 d-flex align-items-center justify-content-center rounded-circle"
                                                    for="sizeL">L</label>
                                            </li>
                                            <li>
                                                <input type="radio" name="sizes" value="xl" id="sizeXl">
                                                <label
                                                    class="avatar-xs btn btn-soft-primary p-0 d-flex align-items-center justify-content-center rounded-circle"
                                                    for="sizeXl">XL</label>
                                            </li>
                                            <li>
                                                <input type="radio" name="sizes" value="2xl" id="size2xl">
                                                <label
                                                    class="avatar-xs btn btn-soft-primary p-0 d-flex align-items-center justify-content-center rounded-circle"
                                                    for="size2xl">2XL</label>
                                            </li>
                                            <li>
                                                <input type="radio" name="sizes" value="3xl" id="size3xl">
                                                <label
                                                    class="avatar-xs btn btn-soft-primary p-0 d-flex align-items-center justify-content-center rounded-circle"
                                                    for="size3xl">3XL</label>
                                            </li>
                                            <li>
                                                <input type="radio" name="sizes" value="4xl" id="size4xl">
                                                <label
                                                    class="avatar-xs btn btn-soft-primary p-0 d-flex align-items-center justify-content-center rounded-circle"
                                                    for="size4xl">4XL</label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div> -->
                            <!-- end accordion-item -->

                            <!-- <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingBrands">
                                    <button class="accordion-button bg-transparent shadow-none" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#flush-collapseBrands"
                                        aria-expanded="true" aria-controls="flush-collapseBrands">
                                        <span class="text-muted text-uppercase fs-12 fw-medium">Brands</span> <span
                                            class="badge bg-success rounded-pill align-middle ms-1 filter-badge"></span>
                                    </button>
                                </h2>

                                <div id="flush-collapseBrands" class="accordion-collapse collapse show"
                                    aria-labelledby="flush-headingBrands">
                                    <div class="accordion-body text-body pt-0">
                                        <div class="search-box search-box-sm">
                                            <input type="text" class="form-control bg-light border-0"
                                                id="searchBrandsList" placeholder="Search Brands...">
                                            <i class="ri-search-line search-icon"></i>
                                        </div>
                                        <div class="d-flex flex-column gap-2 mt-3 filter-check">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="Boat"
                                                    id="productBrandRadio5">
                                                <label class="form-check-label" for="productBrandRadio5">Boat</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="OnePlus"
                                                    id="productBrandRadio4">
                                                <label class="form-check-label" for="productBrandRadio4">OnePlus</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="Realme"
                                                    id="productBrandRadio3">
                                                <label class="form-check-label" for="productBrandRadio3">Realme</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="Sony"
                                                    id="productBrandRadio2">
                                                <label class="form-check-label" for="productBrandRadio2">Sony</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="JBL"
                                                    id="productBrandRadio1">
                                                <label class="form-check-label" for="productBrandRadio1">JBL</label>
                                            </div>

                                            <div>
                                                <button type="button"
                                                    class="btn btn-link text-decoration-none text-uppercase fw-medium p-0">1,235
                                                    More</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            <!-- end accordion-item -->

                            <!-- <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingDiscount">
                                    <button class="accordion-button bg-transparent shadow-none collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#flush-collapseDiscount"
                                        aria-expanded="true" aria-controls="flush-collapseDiscount">
                                        <span class="text-muted text-uppercase fs-12 fw-medium">Discount</span> <span
                                            class="badge bg-success rounded-pill align-middle ms-1 filter-badge"></span>
                                    </button>
                                </h2>
                                <div id="flush-collapseDiscount" class="accordion-collapse collapse"
                                    aria-labelledby="flush-headingDiscount">
                                    <div class="accordion-body text-body pt-1">
                                        <div class="d-flex flex-column gap-2 filter-check" id="discount-filter">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="50"
                                                    id="productdiscountRadio6">
                                                <label class="form-check-label" for="productdiscountRadio6">50% or
                                                    more</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="40"
                                                    id="productdiscountRadio5">
                                                <label class="form-check-label" for="productdiscountRadio5">40% or
                                                    more</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="30"
                                                    id="productdiscountRadio4">
                                                <label class="form-check-label" for="productdiscountRadio4">
                                                    30% or more
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="20"
                                                    id="productdiscountRadio3">
                                                <label class="form-check-label" for="productdiscountRadio3">
                                                    20% or more
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="10"
                                                    id="productdiscountRadio2">
                                                <label class="form-check-label" for="productdiscountRadio2">
                                                    10% or more
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="0"
                                                    id="productdiscountRadio1">
                                                <label class="form-check-label" for="productdiscountRadio1">
                                                    Less than 10%
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            <!-- end accordion-item -->

                            <!-- <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingRating">
                                    <button class="accordion-button bg-transparent shadow-none collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#flush-collapseRating"
                                        aria-expanded="false" aria-controls="flush-collapseRating">
                                        <span class="text-muted text-uppercase fs-12 fw-medium">Rating</span> <span
                                            class="badge bg-success rounded-pill align-middle ms-1 filter-badge"></span>
                                    </button>
                                </h2>

                                <div id="flush-collapseRating" class="accordion-collapse collapse"
                                    aria-labelledby="flush-headingRating">
                                    <div class="accordion-body text-body">
                                        <div class="d-flex flex-column gap-2 filter-check" id="rating-filter">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="4"
                                                    id="productratingRadio4">
                                                <label class="form-check-label" for="productratingRadio4">
                                                    <span class="text-muted">
                                                        <i class="mdi mdi-star text-warning"></i>
                                                        <i class="mdi mdi-star text-warning"></i>
                                                        <i class="mdi mdi-star text-warning"></i>
                                                        <i class="mdi mdi-star text-warning"></i>
                                                        <i class="mdi mdi-star"></i>
                                                    </span> 4 & Above
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="3"
                                                    id="productratingRadio3">
                                                <label class="form-check-label" for="productratingRadio3">
                                                    <span class="text-muted">
                                                        <i class="mdi mdi-star text-warning"></i>
                                                        <i class="mdi mdi-star text-warning"></i>
                                                        <i class="mdi mdi-star text-warning"></i>
                                                        <i class="mdi mdi-star"></i>
                                                        <i class="mdi mdi-star"></i>
                                                    </span> 3 & Above
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="2"
                                                    id="productratingRadio2">
                                                <label class="form-check-label" for="productratingRadio2">
                                                    <span class="text-muted">
                                                        <i class="mdi mdi-star text-warning"></i>
                                                        <i class="mdi mdi-star text-warning"></i>
                                                        <i class="mdi mdi-star"></i>
                                                        <i class="mdi mdi-star"></i>
                                                        <i class="mdi mdi-star"></i>
                                                    </span> 2 & Above
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="1"
                                                    id="productratingRadio1">
                                                <label class="form-check-label" for="productratingRadio1">
                                                    <span class="text-muted">
                                                        <i class="mdi mdi-star text-warning"></i>
                                                        <i class="mdi mdi-star"></i>
                                                        <i class="mdi mdi-star"></i>
                                                        <i class="mdi mdi-star"></i>
                                                        <i class="mdi mdi-star"></i>
                                                    </span> 1
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            <!-- end accordion-item -->
                        </div>
                    </div>
                    <!-- end card -->
                </div>
                <div class="flex-grow-1" id="col-3-layout">
                    <div class="d-flex align-items-center gap-2 mb-4">
                        <p id="product-count" class="text-muted flex-grow-1 mb-0">Showing 1-12 of 84 results</p>

                        <div class="flex-shrink-0">
                            <div class="d-flex gap-2">
                                <div class="flex-shrink-0">
                                    <label for="sort-elem" class="col-form-label">Sort By:</label>
                                </div>
                                <div class="flex-shrink-0">
                                    <select class="form-select w-md" id="sort-elem">
                                        <!-- <option value="">All</option> -->
                                        <option value="a_to_z">A - Z</option>
                                        <option value="z_to_a">Z - A</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="product-grid"></div>
                    <div class="row" id="pagination-element">
                        <div class="col-lg-12">
                            <div
                                class="pagination-block pagination pagination-separated justify-content-center justify-content-sm-end mb-sm-0">
                                <div class="page-item">
                                    <a href="javascript:void(0);" class="page-link" id="page-prev">Previous</a>
                                </div>
                                <span id="page-num" class="pagination"></span>
                                <div class="page-item">
                                    <a href="javascript:void(0);" class="page-link" id="page-next">Next</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row d-none" id="search-result-elem">
                        <div class="col-lg-12">
                            <div class="text-center py-5">
                                <div class="avatar-lg mx-auto mb-4">
                                    <div class="avatar-title bg-primary-subtle text-primary rounded-circle fs-24">
                                        <i class="bi bi-search"></i>
                                    </div>
                                </div>

                                <h4>No matching records found</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="offer-bar flex-shrink-0">
                    <div class="d-flex gap-3 flex-column">
                        <div class="card fs-13 border border-primary border-opacity-25">
                            <div class="card-header text-center bg-primary-subtle border-0">
                                <h6 class="card-title text-uppercase fs-13 mb-0 text-primary">Deals of the week</h6>
                            </div>
                            <div class="card-body">
                                <div class="px-5">
                                    <img src="{{ URL::asset('build/images/products/img-16.png') }}" alt=""
                                        class="img-fluid d-block mx-auto">
                                </div>
                                <div class="mt-4 text-center">
                                    <h4 class="text-body mb-3">$63.00 <span
                                            class="text-muted fs-12"><del>$123.99</del></span></h4>
                                    <a href="#!" class="stretched-link">
                                        <h5 class="mb-4">Ninja Pro Max Smartwatch</h5>
                                    </a>
                                </div>
                                <div class="progress animated-progress custom-progress">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 60%"
                                        aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mt-2">
                                    <div class="flex-grow-1 fw-medium fs-12">
                                        <span class="text-muted">Sold</span>: 451 Items
                                    </div>
                                    <div class="fw-medium fs-12">
                                        <span class="text-muted">Available</span>: 90 Items
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="offer-banner rounded-3"
                            style="background-image: url('build/images/ecommerce/offer-banner.jpg');background-size: cover;background-position: center;">
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
        <!--end conatiner-fluid-->
    </div>
@endsection
@section('scripts')
    <script>
        const productListData = @json($productsArray);
    </script>

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
