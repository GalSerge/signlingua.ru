@extends('layouts.profile', ['title' => 'Смена пароля'])

@section('errors')
    @if (session('status') === 'password-updated')
        <div class="complete-msg"><img src="{{ asset('/images/icons/complete-icon.svg')}}" alt="Успешно">
            <span>Данные успешно изменены.</span>
        </div>
    @endif
@endsection

@section('pane')
    @if(Auth::user()->auth_provider == null)
    <form class="edit-profile" action="{{ route('password.update') }}" method="POST">
        @csrf
        @method('put')
        <div class="">
            <div class="form-group row">
                <label
                        class="col-12 col-sm-4 col-md-4 col-lg-3 col-form-label">Старый
                    пароль</label>
                <div class="col-12 col-sm-8 col-md-8 col-lg-7">
                    <input class="form-control" name="current_password" type="password" autocomplete="current-password" value="">
                </div>
                <div class="error col-12">{{ $errors->first('current_password') }}</div>
            </div>
            <div class="form-group row">
                <label
                        class="col-12 col-sm-4 col-md-4 col-lg-3 col-form-label">Новый
                    пароль</label>
                <div class="col-12 col-sm-8 col-md-8 col-lg-7">
                    <input class="form-control" name="password" type="password" autocomplete="new-password" value="">
                </div>
                <div class="error col-12">{{ $errors->first('password') }}</div>
            </div>
            <div class="form-group row">
                <label class="col-12 col-sm-4 col-md-4 col-lg-3 col-form-label">Еще
                    раз новый пароль</label>
                <div class="col-12 col-sm-8 col-md-8 col-lg-7">
                    <input class="form-control" name="password_confirmation" type="password" autocomplete="new-password" value="">
                </div>
                <div class="error col-12">{{ $errors->first('password_confirmation') }}</div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-4 col-md-4 col-lg-3">
            </div>
            <div class="col-12 col-sm-8 col-md-8 col-lg-7">
                <button type="submit" class="btn">Сохранить</button>
                <button type="reset" class="btn-secondry">Отмена</button>
            </div>
        </div>

    </form>
    @else
{{--        <div class="heading-bx left">--}}
{{--            <p>Для входа вы использовали электронную почту, мы вышлем вам--}}
{{--                ссылку для сброса временного пароля, она позволит вам выбрать новый.--}}
{{--            </p>--}}
{{--        </div>--}}
{{--        <form method="POST" action="{{ route('password.email') }}">--}}
{{--            @csrf--}}
{{--            <input type="hidden" value="{{ Auth::user()->email }}"/>--}}
{{--            <div class="col-lg-12 m-b30">--}}
{{--                <button name="submit" type="submit" value="Submit"--}}
{{--                        class="btn button-md">Отправить ссылку--}}
{{--                </button>--}}
{{--            </div>--}}
{{--        </form>--}}
    @endif
@endsection


