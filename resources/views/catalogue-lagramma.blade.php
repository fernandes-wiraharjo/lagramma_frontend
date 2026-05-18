@extends('layouts.master')
@section('title')
    Catalogue
@endsection
@section('css')
    <!-- extra css -->

    <!-- nouisliderribute css -->
    <link rel="stylesheet" href="{{ URL::asset('build/libs/nouislider/nouislider.min.css') }}">

    <style>
        .flexible-top-padding {
            padding-top: 0px;
        }

        .filter-padding {
            padding-top: 0px;
            padding-bottom: 20px;
        }

        @media (min-width: 768px) {
            .flexible-top-padding {
                padding-top: 40px;
            }

            .filter-padding {
                padding-top: 20px;
                padding-bottom: 0px;
            }
        }
    </style>
@endsection
@section('content')
    {{-- Mobile Breadcrumb --}}
    <div class="position-relative pt-4 d-md-none">
        <div class="container container-1440">
            <div class="row breadcrumb-spacing">
                <div class="col-6 col-md-6 fs-14">
                    <x-breadcrumb :items="[['label' => 'Home', 'url' => '/'], ['label' => 'Shop']]" />
                </div>

                <div class="col-6 col-md-6 fs-14 jusityf">
                    <div class="d-flex justify-content-end gap-2">
                        <div id="product-count">113 Items</div>
                        {{-- Sort Options --}}
                        <div class="dropdown lg-sort-dropdown">
                            <button class="lg-sort-trigger dropdown-toggle" type="button" id="sort-trigger"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Sort by
                            </button>
                            <div class="dropdown-menu lg-popup-panel lg-sort-popup">
                                <button class="dropdown-item lg-sort-option" type="button" data-sort="a_to_z">
                                    Name, A - Z
                                </button>
                                <button class="dropdown-item lg-sort-option" type="button" data-sort="z_to_a">
                                    Name, Z - A
                                </button>
                            </div>
                            <select class="form-select form-select-sm lg-sort-select d-none" id="sort-elem">
                                <option value="a_to_z">Name, A - Z</option>
                                <option value="z_to_a">Name, Z - A</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row breadcrumb-spacing">
                <div class="col-12 col-md-6">
                    <div class="border-bottom border-dark border-2"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="position-relative flexible-top-padding">
        <div class="container container-1440">
            {{-- Top Section --}}
            <div class="row d-none d-md-block" style="font-size: 1.25rem; font-weight: 400;">
                {{-- Bread Crumbs --}}
                <div class="col-12 d-flex justify-content-between gap-4">
                    <div>
                        <x-breadcrumb :items="[['label' => 'Home', 'url' => '/'], ['label' => 'Shop']]" />
                    </div>

                    <div class="d-flex justify-content-between justify-content-md-end gap-4">
                        <div id="product-count-desktop">113 Items</div>
                        {{-- Sort Options --}}
                        <div class="dropdown lg-sort-dropdown">
                            <button class="lg-sort-trigger dropdown-toggle" type="button" id="sort-trigger-desktop"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Sort by
                            </button>
                            <div class="dropdown-menu lg-popup-panel lg-sort-popup">
                                <button class="dropdown-item lg-sort-option" type="button" data-sort="a_to_z">
                                    Name, A - Z
                                </button>
                                <button class="dropdown-item lg-sort-option" type="button" data-sort="z_to_a">
                                    Name, Z - A
                                </button>
                            </div>
                            <select class="form-select form-select-sm lg-sort-select d-none" id="sort-elem-desktop">
                                <option value="a_to_z">Name, A - Z</option>
                                <option value="z_to_a">Name, Z - A</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Filter Section Start --}}
            <div class="row filter-padding" style="font-size: 1.25rem; font-weight: 400;">
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

            <div class="ecommerce-product gap-4 mt-0 mt-md-4">
                <div class="flex-grow-1" id="col-3-layout">
                    <div class="row" id="product-grid"></div>
                    <div class="row pb-4" id="pagination-element">
                        <div class="col-lg-12">
                            <div
                                class="pagination-block pagination pagination-separated justify-content-center justify-content-sm-end mb-sm-0">
                                <div class="page-item">
                                    <a href="javascript:void(0);" class="btn btn-primary lagramma-btn-hover w-100 add-btn"
                                        id="page-prev">Previous</a>
                                </div>
                                <span id="page-num" class="pagination"></span>
                                <div class="page-item" style="margin-left: 0.35rem;">
                                    <a href="javascript:void(0);" class="btn btn-primary lagramma-btn-hover w-100 add-btn"
                                        id="page-next">Next</a>
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
    <script>
        document.querySelectorAll('.lg-sort-option').forEach(function(optionButton) {
            optionButton.addEventListener('click', function() {
                var sortSelect = document.getElementById('sort-elem') || document.getElementById(
                    'sort-elem-desktop');
                if (!sortSelect) return;
                sortSelect.value = optionButton.getAttribute('data-sort') || '';
                sortSelect.dispatchEvent(new Event('change', {
                    bubbles: true
                }));
            });
        });
    </script>
    <!-- coming-soon -->
    <script src="{{ URL::asset('build/js/pages/coming-soon.init.js') }}"></script>

    <!-- landing-index js -->
    <script src="{{ URL::asset('build/js/frontend/menu.init.js') }}"></script>
@endsection
