@extends('layouts.guest')

@section('section')

<div class="container mt-4">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="account-form-inner">
                <div class="account-container">
                    <div class="heading-bx left">
                        <h2 class="title-head">Войдите с помощью своего аккаунта</h2>
                        <p>У вас нет аккаунта? <a href="{{ route('register') }}">Пройдите регистрацию</a></p>
                    </div>
                    <form method="POST" action="{{ route('login') }}" class="contact-bx">
                        <div class="row placeani">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <label>Почта</label>
                                        <input type="email" name="email" required="" class="form-control">
                                    </div>
                                    <div class="error">{{ $errors->first('email') }}</div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <label>Пароль</label>
                                        <input type="password" name="password" class="form-control" required="">
                                    </div>
                                    <div class="error">{{ $errors->first('password') }}</div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group form-forget">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customControlAutosizing"
                                            name="remember">
                                        <label class="custom-control-label" for="customControlAutosizing">Запомнить
                                            меня</label>
                                    </div>
                                    <a href="{{ route('password.request') }}" class="ml-auto">Не помню пароль</a>
                                </div>
                            </div>
                            <div class="col-lg-12 m-b30">
                                <button name="submit" type="submit" value="Submit" class="btn button-md">Войти</button>
                            </div>
                            <div class="col-lg-12">
                                <h6>Войти с помощью</h6>
                                <div class="d-flex">
                                    <a class="btn flex-fill m-l5 yandex" href="{{ route('login.social', 'yandex') }}"><i
                                            class="fa fa-yandex"></i>Яндекс</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6 hidden-md-down">
            <img src="images/login-img.png" alt="Вход в аккаунт">
        </div>
    </div>
</div>
@endsection