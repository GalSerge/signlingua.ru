@php
    $menu = [
        ['route' => 'courses.index', 'label' => 'Курсы'],
        ['route' => 'subscriptions.index', 'label' => 'Подписки'],
        ['route' => 'topics.index', 'label' => 'Словари'],
        ['route' => 'words.index', 'label' => 'Слова'],
        ['route' => 'regions.index', 'label' => 'Регионы'],
        ['route' => 'admins.index', 'label' => 'Администраторы'],
        ['route' => 'notifications.create', 'label' => 'Уведомления'],
        ['route' => 'calls.index', 'label' => 'Звонки'],
        ['route' => 'constants.edit', 'label' => 'Константы'],
        ['route' => 'profile.courses.study', 'label' => 'В moodle'],
        ['route' => 'profile.courses', 'label' => 'В профиль'],
    ];

@endphp

<ul>
    <li><h4>Меню</h4></li>
    @foreach($menu as $item)
        <li><a href="{{ route($item['route']) }}">{{ $item['label'] }}</a></li>
    @endforeach
    <li><hr></li>
    <li><a href="{{ route('admin.main') }}">Документация</a></li>
</ul>

