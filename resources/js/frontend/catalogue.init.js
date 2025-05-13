var filteredProductList = productListData;
var prevButton = document.getElementById('page-prev');
var nextButton = document.getElementById('page-next');

// configuration variables
var currentPage = 1;
var currentCategory = "All";
var currentSearchTerm = "";
var currentSortOrder = "asc";
var itemsPerPage

if (document.getElementById("col-3-layout")) {
    itemsPerPage = 12;
} else {
    itemsPerPage = 9;
}

function updateProductCount(totalItems, currentPage, itemsPerPage) {
    const countElement = document.getElementById('product-count');

    const start = (currentPage - 1) * itemsPerPage + 1;
    const end = Math.min(currentPage * itemsPerPage, totalItems);

    countElement.innerText = `Showing ${start}-${end} of ${totalItems} results`;
}

loadProductList(productListData, currentPage);
paginationEvents();

function applyFilters() {
    let result = productListData;

    // filter by category
    if (currentCategory !== "All") {
        result = result.filter(item => item.category === currentCategory);
    }

    // filter by search term
    if (currentSearchTerm.trim() !== "") {
        result = result.filter(item => item.productTitle.toLowerCase().includes(currentSearchTerm.toLowerCase()));
    }

    // sort after filtering
    if (currentSortOrder === "asc") {
        result.sort((a, b) => a.productTitle.localeCompare(b.productTitle));
    } else if (currentSortOrder === "desc") {
        result.sort((a, b) => b.productTitle.localeCompare(a.productTitle));
    }

    filteredProductList = result;
    currentPage = 1; // reset to first page
    searchResult(filteredProductList);
    loadProductList(filteredProductList, currentPage);
}

