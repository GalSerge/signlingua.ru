@extends('layouts.profile', ['title' => 'Мои курсы'])

@section('pane')
        @if(count($courses) == 0)

            <div class="container p-4">
                <div class="row">
                    <div class="col-md-6 col-lg-6">
                        <p>У вас нет доступных курсов.</p>
                        <a class="btn m-2" href="{{ route('subscriptions') }}">Выбрать план</a>
                        <a class="btn m-2" href="{{ route('profile.courses.study') }}">Пробный курс</a>
                    </div>
                </div>
            </div>
        @else
            <div class="container p-4">
                <div class="row">
                    <div class="col-md-6 col-lg-6">
                        <a class="btn" href="{{ route('profile.courses.study') }}">Продолжить обучение</a>
                    </div>
                </div>
            </div>
            <div class="courses-filter">
                <div class="clearfix">
                    <ul class="ttr-gallery-listing row">
                        @foreach($courses as $course)
                            <li
                                    class="action-card col-xl-4 col-lg-6 col-md-12 col-sm-6 publish">
                                <div class="cours-bx">
                                    <div class="action-box">
                                        <img src="{{ asset('storage/images/courses/' . $course['img']) }}" alt="">
                                        <a href="{{ route('course', $course['id']) }}" class="btn">Узнать больше</a>
                                    </div>
                                    <div class="info-bx text-center">
                                        <h5>{{ $course['name'] }}</h5>
                                    </div>
                                    <div class="cours-more-info">

                                        <div class="price text-center">
                                            <p>Выполнено: {{ $course['progress'] ?? ''}} %</p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

@endsection