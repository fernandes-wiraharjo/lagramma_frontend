@extends('layouts.master')
@section('title')
    Catalogue
@endsection
@section('css')
    <!-- extra css -->

    <!-- nouisliderribute css -->
    <link rel="stylesheet" href="{{ URL::asset('build/libs/nouislider/nouislider.min.css') }}">

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

            {{-- Filter Section Start --}}
            <div class="row" style="font-size: 1.25rem; font-weight: 400; padding-top: 20px;">
                <div class="col-12">
                    <button class="lg-show-filter" type="button" data-bs-toggle="collapse"
                        data-bs-target="#catalogue-filter-panel" aria-expanded="false"
                        aria-controls="catalogue-filter-panel">
                        <svg viewBox="0 0 16 16" aria-hidden="true" focusable="false">
                            <path d="M2 4h12M4.5 8h7M7 12h2" />
                        </svg>
                        <span>Show Filter</span>
                    </button>

                    <div class="lg-filter-toggle-wrap">
                        <div class="collapse lg-filter-collapse" id="catalogue-filter-panel">
                            <div class="lg-filter-floating">
                                <x-catalogue-filter-section :categories="$categories" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ecommerce-product gap-4" style="margin-top: 40px;">
                <div class="flex-grow-1" id="col-3-layout">
                    <div class="row" id="product-grid"></div>
                    <div class="row pb-4" id="pagination-element">
                        <div class="col-lg-12">
                            <div
                                class="pagination-block pagination pagination-separated justify-content-center justify-content-sm-end mb-sm-0">
                                <div class="page-item">
                                    <a href="javascript:void(0);" class="btn btn-primary lagramma-btn-hover w-100 add-btn" id="page-prev">Previous</a>
                                </div>
                                <span id="page-num" class="pagination"></span>
                                <div class="page-item" style="margin-left: 0.35rem;">
                                    <a href="javascript:void(0);" class="btn btn-primary lagramma-btn-hover w-100 add-btn" id="page-next">Next</a>
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
