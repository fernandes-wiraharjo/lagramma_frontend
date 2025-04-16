<!-- JAVASCRIPT -->
<script src="{{ URL::asset('build/libs/bootstrap/bootstrap.bundle.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ URL::asset('build/js/plugins.js') }}"></script>

<script>
    const backendUrl = @json(config('app.backend_url'));

    fetch(`${backendUrl}/api/user`, {
    credentials: 'include',
    headers: {
        'Accept': 'application/json'
    }
    }).then(res => {
    if (res.ok) {
        return res.json();
    } else if (res.status === 401) {
        console.log('User is not logged in');
        return null;
    } else {
        console.error('Unexpected error status:', res.status);
        return null;
    }
    }).then(user => {
    if (user) {
        // console.log('User is logged in:', user);

        // Authenticated user
        document.getElementById('userDropdownContent').innerHTML = `
        <h6 class="dropdown-header">Welcome ${user.name}!</h6>
        <a class="dropdown-item" href="account"><i class="bi bi-person-circle text-muted fs-15 me-1"></i> Profile</a>
        <a class="dropdown-item" href="order-history"><i class="bi bi-cart4 text-muted fs-15 me-1"></i> Order History</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="account"><i class="mdi mdi-cog-outline text-muted fs-15 me-1"></i> Settings</a>
        <a class="dropdown-item" href="${backendUrl}/logout"><i class="bi bi-box-arrow-right text-muted fs-15 me-1"></i> Logout</a>
        `;
    } else {
        console.log('Guest mode');

        // Guest mode
        document.getElementById('userDropdownContent').innerHTML = `
        <h6 class="dropdown-header">Welcome, Guest!</h6>
        <p class="dropdown-item-text">Please log in to access your account.</p>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="${backendUrl}/login"><i class="bi bi-box-arrow-in-right text-muted fs-15 me-1"></i> Login</a>
        `;
    }
    }).catch(err => {
    console.error('Error fetching user:', err);
    });
</script>
@yield('scripts')
