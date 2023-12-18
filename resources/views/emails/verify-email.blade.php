@extends('emails.main')

@section('title')
    {{ $title }}
@endsection

@section('content')
    Для подтверждения адреса электронной почты перейдите по <a href="{{ $url }}">ссылке</a>
@endsection
