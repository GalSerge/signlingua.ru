@extends('layouts.guest')

@section('section')
    <div class="container">
        <div class="account-form-inner">
            <div class="account-container">
                <div class="heading-bx left">
                    <p>Пожалуйста, подтвердите свой пароль, прежде чем продолжить.</p>
                </div>
                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf
                    <div class="row placeani">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <label>Пароль</label>
                                    <input type="password" name="password"
                                           autocomplete="current-password" class="form-control"
                                           required="">
                                </div>
                                <div class="error">{{ $errors->first('password') }}</div>
                            </div>
                        </div>
                        <div class="col-lg-12 m-b30">
                            <button name="submit" type="submit" value="Submit"
                                    class="btn button-md">Подтвердить
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
