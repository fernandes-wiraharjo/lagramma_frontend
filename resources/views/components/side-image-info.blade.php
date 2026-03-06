@props([
    'image',
    'alt' => 'Side image info',
    'title',
    'description',
])

<div class="row mx-0 px-lg-4 lagramma-side-image-info-row">
    <div class="col-6">
        <img class="img-fluid w-100 object-fit-cover lagramma-side-image-info-image" src="{{ URL::asset($image) }}"
            alt="{{ $alt }}">
    </div>
    <div class="col-6 d-flex flex-column justify-content-center lagramma-side-image-info-content">
        <h3 class="lagramma-side-image-info-title">{{ $title }}</h3>
        <p class="lagramma-side-image-info-text">{!! $description !!}</p>
    </div>
</div>
