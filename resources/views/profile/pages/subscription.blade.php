@extends('layouts.profile', ['title' => 'Подписка'])

@section('pane')
    @if($subscription == null)
        <div class="container p-4">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <p>У вас нет активной подписки.</p>
                    <a class="btn" href="{{ route('subscriptions') }}">Выбрать план</a>
                </div>
            </div>
        </div>
    @else
        <div class="container p-4">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div class="action-card publish">
                        <div class="cours-bx">

                            <div class="info-sub text-center">
                                <h5><a href="{{ route('subscription', $subscription['id']) }}">{{ $subscription['name'] }}</a></h5>

                            </div>
                            <div class="cours-more-info">

                                <div class="price text-center">
                                    <p>Стоимость подписки</p>
                                    <h5>{{ $subscription['amount'] }} руб.</h5>
                                </div>
                            </div>
                            <div class="cours-more-info">

                                <div class="price text-center">
                                    <p>Дата окончания</p>
                                    <h5>{{ $date_end }}</h5>
                                </div>
                            </div>
                            <div class="cours-more-info">

                                <div class="price text-center">
                                    <a href="{{ route('subscriptions') }}" class="btn">Изменить</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endif
@endsection