@extends('layouts.profile', ['title' => 'Звонки'])

@php
    $statuses = [
        'REQUESTED' => 'Ожидает',
        'SATISFIED' => 'Завершен'
    ];
@endphp

@section('pane')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-6">
                <ul class="course-features">
                    <li><i class="ti-headphone-alt"></i> <span class="label">Звонков
																совершено</span> <span
                                class="value">{{ $committed }}</span></li>
                    <li><i class="ti-arrow-circle-right"></i> <span class="label">Звонков доступно</span> <span
                                class="value">{{ $available }}</span></li>

                </ul>

            </div>

            <div class="col-md-12 col-lg-12 mb-3">
                @if($available > 0)
                    <button type="button" class="btn" data-toggle="modal" data-target="#requestCall">Воспользоваться
                        звонком
                    </button>
                @endif
                <button type="button" class="btn" data-toggle="modal" data-target="#buyCalls">Приобрести
                    звонок
                </button>
            </div>
        </div>
    </div>

    @if(count($calls) != 0)
        <div class="profile-head mt-4">
            <h3>История звонков</h3>
        </div>

        <div class="container">
            <div class="row">
                @foreach($calls as $call)
                    <div class="col-md-12 col-lg-12">
                        <ul class="course-features">
                            <li><i class="ti-calendar"></i> <span class="label">Дата звонка</span> <span
                                        class="value">{{ date('d.m.Y h:i', strtotime($call['updated_at'])) }}</span>
                            </li>
                            <li><i class="ti-check-box"></i> <span class="label">Статус</span> <span
                                        class="value">{{ $statuses[$call['status']] }}</span></li>
                            <li><i class="ti-user"></i> <span class="label">Тьютор</span> <span
                                        class="value">{{ $call['tutor'] != null ? $call['tutor']['name'] . ' ' . $call['tutor']['surname'] : ''}}</span>
                            </li>
                        </ul>

                    </div>
                @endforeach

            </div>
        </div>
    @endif

    <div id="buyCalls" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Звонки</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Стоимость одного звонка {{ $amount_one_call }} руб. Вы можете приобрести до 5 звонков.</p>
                    <form method="POST" action="{{ route('pay.calls') }}" class="edit-profile p-0">
                        @csrf
                        <div class="form-group row">
                            <label
                                    class="col-3 col-form-label">Количество</label>
                            <div class="col-2">
                                <input class="form-control" type="number" max="5" min="1" name="calls"
                                       value="1" required>
                            </div>
                        </div>
                        <button type="submit" class="btn">Купить</button>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <div id="requestCall" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Задайте вопрос тьютору</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('profile.call.request') }}" class="edit-profile p-0">
                        @csrf
                        <div class="form-group row">
                            <label
                                    class="col-12 col-form-label">Сообщение</label>
                            <div class="col-12">
                                <textarea name="msg" class="form-control" required></textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn">Отправить</button>
                    </form>
                </div>
            </div>

        </div>
    </div>

@endsection

