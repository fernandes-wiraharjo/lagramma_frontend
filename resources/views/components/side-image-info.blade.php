@props([
    'image',
    'alt' => 'Side image info',
    'title',
    'description',
    'maxHeight' => '882px',
    'paddingLeft' => '100px',
])

<div class="row mx-0 px-lg-4" style="margin-bottom: 64px;">
    <div class="col-6">
        <img class="img-fluid w-100 object-fit-cover" src="{{ URL::asset($image) }}" alt="{{ $alt }}"
            style="max-height: {{ $maxHeight }};">
    </div>
    <div class="col-6 d-flex flex-column justify-content-center" style="padding-left: {{ $paddingLeft }};">
        <h3 style="font-size: 2rem; font-weight: 400; margin-bottom: 32px;">{{ $title }}</h3>
        <p style="font-size: 1.25rem; font-weight: 300; color: #909090; line-height: 1.4;">{!! $description !!}</p>
    </div>
</div>
