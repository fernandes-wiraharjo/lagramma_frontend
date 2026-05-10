 <!-- Offcanvas Sidebar -->
 <div class="offcanvas offcanvas-end border-0 ecommerce-user-sidebar" tabindex="-1" id="userSidebar" aria-labelledby="userSidebarLabel" style="width: 100%;">
     <div class="pb-2 pt-2 px-2" style="background-color: #0c3e3c; max-height: 80px;">
         <div class="row w-100 g-0 align-items-center">
             <div class="col-auto pe-2">
                 <button type="button" class="btn p-0 border-0 bg-transparent position-relative lg-topbar-action"
                     data-bs-dismiss="offcanvas" aria-label="Close"><i class="bi bi-x-lg lg-topbar-icon"></i></button>
             </div>

             <div class="col d-flex align-items-center justify-content-center">
                 <a class="navbar-brand me-0 text-center" href="/">
                     <div class="logo-dark">
                         <img src="{{ URL::asset('build/images/logo-dark.png') }}" alt=""
                             class="lg-topbar-logo lg-topbar-logo-dark" style="width: auto; height: 30px;">
                     </div>
                     <div class="logo-light">
                         <img src="{{ URL::asset('build/images/logo-light.png') }}" alt=""
                             class="lg-topbar-logo" style="width: auto; height: 30px;">
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
         <p>This sidebar slides from right to left.</p>

         <ul class="list-group">
             <li class="list-group-item">Dashboard</li>
             <li class="list-group-item">Profile</li>
             <li class="list-group-item">Settings</li>
             <li class="list-group-item">Logout</li>
         </ul>
     </div>
 </div>
