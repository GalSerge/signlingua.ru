@extends('layouts.profile', ['title' => 'Финансы'])

@php
$statuses = [
'PENDING' => 'Создан',
'WAITING' => 'Ожидает подтверждения',
'SUCCEEDED' => 'Успешно завершен',
'CANCELED' => 'Отменен',
'REFUNDED' => 'Успешно возвращен',
'CANCELED_REFUND' => 'Возврат не удался'
];
@endphp

@section('pane')

@if(Auth::user()->payment_method_id != null)
<div class="container p-4">
    <h5>Способ оплаты</h5>
    <div class="payments-method">
        <div>
            {{ Auth::user()->payment_method }}
        </div>
        <button type="button" class="btn btn-secondry" data-toggle="modal" data-target="#cancelPay">Отменить</button>

        <form method="POST" action="{{ route('pay.trial') }}">
            @csrf
            <button type="submit" class="btn">Изменить способ оплаты</button>
        </form>
    </div>
</div>
@endif

@if(count($payments) == 0)
    <div class="container p-4">
        <div class="row">
            <div class="col-lg-6 col-md-12 col-sm-12">
                <p>История платежей пуста.</p>
            </div>
        </div>
    </div>
@else
    <div class="container p-4">
        <h4>История платежей</h4>
        <div class="div-table">

            <div class="div-table-row div-thead">
                <div class="div-table-cell"><strong>Дата и время</strong></div>
                <div class="div-table-cell"><strong>Назначение</strong></div>
                <div class="div-table-cell"><strong>Сумма (руб.)</strong></div>
                <div class="div-table-cell"><strong>Статус</strong></div>
            </div>


            @foreach($payments as $payment)
                <div class="div-table-row">
                    <div class="div-table-cell cell-1">{{ date('d.m.Y h:i', strtotime($payment['created_at'])) }}</div>
                    <div class="div-table-cell cell-2"><span class="hidden-lg-up">Назначение: </span>{{ $payment['description'] }}</div>
                    <div class="div-table-cell cell-3"><span class="hidden-lg-up">Сумма: </span>{{ $payment['amount'] }}</div>
                    <div class="div-table-cell cell-4"><span class="hidden-lg-up">Статус: </span>{{ $statuses[$payment['status']] }}</div>
                </div>
            @endforeach

        </div>
    </div>
@endif


<div id="cancelPay" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Автопродление подписки будет отменено. Приобретенные опции доступны до конца предоставленного
                    периода. Продолжить?</p>
            </div>
            <div class="modal-footer">
                <form method="POST" action="{{ route('pay.cancel') }}">
                    @csrf
                    <button type="submit" class="btn">Да</button>
                </form>
                <button type="button" class="btn btn-secondry" data-dismiss="modal">Закрыть</button>
            </div>
        </div>

    </div>
</div>
@endsection