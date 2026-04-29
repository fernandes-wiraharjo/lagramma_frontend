@props(['items' => []])

<nav aria-label="breadcrumb">
    <ol class="lg-breadcrumb">
        @foreach ($items as $item)
            @if ($loop->last)
                <li class="active" aria-current="page">{{ $item['label'] }}</li>
            @else
                <li>
                    <a href="{{ $item['url'] ?? '#' }}">{{ $item['label'] }}</a>
                </li>
            @endif
        @endforeach
    </ol>
</nav>
