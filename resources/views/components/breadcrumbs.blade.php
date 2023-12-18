<div class="container">
    <ul class="list-inline">
        <li><a href="/">Главная</a></li>
        @if(isset($prev))
            <li><a href="{{ route($prev['route']) }}">{{ $prev['label'] }}</a></li>
        @endif
        <li>{{ $title ?? '' }}</li>
    </ul>
</div>