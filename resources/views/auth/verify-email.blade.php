@extends('layouts.guest')

@section('section')
    <div class="container">
        <div class="account-form-inner">
            <div class="account-container">
                <div class="heading-bx left">
                    <h1>Спасибо за регистрацию!</h1>
                    <p> Прежде чем начать, не могли бы вы подтвердить свой адрес электронной
                        почты, нажав на ссылку, которую мы только что отправили вам по электронной почте? Если вы не
                        получили письмо, мы с радостью отправим вам другое.</p>
                    @if (session('status') == 'verification-link-sent')
                        <p>
                            Новая ссылка для подтверждения была отправлена на адрес электронной почты, который вы указали при регистрации.
                        </p>
                    @endif
                </div>
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf

                    <div class="col-lg-12 m-b30">
                        <button name="submit" type="submit" value="Submit"
                                class="btn button-md">Выслать письмо повторно
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
