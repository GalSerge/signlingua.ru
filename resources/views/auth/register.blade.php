@extends('layouts.guest')

@section('section')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="account-form-inner">
                <div class="account-container">
                    <div class="heading-bx left">
                        <h2 class="title-head">Зарегистрируйтесь</h2>
                        <p>Или войдите в свой аккаунт <a href="{{ route('login') }}">здесь</a></p>
                    </div>
                    <form method="POST" action="{{ route('register') }}" class="contact-bx">
                        @csrf
                        <div class="row placeani">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <label>Имя</label>
                                        <input type="text" name="name" required class="form-control">
                                    </div>
                                    <div class="error">{{ $errors->first('name') }}</div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <label>Фамилия</label>
                                        <input type="text" name="surname" required class="form-control">
                                    </div>
                                    <div class="error">{{ $errors->first('surname') }}</div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <label>Почтовый ящик</label>
                                        <input type="email" name="email" required class="form-control"
                                            autocomplete="username">
                                    </div>
                                    <div class="error">{{ $errors->first('email') }}</div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <label>Придумайте пароль</label>
                                        <input type="password" name="password" class="form-control" required=""
                                            autocomplete="new-password">
                                    </div>
                                    <div class="error">{{ $errors->first('password') }}</div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <label>Повторите пароль</label>
                                        <input type="password" name="password_confirmation" class="form-control"
                                            autocomplete="new-password" required="">
                                    </div>
                                    <div class="error">{{ $errors->first('password_confirmation') }}</div>
                                </div>
                            </div>
                            <div class="col-lg-12 m-b30">
                                <button name="submit" type="submit" value="Submit"
                                    class="btn button-md">Зарегистрироваться
                                </button>
                            </div>
                            <div class="col-lg-12">
                                <h6>Регистрация с помощью</h6>
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
            <img src="images/reg-img.png" alt="Вход в аккаунт">
        </div>
    </div>
</div>
@endsection