@extends('layouts.guest')

@section('section')
    <div class="container">
        <div class="account-form-inner">
            <div class="account-container">
                <div class="heading-bx left">
                    <p>Забыли пароль? Без проблем. Просто сообщите нам свой адрес электронной почты, и мы вышлем вам
                        ссылку для сброса пароля, которая позволит вам выбрать новый.
                    </p>
                    @if (session('status'))
                        <div class="complete-msg"><img src="{{ asset('/images/icons/complete-icon.svg') }}"
                                                       alt="Успешно"><span>Проверьте свой ящик.</span></div>
                    @endif
                </div>
                <form method="POST" class="contact-bx" action="{{ route('password.email') }}">
                    @csrf
                    <div class="row placeani">
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
                        <div class="col-lg-12 m-b30">
                            <button name="submit" type="submit" value="Submit"
                                    class="btn button-md">Отправить ссылку
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

