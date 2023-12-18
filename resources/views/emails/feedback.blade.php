@extends('emails.main')

@section('title')
    {{ $title }}
@endsection

@section('content')
    <b>Имя: </b>{{ $name }}<br>
    <b>E-mail: </b>{{ $email }}<br>
    <b>Вопрос: </b><br><br>

        {{ $msg }}



@endsection