@props([
    'image',
    'alt' => 'Side image info',
    'title',
    'description',
])

<div class="row mx-lg-0 px-lg-4 py-3">
    <div class="col-12 col-lg-6 lagramma-side-image-info-media p-0">
        <img class="img-fluid w-100 d-block object-fit-cover lagramma-side-image-info-image" src="{{ URL::asset($image) }}"
            alt="{{ $alt }}">
    </div>
    <div class="col-12 col-lg-6 d-flex flex-column justify-content-center lagramma-side-image-info-content py-5">
        <h3 class="lagramma-side-image-info-title">{{ $title }}</h3>
        <p class="lagramma-side-image-info-text" style="font-weight: 400;">{!! $description !!}</p>
    </div>
</div>
