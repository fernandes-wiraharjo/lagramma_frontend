document.getElementById('lg-checkout-btn').addEventListener('click', function () {
    fetch('/cart/validate-stock', {
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
            window.location.href = data.redirect_url;
        } else {
            alert(data.message); // or use SweetAlert/toast
        }
    })
    .catch(err => {
        console.error(err);
        alert('Error validating stock.');
    });
});
