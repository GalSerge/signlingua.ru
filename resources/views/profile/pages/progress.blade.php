@extends('layouts.profile', ['title' => 'Прогресс'])

@section('pane')
    <div class="container p-4">
        <div class="row">
            @foreach($topics as $topic)
                <div class="col-md-6 col-lg-4 col-sm-6 m-b30">
                    <div class="cours-bx">
                        <div class="action-box">
                            <img src="{{ asset('storage/images/topics/' . $topic['img']) }}" alt="">
                            @if($topic['progress'] != 0)
                                <div class="progress" style="border-radius: 0;">
                                    <div class="progress-bar progress-bar-striped bg-warning" role="progressbar"
                                         style="width: {{$topic['progress']}}%" aria-valuemin="0" aria-valuemax="100">
                                        @if($topic['progress'] == 100)
                                            Обучение завершено
                                        @else
                                            {{ (int)$topic['progress'] }}%
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="info-bx text-center">
                            <h5><a href="{{ route('topic', $topic['id']) }}">{{ $topic['name'] }}</a></h5>
                        </div>
                        @if($topic['progress'] == 100)
                            <div class="cours-more-info">
                                <div class="price text-center">
                                    <a class="btn" href="{{ route('training.reset', $topic['id']) }}">Начать сначала</a>
                                </div>
                            </div>
                        @else
                            <div class="cours-more-info">
                                <div class="price text-center">
                                    <a class="btn" href="{{ route('training', $topic['id']) }}">Тренировать</a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection