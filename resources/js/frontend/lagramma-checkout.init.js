let shippingOptions = [];

document.addEventListener('DOMContentLoaded', function () {
    const checkoutBtn = document.getElementById('create-order-btn');
    const radioButtons = document.querySelectorAll('input[name="shippingAddress"]');
    const shippingOptionWrapper = document.getElementById('shippingOptionWrapper');
    const shippingSelect = document.getElementById('shippingOption');
    const sendToOtherContainer = document.getElementById('sendToOtherContainer');
    const cbSendToOther = document.getElementById('cbSendToOther');
    const stoFields = document.getElementById('sto_fields');

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
            sendToOtherContainer.classList.remove('d-none');
            const address = JSON.parse(selected.dataset.address);
            fetchShippingCost(address);
        } else {
            shippingOptionWrapper.classList.add('d-none');
            sendToOtherContainer.classList.add('d-none');
            cbSendToOther.checked = false;
            stoFields.classList.add('d-none');
        }
    }

    // Show/hide sto fields based on checkbox
    cbSendToOther.addEventListener('change', function () {
        if (this.checked) {
            stoFields.classList.remove('d-none');
        } else {
            stoFields.classList.add('d-none');
        }
    });

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

    // Selected shipping option
    const selectedShippingIndex = document.getElementById('shippingOption').value;
    const selectedShipping = shippingOptions[selectedShippingIndex];

    // Selected address
    const selectedAddress = document.querySelector('input[name="shippingAddress"]:checked');
    const address = JSON.parse(selectedAddress.dataset.address);

    // STO (Send to Other) Fields
    const sendToOtherChecked = document.getElementById('cbSendToOther').checked;
    const stoPicName = sendToOtherChecked ? document.getElementById('sto_pic_name').value : '';
    const stoPicPhone = sendToOtherChecked ? document.getElementById('sto_pic_phone').value : '';
    const stoReceiverName = sendToOtherChecked ? document.getElementById('sto_receiver_name').value : '';
    const stoReceiverPhone = sendToOtherChecked ? document.getElementById('sto_receiver_phone').value : '';
    const stoNote = sendToOtherChecked ? document.getElementById('sto_note').value : '';

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
            source: checkoutSource,  // <-- send 'buy_now' or 'cart'
            receiver_address_id: address.id,
            receiver_destination_id: address.region_id,
            receiver_address: address.address,
            destination_pin_point: `${address.latitude},${address.longitude}`,
            shipping: selectedShipping.shipping_name,
            shipping_type: selectedShipping.service_name,
            shipping_cost: selectedShipping.shipping_cost,
            shipping_cashback: selectedShipping.shipping_cashback,
            service_fee: selectedShipping.service_fee,
            grand_total: grandTotal,
            is_send_to_other: sendToOtherChecked,
            sto_pic_name: stoPicName,
            sto_pic_phone: stoPicPhone,
            sto_receiver_name: stoReceiverName,
            sto_receiver_phone: stoReceiverPhone,
            sto_note: stoNote
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
