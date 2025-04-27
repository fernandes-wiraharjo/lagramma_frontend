document.getElementById('create-order-btn').addEventListener('click', function () {
    if (!isLoggedIn) {
        alert('Silahkan login terlebih dahulu untuk melanjutkan proses checkout.');
        const currentUrl = window.location.href;
        const backendLoginUrl = `${backendUrl}/login?redirect=${encodeURIComponent(currentUrl)}`;
        window.location.href = backendLoginUrl;
        return;
    }

    const createOrderButton = document.getElementById('create-order-btn');
    const buttonText = document.getElementById('btn-text');
    const loadingSpinner = document.getElementById('loading-spinner');

    // Disable the button and show loading spinner
    createOrderButton.disabled = true;
    buttonText.classList.add('d-none');
    loadingSpinner.classList.remove('d-none');

    fetch('/checkout', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            source: checkoutSource  // <-- send 'buy_now' or 'cart'
        })
    })
    .then(res => res.json())
    .then(data => {
        // Re-enable the button
        createOrderButton.disabled = false;
        buttonText.classList.remove('d-none');
        loadingSpinner.classList.add('d-none');

        alert(data.message);
        if (data.success) {
            window.location.href = data.redirect_url;
        }
    })
    .catch(err => {
        // Re-enable the button in case of an error
        createOrderButton.disabled = false;
        buttonText.classList.remove('d-none');
        loadingSpinner.classList.add('d-none');

        console.error(err);
        alert('Error checkout process.');
    });
});
