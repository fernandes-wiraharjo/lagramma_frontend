document.addEventListener('DOMContentLoaded', function () {
    const checkoutBtn = document.getElementById('create-order-btn');
    const radioButtons = document.querySelectorAll('input[name="shippingAddress"]');
    const shippingOptionWrapper = document.getElementById('shippingOptionWrapper');
    const shippingSelect = document.getElementById('shippingOption');
    let shippingOptions = [];

    //get shipping cost
    async function fetchShippingCost(address) {
        const response = await fetch('/calculate-shipping', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                receiver_destination_id: address.region_id,
                destination_pin_point: `${address.latitude},${address.longitude}`,
                weight: totalWeight,
                item_value: subtotal
            })
        });

        const data = await response.json();

        // Combine all available shipping types into one array
        const allTypes = [
            ...(data.data?.calculate_reguler || []),
            ...(data.data?.calculate_cargo || []),
            ...(data.data?.calculate_instant || [])
        ];

        shippingOptions = allTypes;

        // Populate the dropdown
        shippingSelect.innerHTML = '';
        shippingOptions.forEach((option, index) => {
            const opt = document.createElement('option');
            opt.value = index;
            opt.text = `${option.shipping_name} - ${option.service_name} (etd: ${option.etd})`;
            shippingSelect.appendChild(opt);
        });

        // Trigger display of first option by default
        if (shippingOptions.length > 0) {
            updateDisplayedCost(0);
        }
    }

    function updateDisplayedCost(index) {
        const option = shippingOptions[index];
        if (!option) return;

        shippingCost = option.shipping_cost;
        grandTotal = shippingCost + subtotal;

        document.getElementById('shippingCost').innerText = `Rp ${shippingCost.toLocaleString()}`;
        document.getElementById('grandTotal').innerText = `Rp ${grandTotal.toLocaleString()}`;
    }

    //selected address event
    function selectedAddress() {
        const selected = document.querySelector('input[name="shippingAddress"]:checked');
        const enabled = hasAddress && selected;
        checkoutBtn.disabled = !enabled;

        if (selected) {
            shippingOptionWrapper.classList.remove('d-none');
            const address = JSON.parse(selected.dataset.address);
            fetchShippingCost(address);
        } else {
            shippingOptionWrapper.classList.add('d-none');
        }
    }

    // Handle change of shipping option
    shippingSelect.addEventListener('change', function () {
        updateDisplayedCost(this.value);
    });

    // Run on load
    selectedAddress();

    // Bind event listeners to all radio buttons
    radioButtons.forEach(radio => {
        radio.addEventListener('change', selectedAddress);
    });
});

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
