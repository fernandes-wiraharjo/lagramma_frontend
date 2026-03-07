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
    <div class="position-relative" style="padding-top: 40px;">
        <div class="container container-1440">
            {{-- Top Section --}}
            <div class="row" style="font-size: 1.25rem; font-weight: 400;">
                {{-- Bread Crumbs --}}
                <div class="col-12 col-md-6">
                    <div>Home > Shop</div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="d-flex justify-content-between justify-content-md-end gap-4">
                        <div id="product-count">113 Items</div>
                        <div>
                            <select class="form-select form-select-sm lg-sort-select" id="sort-elem">
                                <option value="" selected>Sort by</option>
                                <option value="a_to_z">A - Z</option>
                                <option value="z_to_a">Z - A</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" style="font-size: 1.25rem; font-weight: 400; padding-top: 20px;">
                <div class="col-12">
                    <div class="lg-show-filter">
                        <svg viewBox="0 0 16 16" aria-hidden="true" focusable="false">
                            <path d="M2 4h12M4.5 8h7M7 12h2" />
                        </svg>
                        <span>Show Filter</span>
                    </div>
                </div>
            </div>

            <div class="ecommerce-product gap-4" style="margin-top: 40px;">
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
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end card -->
                </div>
                <div class="flex-grow-1" id="col-3-layout">
                    <div class="d-flex align-items-center gap-2 mb-4">
                        {{-- <p id="product-count" class="text-muted flex-grow-1 mb-0">Showing 1-12 of 84 results</p> --}}

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