function loadProductList(datas, page) {
    var pages = Math.ceil(datas.length / itemsPerPage)
    if (page < 1) page = 1;
    if (page > pages) page = pages;

    if (document.getElementById("product-grid")) {
        document.getElementById("product-grid").innerHTML = "";
        for (var i = (page - 1) * itemsPerPage; i < (page * itemsPerPage) && i < datas.length; i++) {
            // Array.from(datas).forEach(function (listdata) {
            if (datas[i]) {
                var checkinput = datas[i].wishList ? "active" : "";
                var num = 1;
                if (datas[i].color) {
                    var colorElem = '<ul class="clothe-colors list-unstyled hstack gap-1 mb-3 flex-wrap">';
                    Array.from(datas[i].color).forEach(function (elem) {
                        num++;
                        colorElem += '<li>\
                                    <input type="radio" name="sizes'+ datas[i].id + '" id="product-color-' + datas[i].id + num + '">\
                                    <label class="avatar-xxs btn btn-'+ elem + ' p-0 d-flex align-items-center justify-content-center rounded-circle" for="product-color-' + datas[i].id + num + '"></label>\
                                </li>';
                    })
                    colorElem += '</ul>';
                } else if (datas[i].size) {
                    var colorElem = '<ul class="clothe-size list-unstyled hstack gap-2 mb-3 flex-wrap">';
                    Array.from(datas[i].size).forEach(function (elem) {
                        num++;
                        colorElem += '<li>\
                                    <input type="radio" name="sizes'+ datas[i].id + '" id="product-color-' + datas[i].id + num + '">\
                                    <label class="avatar-xxs btn btn-soft-primary text-uppercase p-0 fs-12 d-flex align-items-center justify-content-center rounded-circle" for="product-color-'+ datas[i].id + num + '">' + elem + '</label>\
                                </li>';
                    })
                    colorElem += '</ul>';
                } else {
                    // var colorElem = '<div class="avatar-xxs mb-3">\
                    //                 <div class="avatar-title bg-light text-muted rounded cursor-pointer">\
                    //                     <i class="ri-error-warning-line"></i>\
                    //                 </div>\
                    //             </div>'
                    var colorElem = ''
                }

                var text = datas[i].discount;
                var myArray = text.split("%");
                var discount = myArray[0];
                var afterDiscount = datas[i].price - (datas[i].price * discount / 100);
                if (discount > 0) {
                    var discountElem = '<div class="avatar-xs label">\
                                    <div class="avatar-title bg-danger rounded-circle fs-11">'+ datas[i].discount + '</div>\
                                </div>';
                    var afterDiscountElem = '<h5 class="text-secondary mb-0">$' + afterDiscount.toFixed(2) + ' <span class="text-muted fs-12"><del>$' + datas[i].price + '</del></span></h5>'
                } else {
                    var discountElem = "";
                    var afterDiscountElem = '<h5 class="text-secondary mb-0">IDR' + datas[i].price + '</h5>'
                }

                if (document.getElementById("col-3-layout")) {
                    var layout = '<div class="col-xxl-3 col-lg-4 col-md-6">'
                } else {
                    var layout = '<div class="col-xxl-4 col-lg-4 col-md-6">'
                }

                document.getElementById("product-grid").innerHTML += layout + '\
                        <div class="card ecommerce-product-widgets border-0 rounded-0 shadow-none overflow-hidden">\
                            <div class="bg-light bg-opacity-50 rounded py-4 position-relative">\
                                <img src="'+ datas[i].productImg + '" alt="" style="max-height: 200px;max-width: 100%;" class="mx-auto d-block rounded-2">\
                                <div class="action vstack gap-2">\
                                </div>\
                                '+ discountElem + '\
                            </div>\
                            <div class="pt-4">\
                                <div>\
                                    '+ colorElem + '\
                                    <a href="/product-detail/' + datas[i].id + '">\
                                        <h6 class="text-capitalize fs-15 lh-base text-truncate mb-0">'+ datas[i].productTitle + '</h6>\
                                    </a>\
                                    <div class="tn mt-3">\
                                        <a href="/product-detail/' + datas[i].id + '" class="btn btn-primary btn-hover w-100 add-btn">View Product</a>\
                                    </div>\
                                </div>\
                            </div>\
                        </div>\
                    </div>'
                // });
            };
        }
    }

    if(document.getElementById("product-grid-right")){
        document.getElementById("product-grid-right").innerHTML = "";
        for (var i = (page - 1) * itemsPerPage; i < (page * itemsPerPage) && i < datas.length; i++) {
            if (datas[i]) {
                var checkinput = datas[i].wishList ? "active" : "";

                var productLabel = datas[i].arrival ? '<p class="fs-11 fw-medium badge bg-primary py-2 px-3 product-lable mb-0">Best Arrival</p>' : "";

                var num = 1;
                if (datas[i].color) {
                    var colorElem = '<ul class="clothe-colors list-unstyled hstack gap-1 mb-3 flex-wrap d-none">';
                    Array.from(datas[i].color).forEach(function (elem) {
                        num++;
                        colorElem += '<li>\
                                    <input type="radio" name="sizes'+ datas[i].id + '" id="product-color-' + datas[i].id + num + '">\
                                    <label class="avatar-xxs btn btn-'+ elem + ' p-0 d-flex align-items-center justify-content-center rounded-circle" for="product-color-' + datas[i].id + num + '"></label>\
                                </li>';
                    })
                    colorElem += '</ul>';
                } else if (datas[i].size) {
                    var colorElem = '<ul class="clothe-size list-unstyled hstack gap-2 mb-3 flex-wrap d-none">';
                    Array.from(datas[i].size).forEach(function (elem) {
                        num++;
                        colorElem += '<li>\
                                    <input type="radio" name="sizes'+ datas[i].id + '" id="product-color-' + datas[i].id + num + '">\
                                    <label class="avatar-xxs btn btn-soft-primary text-uppercase p-0 fs-12 d-flex align-items-center justify-content-center rounded-circle" for="product-color-'+ datas[i].id + num + '">' + elem + '</label>\
                                </li>';
                    })
                    colorElem += '</ul>';
                } else {
                    var colorElem = '<div class="avatar-xxs mb-3 d-none">\
                                    <div class="avatar-title bg-light text-muted rounded cursor-pointer">\
                                        <i class="ri-error-warning-line"></i>\
                                    </div>\
                                </div>'
                }

                var text = datas[i].discount;
                var myArray = text.split("%");
                var discount = myArray[0];
                var afterDiscount = datas[i].price - (datas[i].price * discount / 100);
                if (discount > 0) {
                    var afterDiscountElem = '<h5 class="mb-0">$' + afterDiscount.toFixed(2) + ' <span class="text-muted fs-12"><del>$' + datas[i].price + '</del></span></h5>'
                } else {
                    var afterDiscountElem = '<h5 class="mb-0">$' + datas[i].price + '</h5>'
                }

                if (document.getElementById("col-3-layout")) {
                    var layout = '<div class="col-xxl-3 col-lg-4 col-md-6">'
                } else {
                    var layout = '<div class="col-lg-4 col-md-6">'
                }

                document.getElementById("product-grid-right").innerHTML += layout + '\
                    <div class="card overflow-hidden element-item">\
                        <div class="bg-light py-4">\
                            <div class="gallery-product">\
                                <img src="'+ datas[i].productImg + '" alt="" style="max-height: 215px;max-width: 100%;" class="mx-auto d-block">\
                            </div>\
                            '+productLabel+'\
                            <div class="gallery-product-actions">\
                                <div class="mb-2">\
                                    <button type="button" class="btn btn-danger btn-sm custom-toggle '+ checkinput + '" data-bs-toggle="button">\
                                        <span class="icon-on"><i class="mdi mdi-heart-outline align-bottom fs-15"></i></span>\
                                        <span class="icon-off"><i class="mdi mdi-heart align-bottom fs-15"></i></span>\
                                    </button>\
                                </div>\
                                <div>\
                                    <button type="button" class="btn btn-success btn-sm custom-toggle" data-bs-toggle="button">\
                                        <span class="icon-on"><i class="mdi mdi-eye-outline align-bottom fs-15"></i></span>\
                                        <span class="icon-off"><i class="mdi mdi-eye align-bottom fs-15"></i></span>\
                                    </button>\
                                </div>\
                            </div>\
                            <div class="product-btn px-3">\
                                <a href="#!" class="btn btn-primary btn-sm w-75 add-btn"><i class="mdi mdi-cart me-1"></i> Add to Cart</a>\
                            </div>\
                        </div>\
                        <div class="card-body">\
                            <div>\
                                '+ colorElem + '\
                                <a href="#!">\
                                    <h6 class="fs-16 lh-base text-truncate mb-0">'+ datas[i].productTitle + '</h6>\
                                </a>\
                                <div class="mt-3">\
                                    <span class="float-end">'+ datas[i].rating + ' <i class="ri-star-half-fill text-warning align-bottom"></i></span>\
                                    '+ afterDiscountElem + '\
                                </div>\
                            </div>\
                        </div>\
                    </div>\
                </div>'
            }
        }
    }
    updateProductCount(datas.length, page, itemsPerPage);
    selectedPage();
    currentPage == 1 ? prevButton.parentNode.classList.add('disabled') : prevButton.parentNode.classList.remove('disabled');
    currentPage == pages ? nextButton.parentNode.classList.add('disabled') : nextButton.parentNode.classList.remove('disabled');
}

