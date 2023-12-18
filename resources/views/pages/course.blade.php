@extends('layouts.page', ['title' => $course['name'], 'prev' => ['route' => 'courses', 'label' => 'Курсы']])

@section('section')
<div class="container">
    <div class="row d-flex flex-row-reverse">
        <div class="col-lg-3 col-md-4 col-sm-12 m-b30">
            <h5>Этот курс входит в следующие планы</h5>
            <div class="course-detail-bx">
                @foreach($course['subscriptions'] as $sub)
                <div class="course-detail-bx-item">
                    <div class="course-price">
                        <h4 class="price"><a href="{{ route('subscription', $sub['id']) }}">{{ $sub['name'] }}</a></h4>
                        <h3 class="price">{{ $sub['amount'] }} руб.</h3>
                    </div>
                    <div class="course-buy-now text-center">
                        @if(isset(Auth::user()->subscription_id) && Auth::user()->subscription_id == $sub['id'])
                        Текущий план
                        @else
                        <form method="POST" action="{{ route('pay.subscribe') }}">
                            @csrf
                            <input type="hidden" name="sub_id" value="{{ $sub['id'] }}">
                            <button type="submit" class="btn">Приобрести подписку</button>
                        </form>
                        @endif
                    </div>
                </div>

                @endforeach
            </div>
        </div>

        <div class="col-lg-9 col-md-8 col-sm-12">
            <div class="courses-post">
                <div class="ttr-post-media media-effect">
                    <a href="#"><img src="{{ asset('storage/images/courses/' . $course['img']) }}" alt=""></a>
                </div>
                <div class="ttr-post-info">
                    <div class="ttr-post-title ">
                        <h2 class="post-title">{{ $course['name'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="courese-overview" id="overview">
                {!! $course['description'] !!}
            </div>
        </div>
    </div>
</div>
@endsection