<div class="breadcrumbs">
    <a class="breadcrumbs__link" href="{{ route('web.pages.index') }}">Главная</a>
    @foreach($breadcrumbs as $breadcrumb)
        @if($loop->last)
            <span class="breadcrumbs__item">{{ $breadcrumb['title'] }}</span>
        @else
            <a class="breadcrumbs__link"
               href="{{ route('web.pages.show', $breadcrumb['path']) }}">{{ $breadcrumb['title'] }}</a>
        @endif
    @endforeach
</div>
