<nav class="navbar navbar-expand-lg ecommerce-navbar" id="navbar">
    <div class="container">
        <a class="navbar-brand d-none d-lg-block" href="index">
            <div class="logo-dark">
                <img src="{{ URL::asset('build/images/logo-dark.png') }}" alt="" height="25">
            </div>
            <div class="logo-light">
                <img src="{{ URL::asset('build/images/logo-light.png') }}" alt="" height="25">
            </div>
        </a>
        <button class="btn btn-soft-primary btn-icon d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="bi bi-list fs-20"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mx-lg-auto mb-2 mb-lg-0" id="navigation-menu">
                 <li class="nav-item d-block d-lg-none">
                    <a class="d-block p-3 h-auto text-center" href="index.html">
                        <img src="{{ URL::asset('build/images/logo-dark.png') }}" alt="" height="25" class="card-logo-dark mx-auto">
                        <img src="{{ URL::asset('build/images/logo-light.png') }}" alt="" height="25" class="card-logo-light mx-auto">
                    </a>
                </li>
                <li class="nav-item dropdown dropdown-hover">
                    <a class="nav-link dropdown-toggle" data-key="t-demos" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ __('t-demos') }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-md dropdown-menu-center dropdown-menu-list submenu">
                        <li class="nav-item">
                            <a href="index" class="nav-link" data-key="t-main-layout">{{ __('t-main-layout') }}</a>
                        </li>
                        <li class="nav-item">
                            <a href="watch-main-layout" class="nav-link" data-key="t-unique-watches">{{ __('t-unique-watches') }}</a>
                        </li>
                        <li class="nav-item">
                            <a href="modern-fashion" class="nav-link" data-key="t-modern-fashion">{{ __('t-modern-fashion') }}</a>
                        </li>
                        <li class="nav-item">
                            <a href="trend-fashion" class="nav-link" data-key="t-trend-fashion">{{ __('t-trend-fashion') }}</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown dropdown-hover dropdown-mega-full">
                    <a class="nav-link dropdown-toggle" data-key="t-catalog" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ __('t-catalog') }}
                    </a>
                    <div class="dropdown-menu p-0">
                        <div class="row g-0 g-lg-4">
                            <div class="col-lg-2 d-none d-lg-block">
                                <div class="card rounded-start rounded-0 border-0 h-100 mb-0 overflow-hidden" style="background-image: url('build/images/ecommerce/img-1.jpg');background-size: cover;">
                                    <div class="bg-overlay bg-light bg-opacity-25"></div>
                                    <div class="card-body d-flex align-items-center justify-content-center">
                                        <div class="text-center">
                                            <a href="product-grid-sidebar-banner" class="btn btn-secondary btn-hover"><i class="ph-storefront align-middle me-1"></i> <span data-key="t-shop-now">{{ __('t-shop-now') }}</span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <ul class="dropdown-menu-list list-unstyled mb-0 py-3">
                                    <li>
                                        <p class="mb-2 text-uppercase fs-11 fw-medium text-muted menu-title" data-key="t-men">{{ __('t-men') }}</p>
                                    </li>
                                    <li class="nav-item">
                                        <a href="product-grid-sidebar-banner" class="nav-link" data-key="t-clothing">{{ __('t-clothing') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="product-grid-right" class="nav-link" data-key="t-watches">{{ __('t-watches') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="product-list-left" class="nav-link" data-key="t-bags-Luggage">{{ __('t-bags-Luggage') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="product-grid-right" class="nav-link" data-key="t-footwear">{{ __('t-footwear') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="product-list" class="nav-link" data-key="t-innerwear">{{ __('t-innerwear') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="product-list-right" class="nav-link" data-key="t-other-accessories">{{ __('t-other-accessories') }}</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-2">
                                <ul class="dropdown-menu-list list-unstyled mb-0 py-3">
                                    <li>
                                        <p class="mb-2 text-uppercase fs-11 fw-medium text-muted menu-title" data-key="t-women">{{ __('t-women') }}</p>
                                    </li>
                                    <li class="nav-item">
                                        <a href="product-list-defualt" class="nav-link" data-key="t-western-wear">{{ __('t-western-wear') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="product-list-left" class="nav-link" data-key="t-handbags-clutches">{{ __('t-handbags-clutches') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="product-grid-right" class="nav-link" data-key="t-lingerie-nightwear">{{ __('t-lingerie-nightwear') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="product-grid-sidebar-banner" class="nav-link" data-key="t-footwear">{{ __('t-footwear') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="product-grid-defualt" class="nav-link" data-key="t-fashion-silver-jewellery">{{ __('t-fashion-silver-jewellery') }}</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-2">
                                <ul class="dropdown-menu-list list-unstyled mb-0 py-3">
                                    <li>
                                        <p class="mb-2 text-uppercase fs-11 fw-medium text-muted menu-title" data-key="t-accessories-others">{{ __('t-accessories-others') }}</p>
                                    </li>
                                    <li class="nav-item">
                                        <a href="product-grid-right" class="nav-link" data-key="t-home-kitchen-pets">{{ __('t-home-kitchen-pets') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="product-list-left" class="nav-link" data-key="t-beauty-health-grocery">{{ __('t-beauty-health-grocery') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="product-grid-sidebar-banner" class="nav-link" data-key="t-sports-fitness-bags-luggage">{{ __('t-sports-fitness-bags-luggage') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="product-list" class="nav-link" data-key="t-car-motorbike-industrial">{{ __('t-car-motorbike-industrial') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="product-list-right" class="nav-link" data-key="t-books">{{ __('t-books') }}</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-2">
                                <ul class="dropdown-menu-list list-unstyled mb-0 py-3">
                                    <li>
                                        <p class="mb-2 text-uppercase fs-11 fw-medium text-muted menu-title" data-key="t-others">{{ __('t-others') }}</p>
                                    </li>
                                    <li class="nav-item">
                                        <a href="auth-signup-basic" class="nav-link" data-key="t-sign-up">{{ __('t-sign-up') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="auth-signin-basic" class="nav-link" data-key="t-sign-in">{{ __('t-sign-in') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="auth-pass-reset-basic" class="nav-link" data-key="t-passowrd-reset">{{ __('t-passowrd-reset') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="auth-404" class="nav-link" data-key="t-error-404">{{ __('t-error-404') }}</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-2 d-none d-lg-block">
                                <div class="p-3">
                                    <p class="mb-3 text-uppercase fs-11 fw-medium text-muted" data-key="t-top-brands">{{ __('t-top-brands') }}</p>
                                    <div class="row g-2">
                                        <div class="col-lg-4">
                                            <a href="#!" class="d-block p-2 border border-dashed text-center rounded-3">
                                                <img src="{{ URL::asset('build/images/brands/img-8.png') }}" alt="" class="avatar-sm">
                                            </a>
                                        </div>
                                        <div class="col-lg-4">
                                            <a href="#!" class="d-block p-2 border border-dashed text-center rounded-3">
                                                <img src="{{ URL::asset('build/images/brands/img-2.png') }}" alt="" class="avatar-sm">
                                            </a>
                                        </div>
                                        <div class="col-lg-4">
                                            <a href="#!" class="d-block p-2 border border-dashed text-center rounded-3">
                                                <img src="{{ URL::asset('build/images/brands/img-3.png') }}" alt="" class="avatar-sm">
                                            </a>
                                        </div>
                                        <div class="col-lg-4">
                                            <a href="#!" class="d-block p-2 border border-dashed text-center rounded-3">
                                                <img src="{{ URL::asset('build/images/brands/img-4.png') }}" alt="" class="avatar-sm">
                                            </a>
                                        </div>
                                        <div class="col-lg-4">
                                            <a href="#!" class="d-block p-2 border border-dashed text-center rounded-3">
                                                <img src="{{ URL::asset('build/images/brands/img-5.png') }}" alt="" class="avatar-sm">
                                            </a>
                                        </div>
                                        <div class="col-lg-4">
                                            <a href="#!" class="d-block p-2 border border-dashed text-center rounded-3">
                                                <img src="{{ URL::asset('build/images/brands/img-6.png') }}" alt="" class="avatar-sm">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown dropdown-hover">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-key="t-shop">
                        {{ __('t-shop') }}
                    </a>
                    <div class="dropdown-menu dropdown-mega-menu-xl dropdown-menu-center p-0">
                        <div class="row g-0 g-lg-4">
                            <div class="col-lg-5 d-none d-lg-block">
                                <div class="card rounded-start rounded-0 border-0 h-100 mb-0 overflow-hidden" style="background-image: url('build/images/ecommerce/img-2.jpg'); background-size: cover;">
                                    <div class="bg-overlay bg-primary" style="opacity: 0.90;"></div>
                                    <div class="card-body d-flex align-items-center justify-content-center position-relative">
                                        <div class="text-center">
                                            <h6 class="card-title text-white">Welcome to Toner</h6>
                                            <p class="text-white-75">See all the products at once.</p>
                                            <a href="#!" class="btn btn-light btn-sm btn-hover">Shop Now <i class="ph-arrow-right align-middle"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="row g-0 g-lg-4">
                                    <div class="col-lg-6">
                                        <div class="py-3">
                                            <ul class="dropdown-menu-list list-unstyled mb-0">
                                                <li>
                                                    <p class="mb-2 text-uppercase fs-11 fw-medium text-muted menu-title" data-key="t-checkout-pages">{{ __('t-checkout-pages') }}</p>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="address" class="nav-link" data-key="t-address"> {{ __('t-address') }}</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="track-order" class="nav-link" data-key="t-track-order">{{ __('t-track-order') }}</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="payment" class="nav-link" data-key="t-payment">{{ __('t-payment') }}</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="review" class="nav-link" data-key="t-review">{{ __('t-review') }}</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="confirmation" class="nav-link" data-key="t-confirmation">{{ __('t-confirmation') }}</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="order-history" class="nav-link" data-key="t-my-orders-order-history">{{ __('t-my-orders-order-history') }}</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <ul class="dropdown-menu-list list-unstyled mb-0 py-3">
                                            <li>
                                                <p class="mb-2 text-uppercase fs-11 fw-medium text-muted menu-title" data-key="t-support">{{ __('t-support') }}</p>
                                            </li>
                                            <li class="nav-item">
                                                <a href="shop-cart" class="nav-link" data-key="t-shopping-cart">{{ __('t-shopping-cart') }}</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="checkout" class="nav-link" data-key="t-checkout">{{ __('t-checkout') }}</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="wishlist" class="nav-link" data-key="t-wishlist">{{ __('t-wishlist') }}</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown dropdown-hover">
                    <a class="nav-link dropdown-toggle" data-key="t-pages" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ __('t-pages') }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-md dropdown-menu-center dropdown-menu-list submenu">
                        <li class="nav-item dropdown dropdown-hover">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-key="t-products">{{ __('t-products') }}</a>
                            <ul class="dropdown-menu submenu">
                                <li class="dropdown dropdown-hover">
                                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-key="t-grid-view">{{ __('t-grid-view') }}</a>
                                    <ul class="dropdown-menu submenu">
                                        <li><a class="nav-link" href="product-grid-defualt" data-key="t-defualt">{{ __('t-defualt') }}</a></li>
                                        <li><a class="nav-link" href="product-grid-sidebar-banner" data-key="t-sidebar-with-banner">{{ __('t-sidebar-with-banner') }}</a></li>
                                        <li><a class="nav-link" href="product-grid-right" data-key="t-right-sidebar">{{ __('t-right-sidebar') }}</a></li>
                                        <li><a class="nav-link" href="product-grid" data-key="t-no-sidebar">{{ __('t-no-sidebar') }}</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown dropdown-hover">
                                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-key="t-list-view">{{ __('t-list-view') }}</a>
                                    <ul class="dropdown-menu submenu">
                                        <li><a class="nav-link" href="product-list-defualt" data-key="t-defualt">{{ __('t-defualt') }}</a></li>
                                        <li><a class="nav-link" href="product-list-left" data-key="t-left-sidebar">{{ __('t-left-sidebar') }}</a></li>
                                        <li><a class="nav-link" href="product-list-right" data-key="t-right-sidebar">{{ __('t-right-sidebar') }}</a></li>
                                        <li><a class="nav-link" href="product-list" data-key="t-no-sidebar">{{ __('t-no-sidebar') }}</a></li>
                                    </ul>
                                </li>
                                <li><a class="nav-link" href="product-details" data-key="t-product-details">{{ __('t-product-details') }}</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown dropdown-hover">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-key="t-users">{{ __('t-users') }}</a>
                            <ul class="dropdown-menu submenu">
                                <li><a class="nav-link" href="account" data-key="t-my-account">{{ __('t-my-account') }}</a></li>
                                <li><a class="nav-link" href="auth-signin-basic" data-key="t-sign-in">{{ __('t-sign-in') }}</a></li>
                                <li><a class="nav-link" href="auth-signup-basic" data-key="t-sign-up">{{ __('t-sign-up') }}</a></li>
                                <li><a class="nav-link" href="auth-pass-reset-basic" data-key="t-passowrd-reset">{{ __('t-passowrd-reset') }}</a></li>
                                <li><a class="nav-link" href="auth-pass-change-basic" data-key="t-create-password">{{ __('t-create-password') }}</a></li>
                                <li><a class="nav-link" href="auth-success-msg-basic" data-key="t-success-message">{{ __('t-success-message') }}</a></li>
                                <li><a class="nav-link" href="auth-twostep-basic" data-key="t-two-step-verify">{{ __('t-two-step-verify') }}</a></li>
                                <li><a class="nav-link" href="auth-logout-basic" data-key="t-logout">{{ __('t-logout') }}</a></li>
                                <li><a class="nav-link" href="auth-404" data-key="t-error-404">{{ __('t-error-404') }}</a></li>
                                <li><a class="nav-link" href="auth-500" data-key="t-error-500">{{ __('t-error-500') }}</a></li>
                                <li><a class="nav-link" href="coming-soon" data-key="t-coming-soon">{{ __('t-coming-soon') }}</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="products-category" class="nav-link" data-key="t-categories">{{ __('t-categories') }}</a>
                        </li>
                        <li class="nav-item">
                            <a href="about-us" class="nav-link" data-key="t-about">{{ __('t-about') }}</a>
                        </li>
                        <li class="nav-item">
                            <a href="purchase-guide" class="nav-link" data-key="t-purchase-guide">{{ __('t-purchase-guide') }}</a>
                        </li>
                        <li class="nav-item">
                            <a href="terms-conditions" class="nav-link" data-key="t-terms-of-service">{{ __('t-terms-of-service') }}</a>
                        </li>
                        <li class="nav-item">
                            <a href="privacy-policy" class="nav-link" data-key="t-privacy-policy">{{ __('t-privacy-policy') }}</a>
                        </li>
                        <li class="nav-item">
                            <a href="store-locator" class="nav-link" data-key="t-store-locator">{{ __('t-store-locator') }}</a>
                        </li>
                        <li class="nav-item">
                            <a href="ecommerce-faq" class="nav-link" data-key="t-faq">{{ __('t-faq') }}</a>
                        </li>
                        <li class="nav-item">
                            <a href="invoice" class="nav-link" data-key="t-invoice">{{ __('t-invoice') }}</a>
                        </li>
                        <li class="nav-item dropdown dropdown-hover">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-key="t-email-template">{{ __('t-email-template') }}</a>
                            <ul class="dropdown-menu submenu">
                                <li><a class="nav-link" href="email-black-friday" data-key="t-black-friday">{{ __('t-black-friday') }}</a></li>
                                <li><a class="nav-link" href="email-flash-sale" data-key="t-flash-sale">{{ __('t-flash-sale') }}</a></li>
                                <li><a class="nav-link" href="email-order-success" data-key="t-order-success">{{ __('t-order-success') }}</a></li>
                                <li><a class="nav-link" href="email-order-success-2" data-key="t-order-success-2">{{ __('t-order-success-2') }}</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown dropdown-hover">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-key="t-multi-level">{{ __('t-multi-level') }}</a>
                            <ul class="dropdown-menu submenu">
                                <li><a class="nav-link" href="#" data-key="t-level-1.1">{{ __('t-level-1.1') }}</a></li>
                                <li><a class="nav-link" href="#" data-key="t-level-1.2">{{ __('t-level-1.2') }}</a></li>
                                <li class="dropdown dropdown-hover">
                                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-key="t-level-1.3">{{ __('t-level-1.3') }}</a>
                                    <ul class="dropdown-menu submenu">
                                        <li><a class="nav-link" href="#" data-key="t-level-2.1">{{ __('t-level-2.1') }}</a></li>
                                        <li><a class="nav-link" href="#" data-key="t-level-2.2">{{ __('t-level-2.2') }}</a></li>
                                        <li class="dropdown dropdown-hover">
                                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-key="t-level-2.3">{{ __('t-level-2.3') }}</a>
                                            <ul class="dropdown-menu submenu">
                                                <li><a class="nav-link" href="#" data-key="t-level-3.1">{{ __('t-level-3.1') }}</a></li>
                                                <li><a class="nav-link" href="#" data-key="t-level-3.2">{{ __('t-level-3.2') }}</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="contact-us" data-key="t-contact">{{ __('t-contact') }}</a>
                </li>
            </ul>
        </div>
        <div class="bg-overlay navbar-overlay" data-bs-toggle="collapse"  data-bs-target="#navbarSupportedContent.show"></div>

        <div class="d-flex align-items-center">
            <button type="button" class="btn btn-icon btn-topbar btn-ghost-dark rounded-circle text-muted" data-bs-toggle="modal" data-bs-target="#searchModal">
                <i class="bx bx-search fs-22"></i>
            </button>
            <div class="topbar-head-dropdown ms-1 header-item">
                <button type="button" class="btn btn-icon btn-topbar btn-ghost-dark rounded-circle text-muted" data-bs-toggle="offcanvas" data-bs-target="#ecommerceCart" aria-controls="ecommerceCart">
                    <i class="ph-shopping-cart fs-18"></i>
                    <span class="position-absolute topbar-badge cartitem-badge fs-10 translate-middle badge rounded-pill bg-danger">4</span>
                </button>
            </div>
    
            <div class="dropdown topbar-head-dropdown ms-2 header-item dropdown-hover-end">
                <button type="button" class="btn btn-icon btn-topbar btn-ghost-dark rounded-circle text-muted" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="bi bi-sun align-middle fs-20"></i>
                </button>
                <div class="dropdown-menu p-2 dropdown-menu-end" id="light-dark-mode">
                    <a href="#!" class="dropdown-item" data-mode="light"><i class="bi bi-sun align-middle me-2"></i> Defualt (light mode)</a>
                    <a href="#!" class="dropdown-item" data-mode="dark"><i class="bi bi-moon align-middle me-2"></i> Dark</a>
                    <a href="#!" class="dropdown-item" data-mode="auto"><i class="bi bi-moon-stars align-middle me-2"></i> Auto (system defualt)</a>
                </div>
            </div>
            <div class="dropdown header-item dropdown-hover-end">
                <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="@if(@Auth::user()->avatar) {{ URL::asset('images/users')."/".@Auth::user()->avatar }} @else {{ URL::asset('build/images/users/avatar-1.jpg') }} @endif" alt="Header Avatar">
                </button>
                <!-- <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="ph-user-circle fs-22"></i>
                </button>    -->
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <h6 class="dropdown-header">Welcome {{ @Auth::user()->last_name }}!</h6>
                    <a class="dropdown-item" href="order-history"><i class="bi bi-cart4 text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Order History</span></a>
                    <a class="dropdown-item" href="track-order"><i class="bi bi-truck text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Track Orders</span></a>
                    <a class="dropdown-item" href="javascript:void(0)"><i class="bi bi-speedometer2 text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Dashboard</span></a>
                    <a class="dropdown-item" href="ecommerce-faq"><i class="mdi mdi-lifebuoy text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Help</span></a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="account"><i class="bi bi-coin text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Balance : <b>$8451.36</b></span></a>
                    <a class="dropdown-item" href="account"><span class="badge bg-success-subtle text-success mt-1 float-end">New</span><i class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Settings</span></a>
                    <a class="dropdown-item" href="{{ url('logout') }}"><i class="bi bi-box-arrow-right text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-key="t-logout">{{ __('t-logout') }}</span></a>
                </div>
            </div>
        </div>
    </div>
</nav>

<!--cart -->
<div class="offcanvas offcanvas-end product-list" tabindex="-1" id="ecommerceCart" aria-labelledby="ecommerceCartLabel">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title" id="ecommerceCartLabel">My Cart <span class="badge bg-danger align-middle ms-1 cartitem-badge">4</span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body px-0">
        <div data-simplebar  class="h-100">
            <ul class="list-group list-group-flush cartlist">
                <li class="list-group-item product">
                    <div class="d-flex gap-3">
                        <div class="flex-shrink-0">
                            <div class="avatar-md" style="height: 100%;">
                                <div class="avatar-title bg-warning-subtle rounded-3">
                                    <img src="{{ URL::asset('build/images/products/img-4.png') }}" alt="" class="avatar-sm">
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <a href="#!">
                                <h5 class="fs-15">Borosil Paper Cup</h5>
                            </a>
                            <div class="d-flex mb-3 gap-2">
                                <div class="text-muted fw-medium mb-0">$<span class="product-price">24.00</span></div>
                                <div class="vr"></div>
                                <span class="text-success fw-medium">In Stock</span>
                            </div>
                            <div class="input-step">
                                <button type="button" class="minus">–</button>
                                <input type="number" class="product-quantity" value="2" min="0" max="100" readonly>
                                <button type="button" class="plus">+</button>
                            </div>
                        </div>
                        <div class="flex-shrink-0 d-flex flex-column justify-content-between align-items-end">
                            <button type="button" class="btn btn-icon btn-sm btn-ghost-secondary remove-item-btn" data-bs-toggle="modal" data-bs-target="#removeItemModal"><i class="ri-close-fill fs-16"></i></button>
                            <div class="fw-medium mb-0 fs-16">$<span class="product-line-price">48.00</span></div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item product">
                    <div class="d-flex gap-3">
                        <div class="flex-shrink-0">
                            <div class="avatar-md" style="height: 100%;">
                                <div class="avatar-title bg-info-subtle rounded-3">
                                    <img src="{{ URL::asset('build/images/products/img-1.png') }}" alt="" class="avatar-sm">
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <a href="#!">
                                <h5 class="fs-15">Rockerz Ear Bluetooth Hea...</h5>
                            </a>
                            <div class="d-flex mb-3 gap-2">
                                <div class="text-muted fw-medium mb-0">$<span class="product-price">160.00</span></div>
                                <div class="vr"></div>
                                <span class="text-success fw-medium">In Stock</span>
                            </div>
                            <div class="input-step">
                                <button type="button" class="minus">–</button>
                                <input type="number" class="product-quantity" value="1" min="0" max="100" readonly>
                                <button type="button" class="plus">+</button>
                            </div>
                        </div>
                        <div class="flex-shrink-0 d-flex flex-column justify-content-between align-items-end">
                            <button type="button" class="btn btn-icon btn-sm btn-ghost-secondary remove-item-btn" data-bs-toggle="modal" data-bs-target="#removeItemModal"><i class="ri-close-fill fs-16"></i></button>
                            <div class="fw-medium mb-0 fs-16">$<span class="product-line-price">160.00</span></div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item product">
                    <div class="d-flex gap-3">
                        <div class="flex-shrink-0">
                            <div class="avatar-md" style="height: 100%;">
                                <div class="avatar-title bg-danger-subtle rounded-3">
                                    <img src="{{ URL::asset('build/images/products/img-6.png') }}" alt="" class="avatar-sm">
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <a href="#!">
                                <h5 class="fs-15">Monte Carlo Sweaters</h5>
                            </a>
                            <div class="d-flex mb-3 gap-2">
                                <div class="text-muted fw-medium mb-0">$ <span class="product-price">244.99</span></div>
                                <div class="vr"></div>
                                <span class="text-success fw-medium">In Stock</span>
                            </div>
                            <div class="input-step">
                                <button type="button" class="minus">–</button>
                                <input type="number" class="product-quantity" value="3" min="0" max="100" readonly>
                                <button type="button" class="plus">+</button>
                            </div>
                        </div>
                        <div class="flex-shrink-0 d-flex flex-column justify-content-between align-items-end">
                            <button type="button" class="btn btn-icon btn-sm btn-ghost-secondary remove-item-btn" data-bs-toggle="modal" data-bs-target="#removeItemModal"><i class="ri-close-fill fs-16"></i></button>
                            <div class="fw-medium mb-0 fs-16">$<span class="product-line-price">734.97</span></div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item product">
                    <div class="d-flex gap-3">
                        <div class="flex-shrink-0">
                            <div class="avatar-md" style="height: 100%;">
                                <div class="avatar-title bg-primary-subtle rounded-3">
                                    <img src="{{ URL::asset('build/images/products/img-8.png') }}" alt="" class="avatar-sm">
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <a href="#!">
                                <h5 class="fs-15">Men's Running Shoes Act...</h5>
                            </a>
                            <div class="d-flex mb-3 gap-2">
                                <div class="text-muted fw-medium mb-0">$<span class="product-price">120.30</span></div>
                                <div class="vr"></div>
                                <span class="text-success fw-medium">In Stock</span>
                            </div>
                            <div class="input-step">
                                <button type="button" class="minus">–</button>
                                <input type="number" class="product-quantity" value="2" min="0" max="100" readonly>
                                <button type="button" class="plus">+</button>
                            </div>
                        </div>
                        <div class="flex-shrink-0 d-flex flex-column justify-content-between align-items-end">
                            <button type="button" class="btn btn-icon btn-sm btn-ghost-secondary remove-item-btn" data-bs-toggle="modal" data-bs-target="#removeItemModal"><i class="ri-close-fill fs-16"></i></button>
                            <div class="fw-medium mb-0 fs-16">$<span class="product-line-price">240.60</span></div>
                        </div>
                    </div>
                </li>
            </ul>

            <div class="table-responsive mx-2 border-top border-top-dashed">
                <table class="table table-borderless mb-0 fs-14 fw-semibold">
                    <tbody>
                        <tr>
                            <td>Sub Total :</td>
                            <td class="text-end cart-subtotal">$1183.57</td>
                        </tr>
                        <tr>
                            <td>Discount <span class="text-muted">(Toner15)</span>:</td>
                            <td class="text-end cart-discount">- $177.54</td>
                        </tr>
                        <tr>
                            <td>Shipping Charge :</td>
                            <td class="text-end cart-shipping">$65.00</td>
                        </tr>
                        <tr>
                            <td>Estimated Tax (12.5%) : </td>
                            <td class="text-end cart-tax">$147.95</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="offcanvas-footer border-top p-3 text-center">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="m-0 fs-16 text-muted">Total:</h6>
            <div class="px-2">
                <h6 class="m-0 fs-16 cart-total">$1218.98</h6>
            </div>
        </div>
        <div class="row g-2">
            <div class="col-6">
                <button type="button" class="btn btn-light w-100" id="reset-layout">View Cart</button>
            </div>
            <div class="col-6">
                <a href="#!" target="_blank" class="btn btn-info w-100">Continue to Checkout</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="searchModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded">
            <div class="modal-header p-3">
                <div class="position-relative w-100">
                    <input type="text" class="form-control form-control-lg border-2" placeholder="Search for Toner..." autocomplete="off" id="search-options" value="">
                    <span class="bi bi-search search-widget-icon fs-17"></span>
                    <a href="javascript:void(0);" class="search-widget-icon fs-14 link-secondary text-decoration-underline search-widget-icon-close d-none" id="search-close-options">Clear</a>
                </div>
            </div>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0 overflow-hidden" id="search-dropdown">

                <div class="dropdown-head rounded-top">
                    <div class="p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0 fs-14 text-muted fw-semibold"> RECENT SEARCHES </h6>
                            </div>
                        </div>
                    </div>

                    <div class="dropdown-item bg-transparent text-wrap">
                        <a href="index" class="btn btn-soft-secondary btn-sm btn-rounded">how to setup <i class="mdi mdi-magnify ms-1 align-middle"></i></a>
                        <a href="index" class="btn btn-soft-secondary btn-sm btn-rounded">buttons <i class="mdi mdi-magnify ms-1 align-middle"></i></a>
                    </div>
                </div>

                <div data-simplebar style="max-height: 300px;" class="pe-2 ps-3 my-3">
                    <div class="list-group list-group-flush border-dashed">
                        <div class="notification-group-list">
                            <h5 class="text-overflow text-muted fs-13 mb-2 mt-3 text-uppercase notification-title">Apps Pages</h5>
                            <a href="javascript:void(0);" class="list-group-item dropdown-item notify-item"><i class="bi bi-speedometer2 me-2"></i> <span>Analytics Dashboard</span></a>
                            <a href="javascript:void(0);" class="list-group-item dropdown-item notify-item"><i class="bi bi-filetype-psd me-2"></i> <span>Toner.psd</span></a>
                            <a href="javascript:void(0);" class="list-group-item dropdown-item notify-item"><i class="bi bi-ticket-detailed me-2"></i> <span>Support Tickets</span></a>
                            <a href="javascript:void(0);" class="list-group-item dropdown-item notify-item"><i class="bi bi-file-earmark-zip me-2"></i> <span>Toner.zip</span></a>
                        </div>

                        <div class="notification-group-list">
                            <h5 class="text-overflow text-muted fs-13 mb-2 mt-3 text-uppercase notification-title">Links</h5>
                            <a href="javascript:void(0);" class="list-group-item dropdown-item notify-item"><i class="bi bi-link-45deg me-2 align-middle"></i> <span>www.themesbrand.com</span></a>
                        </div>

                        <div class="notification-group-list">
                            <h5 class="text-overflow text-muted fs-13 mb-2 mt-3 text-uppercase notification-title">People</h5>
                            <a href="javascript:void(0);" class="list-group-item dropdown-item notify-item">
                                <div class="d-flex align-items-center">
                                    <img src="{{ URL::asset('build/images/users/avatar-1.jpg') }}" alt="" class="avatar-xs rounded-circle flex-shrink-0 me-2">
                                    <div>
                                        <h6 class="mb-0">Ayaan Bowen</h6>
                                        <span class="fs-12 text-muted">React Developer</span>
                                    </div>
                                </div>
                            </a>
                            <a href="javascript:void(0);" class="list-group-item dropdown-item notify-item">
                                <div class="d-flex align-items-center">
                                    <img src="{{ URL::asset('build/images/users/avatar-7.jpg') }}" alt="" class="avatar-xs rounded-circle flex-shrink-0 me-2">
                                    <div>
                                        <h6 class="mb-0">Alexander Kristi</h6>
                                        <span class="fs-12 text-muted">React Developer</span>
                                    </div>
                                </div>
                            </a>
                            <a href="javascript:void(0);" class="list-group-item dropdown-item notify-item">
                                <div class="d-flex align-items-center">
                                    <img src="{{ URL::asset('build/images/users/avatar-5.jpg') }}" alt="" class="avatar-xs rounded-circle flex-shrink-0 me-2">
                                    <div>
                                        <h6 class="mb-0">Alan Carla</h6>
                                        <span class="fs-12 text-muted">React Developer</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- removeItemModal -->
<div id="removeItemModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>
            <div class="modal-body">
                <div class="mt-2 text-center">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                        <h4>Are you sure ?</h4>
                        <p class="text-muted mx-4 mb-0">Are you sure you want to remove this product ?</p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn w-sm btn-danger" id="remove-product">Yes, Delete It!</button>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="subscribeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0">
            <div class="modal-body p-0 bg-info-subtle rounded">
                <div class="row g-0 align-items-center">
                    <div class="col-lg-6">
                        <div class="p-4 h-100">
                            <span class="badge bg-info-subtle text-info fs-13">GET 10% SALE OFF</span>
                            <h2 class="display-6 mt-2 mb-3">Subscribe & Get <b>50% Special</b> Discount On Email</h2>
                            <p class="mb-4 pb-lg-2 fs-16">Join our newsletter to receive the latest updates and promotion</p>
                            <form action="#!">
                                <div class="position-relative ecommerce-subscript">
                                    <input type="email" class="form-control rounded-pill border-0" placeholder="Enter your email">
                                    <button type="submit" class="btn btn-info btn-hover rounded-pill">Subscript</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="p-4 pb-0">
                            <img src="{{ URL::asset('build/images/subscribe.png') }}" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end modal -->

{{-- <a href="../backend/index" class="btn btn-warning position-fixed bottom-0 start-0 m-5 z-3 btn-hover d-none d-lg-block"><i class="bi bi-database align-middle me-1"></i> Backend</a> --}}

<!--start back-to-top-->
<button onclick="topFunction()" class="btn btn-info btn-icon" style="bottom: 50px;" id="back-to-top">
    <i class="ri-arrow-up-line"></i>
</button>
<!--end back-to-top-->

<a class="btn btn-danger shadow-lg chat-button rounded-bottom-0 d-none d-lg-block" data-bs-toggle="collapse" href="#chatBot" aria-expanded="false" aria-controls="chatBot">Online Chat</a>
<div class="collapse chat-box" id="chatBot">
    <div class="card shadow-lg border-0 rounded-bottom-0 mb-0">
        <div class="card-header bg-success d-flex align-items-center border-0">
            <h5 class="text-white fs-16 fw-medium flex-grow-1 mb-0">Hi, Raquel Murillo 👋</h5>
            <button type="button" class="btn-close btn-close-white flex-shrink-0" onclick="chatBot()" data-bs-dismiss="collapse" aria-label="Close"></button>
        </div>
        <div class="card-body p-0">
            <div id="users-chat-widget">
                <div class="chat-conversation p-3" id="chat-conversation" data-simplebar style="height: 280px;">
                    <ul class="list-unstyled chat-conversation-list chat-sm" id="users-conversation">
                        <li class="chat-list left">
                            <div class="conversation-list">
                                <div class="chat-avatar">
                                    <img src="{{ URL::asset('build/images/logo-sm.png') }}" alt="">
                                </div>
                                <div class="user-chat-content">
                                    <div class="ctext-wrap">
                                        <div class="ctext-wrap-content">
                                            <p class="mb-0 ctext-content">Welcome to Themesbrand. We are here to help you. You can also directly email us at Support@themesbrand.com to schedule a meeting with our Technology Consultant.</p>
                                        </div>
                                        <div class="dropdown align-self-start message-box-drop">
                                            <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="ri-more-2-fill"></i>
                                            </a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#"><i class="ri-reply-line me-2 text-muted align-bottom"></i>Reply</a>
                                                <a class="dropdown-item" href="#"><i class="ri-file-copy-line me-2 text-muted align-bottom"></i>Copy</a>
                                                <a class="dropdown-item delete-item" href="#"><i class="ri-delete-bin-5-line me-2 text-muted align-bottom"></i>Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="conversation-name"><small class="text-muted time">09:07 am</small> <span class="text-success check-message-icon"><i class="ri-check-double-line align-bottom"></i></span></div>
                                </div>
                            </div>
                        </li>
                        <!-- chat-list -->

                        <li class="chat-list right">
                            <div class="conversation-list">
                                <div class="user-chat-content">
                                    <div class="ctext-wrap">
                                        <div class="ctext-wrap-content">
                                            <p class="mb-0 ctext-content">Good morning, How are you? What about our next meeting?</p>
                                        </div>
                                        <div class="dropdown align-self-start message-box-drop">
                                            <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="ri-more-2-fill"></i>
                                            </a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#"><i class="ri-reply-line me-2 text-muted align-bottom"></i>Reply</a>
                                                <a class="dropdown-item" href="#"><i class="ri-file-copy-line me-2 text-muted align-bottom"></i>Copy</a>
                                                <a class="dropdown-item delete-item" href="#"><i class="ri-delete-bin-5-line me-2 text-muted align-bottom"></i>Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="conversation-name"><small class="text-muted time">09:08 am</small> <span class="text-success check-message-icon"><i class="ri-check-double-line align-bottom"></i></span></div>
                                </div>
                            </div>
                        </li>
                        <!-- chat-list -->

                        <li class="chat-list left">
                            <div class="conversation-list">
                                <div class="chat-avatar">
                                    <img src="{{ URL::asset('build/images/logo-sm.png') }}" alt="">
                                </div>
                                <div class="user-chat-content">
                                    <div class="ctext-wrap">
                                        <div class="ctext-wrap-content">
                                            <p class="mb-0 ctext-content">Yeah everything is fine. Our next meeting tomorrow at 10.00 AM</p>
                                        </div>
                                        <div class="dropdown align-self-start message-box-drop">
                                            <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="ri-more-2-fill"></i>
                                            </a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#"><i class="ri-reply-line me-2 text-muted align-bottom"></i>Reply</a>
                                                <a class="dropdown-item" href="#"><i class="ri-file-copy-line me-2 text-muted align-bottom"></i>Copy</a>
                                                <a class="dropdown-item delete-item" href="#"><i class="ri-delete-bin-5-line me-2 text-muted align-bottom"></i>Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="conversation-name"><small class="text-muted time">09:10 am</small> <span class="text-success check-message-icon"><i class="ri-check-double-line align-bottom"></i></span></div>
                                </div>
                            </div>
                        </li>
                        <!-- chat-list -->

                    </ul>
                </div>
            </div>
            <div class="border-top border-top-dashed">
                <div class="row g-2 mt-2 mx-3 mb-3">
                    <div class="col">
                        <div class="position-relative">
                            <input type="text" class="form-control border-light bg-light" placeholder="Enter Message...">
                        </div>
                    </div><!-- end col -->
                    <div class="col-auto">
                        <button type="submit" class="btn btn-info"><i class="mdi mdi-send"></i></button>
                    </div><!-- end col -->
                </div><!-- end row -->
            </div>
        </div>
    </div>
</div>