@extends('emails.main')

@section('title')
    {{ $title }}
@endsection

@section('content')
    {{ $user->name }}, действие вашей подписки скоро закончится. Стоимость продления <b>{{ $subscription->amount }} руб.</b>, <a href="{{ route('profile.subscription') }}">подробнее</a>.
    <br><br>Вы можете отменить автопродление в разделе <a href="{{ route('payments.index') }}">Финансы</a>.


@endsection
