@extends('layouts.page', ['title' => 'Подписки'])

@section('section')
    <div class="container">
        <h2>Подписки</h2>
        <div class="container">
            <div class="row">
                @foreach($subscriptions as $subscription)
                    <div class="col-md-6 col-lg-4 col-sm-6 m-b30">
                        <div class="cours-bx">

                            <div class="info-sub text-center">
                                <h5>
                                    <a href="{{ route('subscription', $subscription['id']) }}">{{ $subscription['name'] }}</a>
                                </h5>
                            </div>
                            <div class="cours-more-info">
                                <div class="price text-center">
                                    <p>Стоимость подписки</p>
                                    <h5>{{ $subscription['amount'] }} руб.</h5>
                                </div>
                            </div>
                            <div class="cours-more-info">

                                <div class="price text-center">
                                    <p>Период</p>
                                    <h5>{{ $subscription['period_in_months'] }} мес.</h5>
                                </div>
                            </div>
                            <div class="cours-more-info">

                                <div class="price text-center">
                                    @if(isset(Auth::user()->subscription_id) && Auth::user()->subscription_id == $subscription['id'])
                                        Текущий план
                                    @else
                                        <form method="POST" action="{{ route('pay.subscribe') }}">
                                            @csrf
                                            <input type="hidden" name="sub_id" value="{{ $subscription['id'] }}">
                                            <button type="submit" class="btn">Оформить</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection


