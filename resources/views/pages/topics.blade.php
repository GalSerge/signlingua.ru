@extends('layouts.page', ['title' => 'Словари'])

@section('section')
    <div class="container">
        <div class="row">
            @foreach($data as $topic)
                <div class="col-md-3 col-lg-4 col-sm-6 m-b30">
                    <div class="cours-bx">
                        <div class="action-box">
                            <img src="{{ asset('storage/images/topics/' . $topic['img']) }}" alt="">
                        </div>
                        <div class="info-bx text-center">
                            <h5><a href="{{ route('topic', $topic['id']) }}">{{ $topic['name'] }}</a></h5>
                        </div>
                        @auth
                            <div class="cours-more-info">
                                <div class="price text-center">
                                    <a class="btn" href="{{ route('training', $topic['id']) }}">Тренировать</a>
                                </div>
                            </div>
                        @endauth
                    </div>
                </div>
            @endforeach
        </div>
        <div class="col-lg-12 m-b20">
            <div class="pagination-bx rounded-sm gray clearfix">
                <ul class="pagination">
                    @foreach($links as $link)
                        @if($loop->first)
                            @if($link['url'] != null)
                                <li class="previous"><a href="{{ $link['url'] }}"><i class="ti-arrow-left"></i>
                                        Предыдущая</a></li>
                            @endif
                        @elseif($loop->last)
                            @if($link['url'] != null)
                                <li class="next"><a href="{{ $link['url'] }}">Следующая <i
                                                class="ti-arrow-right"></i></a>
                                </li>
                            @endif
                        @elseif($link['active'])
                            <li class="active"><a href="{{ $link['url'] }}">{{ $link['label'] }}</a></li>
                        @else
                            <li><a href="{{ $link['url'] }}">{{ $link['label'] }}</a></li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection


