document.getElementById('create-order-btn').addEventListener('click', function () {
    if (!isLoggedIn) {
        alert('Silahkan login terlebih dahulu untuk melanjutkan proses checkout.');
        const currentUrl = window.location.href;
        const backendLoginUrl = `${backendUrl}/login?redirect=${encodeURIComponent(currentUrl)}`;
        window.location.href = backendLoginUrl;
        return;
    }

    fetch('/checkout', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert('Order created successfully');
            window.location.href = '/';
        } else {
            alert(data.message);
        }
    })
    .catch(err => {
        console.error(err);
        alert('Error checkout process.');
    });
});
