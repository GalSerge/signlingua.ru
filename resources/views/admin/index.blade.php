@extends('admin.main')

@section('content')
    <div class="section-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 m-b30">
                    <h3>{{ $title }}</h3>
                    @if(Route::has($resource.'.create'))
                        <div class="col-lg-12 col-md-12 col-sm-12 m-b30">
                            <a class="btn" href="{{ route($resource.'.create') }}">Добавить</a>
                        </div>
                    @endif

                    @if (\Session::has('status'))
                        <div class="col-lg-12 col-md-12 col-sm-12 m-b30">
                            <div class="complete-msg"><img src="{{ asset('/images/icons/complete-icon.svg')}}"
                                                           alt="Успешно">
                                <span>{{ \Session::get('status') }}</span>
                            </div>
                        </div>
                    @endif

                    @if (\Session::has('error'))
                        <div class="col-lg-12 col-md-12 col-sm-12 m-b30">
                            <div class="danger-msg"><img src="{{ asset('/images/icons/danger-icon.svg') }}"
                                                         alt="Ошибка">
                                <span>{{ \Session::get('error') }}</span>
                            </div>
                        </div>
                    @endif
                    @if($additional != null)
                        <div class="col-lg-8 col-md-8 col-sm-12 m-b30">
                            @include('admin.pages.additional.' . $additional)
                        </div>
                    @endif
                    <div class="col-lg-12 col-md-12 col-sm-12 m-b30">
                        <div class="div-table">
                            @include('admin.items')
                        </div>
                    </div>
                    <div class="col-lg-12 m-b20">
                        <div class="pagination-bx rounded-sm gray clearfix">
                            <ul class="pagination">
                                @foreach($links as $link)
                                    @if($loop->first)
                                        @if($link['url'] != null)
                                            <li class="previous"><a href="{{ $link['url'] }}"><i
                                                            class="ti-arrow-left"></i>
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
            </div>
        </div>
    </div>
@endsection
