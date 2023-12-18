@extends('emails.main')

@section('title')
    {{ $title }}
@endsection

@section('content')
    {{ $user->name }}, вы отменили автопродление подписки.
    <br><br>
    <a href="{{ route('subscriptions') }}">Посмотреть доступные планы?</a>


@endsection