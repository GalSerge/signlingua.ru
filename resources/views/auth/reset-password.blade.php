@extends('layouts.guest')

@section('section')
    <div class="container">
        <div class="account-form-inner">
            <div class="account-container">
                <div class="heading-bx left">
                    <h2 class="title-head">Сбросить пароль</h2>
                </div>
                <form method="POST" class="contact-bx" action="{{ route('password.store') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">
                    <div class="row placeani">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <label>Почтовый ящик</label>
                                    <input type="email" name="email" required class="form-control"  autocomplete="username">
                                </div>
                                <div class="error">{{ $errors->first('email') }}</div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <label>Придумайте пароль</label>
                                    <input type="password" name="password" class="form-control" required="" autocomplete="new-password">
                                </div>
                                <div class="error">{{ $errors->first('password') }}</div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <label>Повторите пароль</label>
                                    <input type="password" name="password_confirmation" class="form-control" autocomplete="new-password"
                                           required="">
                                </div>
                                <div class="error">{{ $errors->first('password_confirmation') }}</div>
                            </div>
                        </div>
                        <div class="col-lg-12 m-b30">
                            <button name="submit" type="submit" value="Submit"
                                    class="btn button-md">Сбросить пароль
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

