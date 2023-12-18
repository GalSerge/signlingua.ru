@extends('emails.main')

@section('title')
    {{ $title }}
@endsection

@section('content')
    {{ $user->name }},
    @if($success)
        ваша подписка активирована, <a href="{{ route('profile.subscription') }}">подробнее</a>.
    @else
        не удалось активировать вашу подписку. <a href="{{ route('subscriptions') }}">Продолжить обучение?</a>
    @endif

@endsection
