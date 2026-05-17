let shippingOptions = [];

// address section
let feMap;
let feMarker;

function feInitMap() {
    const pontianak = { lat: -0.0263, lng: 109.3414 };

    feMap = new google.maps.Map(document.getElementById("fe-map"), {
        center: pontianak,
        zoom: 14,
    });

    feMarker = new google.maps.Marker({
        position: pontianak,
        map: feMap,
        draggable: true
    });

    feMarker.addListener("dragend", e => feUpdateLatLng(e.latLng.lat(), e.latLng.lng()));

    feMap.addListener("click", e => {
        feMarker.setPosition(e.latLng);
        feUpdateLatLng(e.latLng.lat(), e.latLng.lng());
    });

    // Search Box
    const input = document.getElementById("fe-search-address");
    const searchBox = new google.maps.places.SearchBox(input);

    feMap.addListener("bounds_changed", () => {
        searchBox.setBounds(feMap.getBounds());
    });

    searchBox.addListener("places_changed", () => {
        const places = searchBox.getPlaces();
        if (!places.length) return;

        const place = places[0];
        if (!place.geometry) return;

        feMarker.setPosition(place.geometry.location);
        feMap.panTo(place.geometry.location);
        feMap.setZoom(15);

        feUpdateLatLng(place.geometry.location.lat(), place.geometry.location.lng());
    });

    feUpdateLatLng(pontianak.lat, pontianak.lng);
}

window.feInitMap = feInitMap;

function feUpdateLatLng(lat, lng) {
    document.getElementById("fe-latitude").value = lat.toFixed(6);
    document.getElementById("fe-longitude").value = lng.toFixed(6);
}
// end of address section

document.addEventListener('DOMContentLoaded', function () {
    // address section
    // OPEN MODAL
    $("#feAddAddressButton").on("click", function () {
        const modal = new bootstrap.Modal("#feAddAddressModal");
        modal.show();
    });

    $("#feAddAddressModal").on("shown.bs.modal", function () {
        $("#fe-region-select").select2({
            dropdownParent: $("#feAddAddressModal .modal-body"),
            placeholder: "Search region…",
            minimumInputLength: 3,
            ajax: {
                url: `${backendUrl}/account/komerce/search-region`,
                delay: 250,
                dataType: "json",
                type: "GET",
                xhrFields: {
                    withCredentials: true   // IMPORTANT: send cookies
                },
                crossDomain: true,
                headers: {
                    "x-api-key": komerceApiKey
                },
                data: params => ({ keyword: params.term }),
                processResults: data => ({
                    results: data.data.map(item => ({
                        id: item.id,
                        text: item.label
                    }))
                })
            }
        });
    });

    $("#fe-region-select").on("select2:select", e => {
        const data = e.params.data;
        $("#fe-region-id").val(data.id);
        $("#fe-region-label").val(data.text);
    });

    // ======================================================
    // SUBMIT ADDRESS → BACKEND API
    // ======================================================
    $("#feCreateAddressForm").on("submit", async function (e) {
        e.preventDefault();
        const xsrfToken = await getCSRFToken();

        const payload = {
            label: $("#fe-name").val(),
            address: $("#fe-address").val(),
            latitude: $("#fe-latitude").val(),
            longitude: $("#fe-longitude").val(),
            region_id: $("#fe-region-id").val(),
            region_label: $("#fe-region-label").val(),
        };

        fetch(`${backendUrl}/account/addresses`, {
            method: "POST",
            credentials: "include",
            headers: {
                "Content-Type": "application/json",
                'X-XSRF-TOKEN': xsrfToken
            },
            body: JSON.stringify(payload)
        })
        .then(res => {
            if (!res.ok) throw new Error("Failed to save address");
            return res.json();
        })
        .then(() => {
            bootstrap.Modal.getInstance(document.getElementById("feAddAddressModal")).hide();
            location.reload(); // refresh checkout page
        })
        .catch(err => alert(err.message));
    });
    // end of address section

    const checkoutBtns = document.querySelectorAll('.create-order-btn');
    const radioButtons = document.querySelectorAll('input[name="shippingAddress"]');
    const shippingOptionWrapper = document.getElementById('shippingOptionWrapper');
    const shippingSelect = document.getElementById('shippingOption');
    const sendToOtherContainer = document.getElementById('sendToOtherContainer');
    const cbSendToOther = document.getElementById('cbSendToOther');
    const cbTermCondition = document.getElementById('cbTermCondition');
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

        document.querySelectorAll('.shipping-cost').forEach(el => {
            el.innerText = `IDR ${shippingCost.toLocaleString()}`;
        });
        document.querySelectorAll('.grand-total').forEach(el => {
            el.innerText = `IDR ${grandTotal.toLocaleString()}`;
        });
    }

    //selected address event
    function selectedAddress() {
        const selected = document.querySelector('input[name="shippingAddress"]:checked');
        const enabled = hasAddress && selected && itemCount > 0 && cbTermCondition.checked;
        checkoutBtns.forEach(btn => btn.disabled = !enabled);

        // Highlight selected address card
        document.querySelectorAll('.card-radio').forEach(card => card.classList.remove('address-selected'));

        if (selected) {
            selected.closest('.card-radio').classList.add('address-selected');
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

    // Bind T&C checkbox to update button state
    cbTermCondition.addEventListener('change', selectedAddress);
});

document.querySelectorAll('.create-order-btn').forEach(function (createOrderButton) {
    createOrderButton.addEventListener('click', function () {
        if (!isLoggedIn) {
            alert('Silahkan login terlebih dahulu untuk melanjutkan proses checkout.');
            const currentUrl = window.location.href;
            const backendLoginUrl = `${backendUrl}/login?redirect=${encodeURIComponent(currentUrl)}`;
            window.location.href = backendLoginUrl;
            return;
        }

        const buttonText = createOrderButton.querySelector('.btn-text');
        const loadingSpinner = createOrderButton.querySelector('.loading-spinner');

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
});
