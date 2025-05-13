var swiper = new Swiper(".productSwiper", {

    spaceBetween: 10,
    slidesPerView: 4,
    mousewheel: true,
    freeMode: true,
    watchSlidesProgress: true,
    breakpoints: {
      992: {
        slidesPerView: 4,
        spaceBetween: 10,
        direction: "vertical",
      },
    },
  });
  var swiper2 = new Swiper(".productSwiper2", {
    loop: true,
    spaceBetween: 10,
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    thumbs: {
      swiper: swiper,
    },
  });

document.addEventListener('DOMContentLoaded', function () {
    //non hampers variable
    const variantInputs = document.querySelectorAll('input[name="variant"]');
    const modifierInputs = document.querySelectorAll('input[name="modifier_option[]"]');
    const quantityInput = document.querySelector('.product-quantity1');
    const minusBtn = document.getElementById('btn-minus');
    const plusBtn = document.getElementById('btn-plus');
    const totalPriceEl = document.getElementById('total-price');
    const basePriceEl = document.getElementById('base-price');
    const addToCartBtn = document.getElementById('btn-add-to-cart');
    const buyNowBtn = document.getElementById('btn-buy-now');

    //get product info and init variable
    const productInfo = document.getElementById('product-info');
    const productCategory = productInfo?.dataset.category || '';
    const productId = productInfo?.dataset.productId || '';
    const productName = productInfo?.dataset.productName || '';
    const productMainImage = productInfo?.dataset.mainImage || '';
    const productWeight = productInfo?.dataset.weight || 0;
    const productLength = productInfo?.dataset.length || 0;
    const productWidth = productInfo?.dataset.width || 0;
    const productHeight = productInfo?.dataset.height || 0;
    const isHampers = productCategory === 'hampers';
    let basePrice = 0;
    let hamperStock = 0;
    let quantity = parseInt(quantityInput.value);

    addToCartBtn.disabled = false;
    buyNowBtn.disabled = false;

    //js for hampers item
    if (isHampers && productInfo.dataset.basePrice) {
        //hampers variable
        const itemQtyInputs = document.querySelectorAll('.hamper-qty');
        const itemQtyInputswarning = document.getElementById('hamper-warning');
        const maxItems = parseInt(productInfo?.dataset.maxItems) || 0;

        hamperStock = parseInt(productInfo.dataset.stock);
        basePrice = hamperStock <= 0 ? 0 : parseInt(productInfo.dataset.basePrice);
        updateTotalPrice(); // Immediately show total

        function validateTotalItemQty() {
            let totalitemQty = 0;
            itemQtyInputs.forEach(input => {
                totalitemQty += parseInt(input.value || 0);
            });

            if (totalitemQty > maxItems) {
                itemQtyInputswarning.style.display = 'block';
                itemQtyInputs.forEach(input => input.classList.add('is-invalid'));
                addToCartBtn.disabled = true;
                buyNowBtn.disabled = true;
            } else {
                itemQtyInputswarning.style.display = 'none';
                itemQtyInputs.forEach(input => input.classList.remove('is-invalid'));

                if (hamperStock > 0) {
                    addToCartBtn.disabled = false;
                    buyNowBtn.disabled = false;
                }
            }
        }

        itemQtyInputs.forEach(input => {
            input.addEventListener('input', validateTotalItemQty);
        });
    }

    //js for non hampers
    if (!isHampers) {
        // Variant selection
        variantInputs.forEach(input => {
            input.addEventListener('change', function () {
                basePrice = parseInt(this.value) || 0;
                updateTotalPrice();
            });
        });

        // Modifier checkbox selection
        modifierInputs.forEach(input => {
            input.addEventListener('change', function () {
                updateTotalPrice();
            });
        });

        addToCartBtn.disabled = true
        buyNowBtn.disabled = true
    }

    //general function
    function getSelectedModifierTotal() {
        let total = 0;
        document.querySelectorAll('input[name="modifier_option[]"]:checked').forEach(mod => {
            const price = parseInt(mod.value) || 0;
            total += price;
        });
        return total;
    }

    function updateTotalPrice() {
        if (basePrice === 0) {
            if (hamperStock <= 0 && isHampers) {
                basePriceEl.innerHTML = '<span class="text-danger fs-14 fst-italic ms-2">(Out of Stock)</span>'
            }
            addToCartBtn.disabled = true;
            buyNowBtn.disabled = true;
            totalPriceEl.classList.add('d-none');
            return;
        }

        addToCartBtn.disabled = false;
        buyNowBtn.disabled = false;

        const modifierPrice = getSelectedModifierTotal();
        const total = (basePrice + modifierPrice) * quantity;

        basePriceEl.innerHTML = `IDR ${formatRupiah(basePrice)}`;
        totalPriceEl.textContent = `Total Harga: IDR ${formatRupiah(total)}`;
        totalPriceEl.classList.remove('d-none');
    }

    function formatRupiah(number) {
        return number.toLocaleString('id-ID');
    }

    // Quantity buttons
    plusBtn.addEventListener('click', () => {
        if (quantity < 100) {
            quantity++;
            quantityInput.value = quantity;
            updateTotalPrice();
        }
    });

    minusBtn.addEventListener('click', () => {
        if (quantity > 1) {
            quantity--;
            quantityInput.value = quantity;
            updateTotalPrice();
        }
    });

    // Add to cart
    function addToCart() {
        const payload = {
            quantity: parseInt(quantityInput.value),
            is_hampers: isHampers,
            product_id: productId,
            product_name: productName,
            type: isHampers ? "hampers" : "product",
            main_image: productMainImage,
            weight: productWeight,
            length: productLength,
            width: productWidth,
            height: productHeight
        };

        if (isHampers) {
            const hamperVariantId = productInfo.dataset.hampersVariantId;
            const hamperVariantName = productInfo.dataset.hampersVariantName;

            // Collect hamper items
            const hamperItems = {};
            document.querySelectorAll('.hamper-qty').forEach(input => {
                const itemIdMatch = input.getAttribute('name').match(/hamper_items\[(\d+)\]/);
                if (itemIdMatch) {
                    const itemId = itemIdMatch[1];
                    const qty = parseInt(input.value) || 0;
                    if (qty > 0) hamperItems[itemId] = qty;
                }
            });
            if (Object.keys(hamperItems).length === 0) {
                alert('Please select at least one hamper item.');
                return;
            }

            payload.hamper_stock = hamperStock;
            payload.hamper_items = hamperItems;
            payload.variant_id = hamperVariantId;
            payload.variant_name = hamperVariantName;
            payload.price = basePrice;
        } else {
            const variantInput = document.querySelector('input[name="variant"]:checked');
            if (!variantInput) {
                alert('Please select a variant.');
                return;
            }

            const selectedModifiers = [];
            document.querySelectorAll('input[name="modifier_option[]"]:checked').forEach(el => {
                selectedModifiers.push({
                    modifier_id: el.dataset.modifierId,              // add this as hidden input or data attribute
                    modifier_name: el.dataset.modifierName,          // add this too
                    modifier_option_id: el.id.replace('modifier-option-', ''),
                    modifier_option_name: el.dataset.optionName,
                    price: el.value
                });
            });

            payload.variant_id = variantInput.dataset.variantId;
            payload.variant_name = variantInput.dataset.variantName;
            payload.price = variantInput.value;
            payload.modifiers = selectedModifiers;
        }

        fetch('/add-to-cart', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(payload)
        })
        .then(res => res.json())
        .then(data => {
            alert(data.message || 'Something went wrong');
            if (data.success) {
                location.reload();
            }
        })
        .catch(err => {
            console.error(err);
            alert('Error occurred.');
        });
    }

    // Buy now
    function buyNow() {
        if (!isLoggedIn) {
            alert('Silahkan login terlebih dahulu untuk melanjutkan ke halaman checkout.');
            const currentUrl = window.location.href;
            const backendLoginUrl = `${backendUrl}/login?redirect=${encodeURIComponent(currentUrl)}`;
            window.location.href = backendLoginUrl;
            return;
        }

        const payload = {
            quantity: parseInt(quantityInput.value),
            is_hampers: isHampers,
            product_id: productId,
            product_name: productName,
            type: isHampers ? "hampers" : "product",
            main_image: productMainImage,
            weight: productWeight,
            length: productLength,
            width: productWidth,
            height: productHeight
        };

        if (isHampers) {
            const hamperVariantId = productInfo.dataset.hampersVariantId;
            const hamperVariantName = productInfo.dataset.hampersVariantName;

            // Collect hamper items
            const hamperItems = {};
            document.querySelectorAll('.hamper-qty').forEach(input => {
                const itemIdMatch = input.getAttribute('name').match(/hamper_items\[(\d+)\]/);
                if (itemIdMatch) {
                    const itemId = itemIdMatch[1];
                    const qty = parseInt(input.value) || 0;
                    if (qty > 0) hamperItems[itemId] = qty;
                }
            });
            if (Object.keys(hamperItems).length === 0) {
                alert('Please select at least one hamper item.');
                return;
            }

            payload.hamper_stock = hamperStock;
            payload.hamper_items = hamperItems;
            payload.variant_id = hamperVariantId;
            payload.variant_name = hamperVariantName;
            payload.price = basePrice;
        } else {
            const variantInput = document.querySelector('input[name="variant"]:checked');
            if (!variantInput) {
                alert('Please select a variant.');
                return;
            }

            const selectedModifiers = [];
            document.querySelectorAll('input[name="modifier_option[]"]:checked').forEach(el => {
                selectedModifiers.push({
                    modifier_id: el.dataset.modifierId,              // add this as hidden input or data attribute
                    modifier_name: el.dataset.modifierName,          // add this too
                    modifier_option_id: el.id.replace('modifier-option-', ''),
                    modifier_option_name: el.dataset.optionName,
                    price: el.value
                });
            });

            payload.variant_id = variantInput.dataset.variantId;
            payload.variant_name = variantInput.dataset.variantName;
            payload.price = variantInput.value;
            payload.modifiers = selectedModifiers;
        }

        fetch('/buy-now', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(payload)
        })
        .then(res => res.json())
        .then(data => {
            alert(data.message || 'Something went wrong');
            if (data.success) {
                window.location.href = '/checkout?source=buy_now';
            }
        })
        .catch(err => {
            console.error(err);
            alert('Error occurred.');
        });
    }

    addToCartBtn.addEventListener('click', () => addToCart());
    buyNowBtn.addEventListener('click', () => buyNow());
});
