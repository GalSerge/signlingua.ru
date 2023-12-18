@extends('admin.main', ['title' => 'Редактировать запись'])

@section('content')
    <div class="section-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 m-b30">
                    <h3>Редактировать запись</h3>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 m-b30">
                    @if (\Session::has('status'))
                        <div class="complete-msg"><img src="{{ asset('/images/icons/complete-icon.svg')}}" alt="Успешно">
                            <span>{{ \Session::get('status') }}</span>
                        </div>
                    @endif

                    @if (\Session::has('error'))
                        <div class="danger-msg"><img src="{{ asset('/images/icons/danger-icon.svg') }}" alt="Ошибка">
                            <span>{{ \Session::get('error') }}</span>
                        </div>
                    @endif
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 m-b30">
                    <form action="{{ route('calls.update', $call['id']) }}" method="post" enctype="multipart/form-data">
                        @method('put')
                        <div class="form-group">
                            <label class="form-label">Пользователь</label>
                            <input type="text" class="form-control" readonly value="{{ $call['user']['name'] . ' ' . $call['user']['surname'] }}"/>
                        </div>
                        @if($call['tutor'] != null)
                            <div class="form-group">
                                <label class="form-label">Тьютор</label>
                                <input type="text" class="form-control" readonly value="{{ $call['tutor']['name'] . ' ' . $call['tutor']['surname'] }}"/>
                            </div>
                        @endif
                        <div class="form-group">
                            <label class="form-label">Дата изменения</label>
                            <input type="text" class="form-control" readonly value="{{ date('d.m.Y h:i', strtotime($call['updated_at'])) }}"/>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Статус</label>
                            <select class="form-control" name="status">
                                <option @selected($call['status'] == 'REQUESTED') value="REQUESTED">Запрошен</option>
                                <option @selected($call['status'] == 'SATISFIED') value="SATISFIED">Удовлетворен</option>
                            </select>
                            @if($errors->has('status'))
                                <div class="error">{{ $errors->first('status') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-submit">Сохранить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

