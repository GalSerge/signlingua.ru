@extends('layouts.profile', ['title' => 'Редактировать профиль'])

@section('errors')
    @if (session('status') === 'profile-updated')
        <div class="complete-msg"><img src="{{ asset('/images/icons/complete-icon.svg')}}" alt="Успешно">
            <span>Данные успешно изменены.</span>
        </div>
    @endif
@endsection

@section('pane')
    <form class="edit-profile" method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="form-group row">
            <div class="col-12 col-sm-9 col-md-9 col-lg-10 ml-auto">
                <h3>Персональные данные</h3>
            </div>
        </div>

        <div class="form-group row">
            <label
                    class="col-12 col-sm-3 col-md-3 col-lg-2 col-form-label">Аватар</label>
            <div class="col-12 col-sm-9 col-md-9 col-lg-7">
                <input class="form-control" type="file" name="img" accept="image/png, image/jpeg">
            </div>
            <div class="error">{{ $errors->first('img') }}</div>
        </div>

        <div class="form-group row">
            <label
                    class="col-12 col-sm-3 col-md-3 col-lg-2 col-form-label">Имя</label>
            <div class="col-12 col-sm-9 col-md-9 col-lg-7">
                <input class="form-control" type="text" name="name"
                       value="{{ $user->name }}">
            </div>
            <div class="error">{{ $errors->first('name') }}</div>
        </div>

        <div class="form-group row">
            <label
                    class="col-12 col-sm-3 col-md-3 col-lg-2 col-form-label">Фамилия</label>
            <div class="col-12 col-sm-9 col-md-9 col-lg-7">
                <input class="form-control" type="text" name="surname"
                       value="{{ $user->surname }}">
            </div>
            <div class="error">{{ $errors->first('surname') }}</div>
        </div>

        <div class="m-form__seperator m-form__seperator--dashed m-form__seperator--space-2x">
        </div>

        <div class="row">
            <div class="col-12 col-sm-3 col-md-3 col-lg-2">
            </div>
            <div class="col-12 col-sm-9 col-md-9 col-lg-7">
                <button type="submit" class="btn">Сохранить</button>
                <button type="reset" class="btn-secondry">Отмена</button>
            </div>
        </div>
    </form>
@endsection