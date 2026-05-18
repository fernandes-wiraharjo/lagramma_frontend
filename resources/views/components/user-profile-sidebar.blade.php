<!-- User Profile Sidebar - Mobile -->
<div class="offcanvas offcanvas-end d-lg-none" tabindex="-1" id="userProfileSidebar"
    aria-labelledby="userProfileSidebarLabel">

    {{-- Header --}}
    <div class="offcanvas-header lg-user-sidebar-header">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-person-circle text-white fs-4"></i>
            <h5 class="offcanvas-title text-white mb-0" id="userProfileSidebarLabel">
                @auth
                    Welcome, {{ Auth::user()->name }}!
                @else
                    Welcome to Lagramma
                @endauth
            </h5>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
            aria-label="Close"></button>
    </div>

    {{-- Body --}}
    <div class="offcanvas-body p-0">
        @auth
            <div class="list-group list-group-flush">
                <a href="/account" class="list-group-item list-group-item-action py-3 px-4">
                    <i class="bi bi-person-circle text-muted me-2"></i> Profile
                </a>
                <a href="/order-history" class="list-group-item list-group-item-action py-3 px-4">
                    <i class="bi bi-cart4 text-muted me-2"></i> Order History
                </a>
                <a href="/track-order" class="list-group-item list-group-item-action py-3 px-4">
                    <i class="bi bi-truck text-muted me-2"></i> Track Orders
                </a>
                <div class="list-group-item border-0">
                    <a href="{{ config('app.backend_url') }}/logout"
                        class="btn btn-outline-danger w-100 rounded-5 py-2 mt-2">
                        <i class="bi bi-box-arrow-right me-1"></i> Logout
                    </a>
                </div>
            </div>
        @else
            <div class="p-4">
                <p class="text-muted mb-4">Sign in to access your account, track orders, and more.</p>
                <a href="/login" class="btn lagramma-button-solid w-100 rounded-5 py-3 mb-3">
                    Login
                </a>
                <a href="/register" class="btn lagramma-button-outline solid-border w-100 rounded-5 py-3">
                    Sign Up
                </a>
            </div>
        @endauth
    </div>
</div>
