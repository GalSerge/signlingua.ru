@extends('layouts.page', ['title' => $subscription['name'], 'prev' => ['route' => 'subscriptions', 'label' =>
'Подписки']])

@section('section')
    <div class="container">
        <h1>{{ $subscription['name'] }}</h1>
        @if(isset(Auth::user()->subscription_id) && Auth::user()->subscription_id == $subscription['id'])
            <p class="current-plan m-0">Ваш текущий план</p>
        @else
            <form method="POST" action="{{ route('pay.subscribe') }}">
                @csrf
                <input type="hidden" name="sub_id" value="{{ $subscription['id'] }}">
                <button type="submit" class="btn">Оформить</button>
            </form>

        @endif

        <h5 class="mb-0 mt-4">Описание</h5>
        {!! $subscription['description'] !!}
        @if($subscription['calls'] > 0)
            <div class="row">
                <div class="col-12 col-md-4">
                    <ul class="course-features">
                        <li><i class="ti-calendar"></i> <span class="label">Доступно звонков:</span> <span
                                    class="value">{{
                        $subscription['calls'] }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        @endif
        <h5> Курсы в подписке</h5>
        <div class="row">
            @foreach($subscription['courses'] as $course)
                <div class="col-md-6 col-lg-4 col-sm-6 m-b30">
                    <div class="cours-bx">
                        <div class="action-box">
                            <img src="{{ asset('storage/images/courses/' . $course['img']) }}" alt="">
                            <a href="{{ route('course', $course['id']) }}" class="btn">Узнать больше</a>
                        </div>
                        <div class="info-bx text-center">
                            <h5>
                                <h5>{{ $course['name'] }}</h5>
                            </h5>
                        </div>
                        <div class="cours-more-info">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection