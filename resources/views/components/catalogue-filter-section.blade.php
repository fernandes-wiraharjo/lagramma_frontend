<div class="lg-catalogue-filter-panel">
    <div class="lg-catalogue-filter-header">
        <a href="#" id="clearall" class="lg-catalogue-filter-clear">Clear All</a>
    </div>

    <div class="lg-catalogue-filter-search-wrap">
        <i class="ri-search-line lg-catalogue-filter-search-icon" aria-hidden="true"></i>
        <input type="text" class="form-control lg-catalogue-filter-search" id="searchProductList" autocomplete="off"
            placeholder="Search Product">
    </div>

    <ul class="list-unstyled mb-0 filter-list lg-catalogue-filter-list">
        <li>
            <a href="#" class="lg-catalogue-filter-item d-flex align-items-center">
                <span class="lg-catalogue-filter-checkbox" aria-hidden="true"></span>
                <span class="listname">All</span>
            </a>
        </li>
        @foreach($categories as $category)
            <li>
                <a href="#" class="lg-catalogue-filter-item d-flex align-items-center" data-category-id="{{ $category->id }}">
                    <span class="lg-catalogue-filter-checkbox" aria-hidden="true"></span>
                    <span class="listname">{{ $category->name }}</span>
                </a>
            </li>
        @endforeach
    </ul>
</div>
