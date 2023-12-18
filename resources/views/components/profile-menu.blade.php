@php
$menu = [
    ['route' => 'profile.courses', 'class' => 'ti-book', 'label' => 'Мои курсы'],
    ['route' => 'training.index', 'class' => 'ti-stats-up', 'label' => 'Прогресс'],
    ['route' => 'profile.subscription', 'class' => 'ti-arrow-circle-down', 'label' => 'Подписка'],
    ['route' => 'payments.index', 'class' => 'ti-wallet', 'label' => 'Финансы'],
    ['route' => 'profile.calls', 'class' => 'ti-headphone-alt', 'label' => 'Звонки'],
    ['route' => 'profile.edit', 'class' => 'ti-pencil-alt', 'label' => 'Редактировать профиль'],
    ['route' => 'password.edit', 'class' => 'ti-pencil-alt', 'label' => 'Сменить пароль'],
];
@endphp

<ul class="nav nav-tabs">
    @each('components.partials.profile-menu-item', $menu, 'item')
</ul>