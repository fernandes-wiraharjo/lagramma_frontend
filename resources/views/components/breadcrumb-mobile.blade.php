@props(['items' => []])

<div class="position-relative pt-4 d-md-none">
    <div class="container container-1440">
        <div class="row breadcrumb-spacing">
            <div class="col-12 col-md-6 fs-14">
                <x-breadcrumb :items="$items" />
            </div>
        </div>
        <div class="row breadcrumb-spacing">
            <div class="col-12 col-md-6">
                <div class="border-bottom border-dark border-2"></div>
            </div>
        </div>
    </div>
</div>
