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

    //get product info and init variable
    const productInfo = document.getElementById('product-info');
    const productCategory = productInfo?.dataset.category || '';
    const isHampers = productCategory === 'hampers';
    let basePrice = 0;
    let hamperStock = 0;
    let quantity = parseInt(quantityInput.value);

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
            } else {
                itemQtyInputswarning.style.display = 'none';
                itemQtyInputs.forEach(input => input.classList.remove('is-invalid'));
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
            totalPriceEl.classList.add('d-none');
            return;
        }

        const modifierPrice = getSelectedModifierTotal();
        const total = (basePrice + modifierPrice) * quantity;

        basePriceEl.innerHTML = `Rp ${formatRupiah(basePrice)}`;
        totalPriceEl.textContent = `Total Harga: Rp ${formatRupiah(total)}`;
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
});
