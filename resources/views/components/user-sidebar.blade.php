<!-- User Sidebar -->
<div class="offcanvas offcanvas-end lg-user-sidebar" tabindex="-1" id="userSidebar" aria-labelledby="userSidebarLabel">
    {{-- Mobile Header --}}
    <div class="container container-1440 w-100 pb-2 pt-2 lg-topbar-main-row lg-user-sidebar-header">
        <div class="row w-100 g-0 align-items-center">
            <!-- Close Toggle -->
            <div class="col-auto pe-2">
                <button type="button" class="btn p-0 border-0 bg-transparent position-relative lg-topbar-action"
                    data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="bi bi-x-lg lg-topbar-icon"></i>
                </button>
            </div>

            <!-- Logo - Center -->
            <div class="col d-flex align-items-center justify-content-center">
                <a class="navbar-brand me-0 text-center" href="/">
                    <div class="logo-dark">
                        <img src="{{ URL::asset('build/images/logo-dark.png') }}" alt=""
                            class="lg-topbar-logo lg-topbar-logo-dark">
                    </div>
                    <div class="logo-light">
                        <img src="{{ URL::asset('build/images/logo-light.png') }}" alt=""
                            class="lg-topbar-logo">
                    </div>
                </a>
            </div>

            <!-- Icons - Right -->
            <div class="col-auto d-flex align-items-center justify-content-end lg-topbar-icons">
                <div class="topbar-head-dropdown ms-1 header-item d-none d-sm-flex">
                    @php
                        $cart = session('shopping_cart', []);
                        $cartCount = count($cart);
                        $subtotal = collect($cart)->sum('total_price');
                    @endphp
                    <button type="button" class="btn p-0 border-0 bg-transparent position-relative lg-topbar-action"
                        data-bs-toggle="offcanvas" data-bs-target="#ecommerceCart" aria-controls="ecommerceCart">
                        <i class="bi bi-cart3 lg-topbar-icon"></i>
                        @if ($cartCount > 0)
                            <span
                                class="position-absolute topbar-badge lg-cartitem-badge fs-10 translate-middle badge rounded-pill bg-danger">{{ $cartCount }}</span>
                        @endif
                    </button>
                </div>

                <div class="header-item">
                    <button type="button" class="btn p-0 border-0 bg-transparent lg-topbar-action"
                        data-bs-toggle="offcanvas" data-bs-target="#userSidebar" aria-controls="userSidebar">
                        <i class="bi bi-person lg-topbar-icon"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="offcanvas-body" data-simplebar>
        {{-- Sidebar content goes here --}}
    </div>
</div>