function selectedPage() {
    var pagenumLink = document.getElementById('page-num').getElementsByClassName('clickPageNumber');
    for (var i = 0; i < pagenumLink.length; i++) {
        if (i == currentPage - 1) {
            pagenumLink[i].parentNode.classList.add("active");
        } else {
            pagenumLink[i].parentNode.classList.remove("active");
        }
    }
};

// paginationEvents
function paginationEvents() {
    var numPages = function numPages() {
        return Math.ceil(filteredProductList.length / itemsPerPage);
    };

    function clickPage() {
        document.addEventListener('click', function (e) {
            if (e.target.nodeName == "A" && e.target.classList.contains("clickPageNumber")) {
                currentPage = e.target.textContent;
                loadProductList(filteredProductList, currentPage);
            }
        });
    };

    function pageNumbers() {
        var pageNumber = document.getElementById('page-num');
        pageNumber.innerHTML = "";
        // for each page
        for (var i = 1; i < numPages() + 1; i++) {
            pageNumber.innerHTML += "<div class='page-item'><a class='page-link clickPageNumber' href='javascript:void(0);'>" + i + "</a></div>";
        }
    }

    prevButton.addEventListener('click', function () {
        if (currentPage > 1) {
            currentPage--;
            loadProductList(filteredProductList, currentPage);
        }
    });

    nextButton.addEventListener('click', function () {
        if (currentPage < numPages()) {
            currentPage++;
            loadProductList(filteredProductList, currentPage);
        }
    });

    pageNumbers();
    clickPage();
    selectedPage();
}

