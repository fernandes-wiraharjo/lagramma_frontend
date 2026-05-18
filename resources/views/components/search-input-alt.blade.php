@props([
    'placeholder' => 'Search Our Product',
    'ariaLabel' => 'Search Our Product',
    'maxWidth' => '300px',
    'id' => 'general-search-input',
])

<div {{ $attributes->merge(['class' => 'input-group flex-nowrap lg-search-input-alt']) }} style="max-width: {{ $maxWidth }};">
    <span class="input-group-text border-0 ps-3 pe-2">
        <i class="bi bi-search" aria-hidden="true"></i>
    </span>
    <input type="text" id="{{ $id }}" class="form-control border-0 shadow-none ps-0 pe-3" placeholder="{{ $placeholder }}"
        aria-label="{{ $ariaLabel }}">
</div>

@push('extra_scripts')
<script>
    document.querySelectorAll('.lg-search-input-alt input').forEach(function(input) {
        input.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && input.value.trim()) {
                e.preventDefault();
                window.location.href = '/catalogue?search=' + encodeURIComponent(input.value.trim());
            }
        });
    });
</script>
@endpush