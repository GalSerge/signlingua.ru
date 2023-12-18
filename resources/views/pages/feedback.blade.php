@extends('layouts.page', ['title' => 'Задать вопрос'])

@section('section')
    <div class="container">
        <h2>Задать вопрос</h2>
        <div class="row d-flex flex-row">
            <div class="col-lg-6 col-md-8 col-sm-12 m-b30">
                <form method="POST" action="{{ route('feedback.callback') }}" enctype="multipart/form-data">
                    @csrf
                    @guest
                        <div class="form-group">
                            <label class="form-label">Имя</label>
                            <input type="text" name="name" value="" required class="form-control"/>
                            <div class="error">{{ $errors->first('name') }}</div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">E-mail</label>
                            <input type="email" name="email" value="{{ $email ?? '' }}" required class="form-control"/>
                            <div class="error">{{ $errors->first('email') }}</div>
                        </div>
                    @endguest
                    <div class="form-group">
                        <label class="form-label">Сообщение</label>
                        <textarea name="msg" value="" required class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <input type="file" name="img" accept="image/*" class="form-control"/>
                        <div class="error">{{ $errors->first('img') }}</div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-submit">Отправить</button>
                    </div>
                </form>
            </div>
        </div>
@endsection