function searchResult(data) {
    if (data.length == 0) {
        document.getElementById("pagination-element").style.display = "none";
        document.getElementById("search-result-elem").classList.remove("d-none");
    } else {
        document.getElementById("pagination-element").style.display = "flex";
        document.getElementById("search-result-elem").classList.add("d-none");
    }

    var pageNumber = document.getElementById('page-num');
    pageNumber.innerHTML = "";
    var dataPageNum = Math.ceil(data.length / itemsPerPage)
    // for each page
    for (var i = 1; i < dataPageNum + 1; i++) {
        pageNumber.innerHTML += "<div class='page-item'><a class='page-link clickPageNumber' href='javascript:void(0);'>" + i + "</a></div>";
    }
}

//  category list filter
Array.from(document.querySelectorAll('.filter-list a')).forEach(function (filteritem) {
    filteritem.addEventListener("click", function () {
        var filterListItem = document.querySelector(".filter-list a.active");
        if (filterListItem) filterListItem.classList.remove("active");
        filteritem.classList.add('active');

        // var filterItemValue = filteritem.querySelector(".listname").innerHTML
        // var filterData = productListData.filter(filterlist => filterlist.category === filterItemValue);

        // searchResult(filterData);
        // loadProductList(filterData, currentPage);
        currentCategory = filteritem.querySelector(".listname").innerHTML;
        applyFilters();
    });
})

// Search product list
var searchProductList = document.getElementById("searchProductList");
searchProductList.addEventListener("keyup", function () {
    // var inputVal = searchProductList.value.toLowerCase();
    // function filterItems(arr, query) {
    //     return arr.filter(function (el) {
    //         return el.productTitle.toLowerCase().indexOf(query.toLowerCase()) !== -1
    //     })
    // }
    // filteredProductList = filterItems(productListData, inputVal);
    // searchResult(filteredProductList);
    // currentPage = 1;
    // loadProductList(filteredProductList, currentPage);
    currentSearchTerm = searchProductList.value;
    applyFilters();
});

document.getElementById("sort-elem").addEventListener("change", function (e) {
    var inputVal = e.target.value
    if (inputVal == "a_to_z") {
        sortElementsByAsc();
    } else if (inputVal == "z_to_a") {
        sortElementsByDesc();
    } else if (inputVal == "") {
        sortElementsById()
    }
});

// sort element ascending
function sortElementsByAsc() {
    currentSortOrder = "asc";
    applyFilters();
}

// sort element descending
function sortElementsByDesc() {
    currentSortOrder = "desc";
    applyFilters();
}

// sort element id
function sortElementsById() {
    var list = productListData.sort(function (a, b) {
        var x = parseInt(a.id);
        var y = parseInt(b.id);

        if (x < y) {
            return -1;
        }
        if (x > y) {
            return 1;
        }
        return 0;
    })
    loadProductList(list, currentPage);
}
