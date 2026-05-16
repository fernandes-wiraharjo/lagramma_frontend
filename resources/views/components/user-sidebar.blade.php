 <!-- Offcanvas Sidebar -->
 <div class="offcanvas offcanvas-end border-0 ecommerce-user-sidebar" tabindex="-1" id="userSidebar"
     aria-labelledby="userSidebarLabel">
     <div class="pb-2 pt-2 px-2 lg-topbar-header">
         <div class="row w-100 g-0 align-items-center">
             <div class="col-auto pe-2">
                 <button type="button" class="btn p-0 border-0 bg-transparent position-relative lg-topbar-action"
                     data-bs-dismiss="offcanvas" aria-label="Close"><i class="bi bi-x-lg lg-topbar-icon"></i></button>
             </div>

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

             <div class="col-auto d-flex align-items-center justify-content-end lg-topbar-icons">
                 <div class="header-item d-none d-sm-flex">
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
         {{--
            <h5 class="offcanvas-title" id="userSidebarLabel">
                Sidebar Menu
            </h5>

            <button
            type="button"
            class="btn-close"
            data-bs-dismiss="offcanvas"
            aria-label="Close"
            ></button>
        --}}
     </div>

     <div class="offcanvas-body">
         <ul class="navbar-nav mb-0 pt-2" id="user-sidebar-menu">
             <li class="nav-item nav-link text-black fw-semibold fs-18 py-2">
                 Welcome
             </li>
             <li class="nav-item nav-link text-black fw-normal fs-18 py-3">
                 Enjoy a sweeter experience with La Gramma
             </li>
             <li class="nav-item py-2">
                 <a
                     class="nav-link text-black fs-18 fw-light {{ request()->is('/login') ? 'menu-underline lg-navbar-menu-link' : '' }}"
                     href="{{ config('app.backend_url') }}/login">Login</a>
             </li>
             <li class="nav-item py-2">
                 <a
                     class="nav-link text-black fs-18 fw-light {{ request()->is('/register') ? 'menu-underline lg-navbar-menu-link' : '' }}"
                     href="{{ config('app.backend_url') }}/register">Sign Up</a>
                 </a>
             </li>
         </ul>
     </div>
 </div>
