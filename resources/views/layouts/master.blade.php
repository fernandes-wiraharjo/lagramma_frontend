<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light" data-footer="dark">

<head>
    <meta charset="utf-8">
    <title>La Gramma | @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="La gramma store" name="description">
    <meta content="Fernandes Wiraharjo" name="author">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('build/images/favicon.ico') }}">

    <!-- head css -->
    @include('layouts.head-css')
</head>

<body>

    <!-- top tagbar -->
    @include('layouts.top-tagbar')
    <!-- topbar -->
    @include('layouts.topbar')

    @yield('content')

    <!-- footer -->
    @include('layouts.footer')
    <!-- scripts -->
    @include('layouts.vendor-scripts')

    <script>
        const backendUrl = @json(config('app.backend_url'));

        //get user session
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
                    <a href="#" onclick="logoutStore()" class="dropdown-item">
                        <i class="bi bi-box-arrow-right text-muted fs-15 me-1"></i> Logout
                    </a>
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


        //get csrf token
        async function getCSRFToken() {
            const response = await fetch(`${backendUrl}/sanctum/csrf-cookie`, {
                method: 'GET',
                credentials: 'include',  // Include credentials for cookie sharing
            });

            if (!response.ok) {
                throw new Error('Failed to set CSRF cookie');
            }

            // Extract XSRF-TOKEN from document.cookie
            const getCookie = (name) => {
                const value = `; ${document.cookie}`;
                const parts = value.split(`; ${name}=`);
                if (parts.length === 2) return parts.pop().split(';').shift();
            };

            return decodeURIComponent(getCookie('XSRF-TOKEN'));
        }

        //logout store function
        async function logoutStore() {
            const xsrfToken = await getCSRFToken();

            fetch(`${backendUrl}/api/logout-store`, {
                method: 'POST',
                credentials: 'include',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-XSRF-TOKEN': xsrfToken,
                }
            })
            .then(res => {
                if (res.ok) {
                    alert('Logged out successfully');

                    // Reload or refresh dropdown in guest mode
                    document.getElementById('userDropdownContent').innerHTML = `
                        <h6 class="dropdown-header">Welcome, Guest!</h6>
                        <p class="dropdown-item-text">Please log in to access your account.</p>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="${backendUrl}/login">
                            <i class="bi bi-box-arrow-in-right text-muted fs-15 me-1"></i> Login
                        </a>
                    `;
                } else {
                    console.error('Logout failed:', res.status);
                }
            })
            .catch(err => console.error('Error during logout:', err));
        }
    </script>
</body>

</html>
