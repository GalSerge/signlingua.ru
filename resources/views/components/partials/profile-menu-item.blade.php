@if($item['route'] != 'password.edit' || Auth::user()->auth_provider == null)
    <li class="nav-item">
        <a class="{{ Request::routeIs($item['route']) ? 'nav-link active show' : 'nav-link' }}"
           href="{{ $item['route'] == '' ? '#' : route($item['route']) }}">
            <i class="{{ $item['class'] }}"></i>
            {{ $item['label'] }}
        </a>
    </li>
@endif
