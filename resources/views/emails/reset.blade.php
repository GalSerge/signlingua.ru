@extends('emails.main')

@section('title')
    {{ $title }}
@endsection

@section('content')
    Для сброса пароля перейдите по <a href="{{ $url }}">ссылке</a>
@endsection
