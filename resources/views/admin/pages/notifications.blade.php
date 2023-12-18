@extends('admin.main', ['title' => 'Создать новое уведомление'])

@section('content')
    <div class="section-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 m-b30">
                    <h3>Создать новое уведомление</h3>
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
                    <form method="POST" action="{{ route('admin.notifications') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">Курсы</label>
                            <input type="text" name="course_msg" value="Есть обновления на курсе &laquo;:name&raquo;."
                                   required class="form-control"/>
                            <select style="height: auto" class="form-control" multiple="multiple" name="courses[]">
                                @foreach($courses as $course)
                                    <option value="{{ $course['id'] }}">{{ $course['name'] }}</option>
                                @endforeach
                            </select>
                            <div class="error">{{ $errors->first('courses') }}</div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Подписки</label>
                            <input type="text" name="subscription_msg"
                                   value="Есть обновления по вашему плану &laquo;:name&raquo;." required
                                   class="form-control"/>
                            <select style="height: auto" class="form-control" multiple="multiple" name="subscriptions[]">
                                @foreach($subscriptions as $subscription)
                                    <option value="{{ $subscription['id'] }}">{{ $subscription['name'] }}</option>
                                @endforeach
                            </select>
                            <div class="error">{{ $errors->first('subscriptions') }}</div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Словари</label>
                            <input type="text" name="topic_msg"
                                   value="В словаре &laquo;:name&raquo; появились новые слова." required
                                   class="form-control"/>
                            <select style="height: auto" class="form-control" multiple="multiple" name="topics[]">
                                @foreach($topics as $topic)
                                    <option value="{{ $topic['id'] }}">{{ $topic['name'] }}</option>
                                @endforeach
                            </select>
                            <div class="error">{{ $errors->first('topics') }}</div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-submit">Отправить</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

