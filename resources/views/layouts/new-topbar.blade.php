<nav id="new-topbar">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <!-- Left: Search Product -->
        <div class="topbar-search" style="max-width: 300px;">
            <div class="position-relative w-100">
                <input type="text" class="form-control" placeholder="Search product...">
                <i class="bi bi-search position-absolute top-50 end-0 translate-middle-y me-3 text-muted"></i>
            </div>
        </div>

        <!-- Center: La Gramma Logo -->
        <div class="flex-grow-1 text-center">
            <a href="/" class="d-inline-block">
                <img src="https://placehold.co/390x63/png?text=La+Gramma" alt="La Gramma Logo" height="63">
            </a>
        </div>

        <!-- Right: Cart and Profile Buttons -->
        <div class="d-flex align-items-center gap-3">
            @php
                $cart = session('shopping_cart', []);
                $cartCount = count($cart);
            @endphp

            <!-- Cart Button -->
            <div class="topbar-head-dropdown header-item">
                <button type="button" class="btn btn-icon btn-topbar-icon rounded-circle" data-bs-toggle="offcanvas" data-bs-target="#ecommerceCart" aria-controls="ecommerceCart">
                    <i class="ph-shopping-cart fs-18"></i>
                    @if ($cartCount > 0)
                        <span class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger">{{ $cartCount }}</span>
                    @endif
                </button>
            </div>

            <!-- Profile Button -->
            <div class="dropdown header-item dropdown-hover-end">
                <button type="button" class="btn btn-icon btn-topbar-icon rounded-circle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    @if(@Auth::user()->avatar)
                        <img class="rounded-circle header-profile-user" src="{{ URL::asset('images/users').'/'.@Auth::user()->avatar }}" alt="Header Avatar">
                    @else
                        <img class="rounded-circle header-profile-user" src="{{ URL::asset('build/images/users/user-dummy-img.jpg') }}" alt="Header Avatar">
                    @endif
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="#" onclick="logoutStore()">
                        <i class="bi bi-box-arrow-right text-muted fs-16 align-middle me-1"></i>
                        <span class="align-middle">Logout</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>
