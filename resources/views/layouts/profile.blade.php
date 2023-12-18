@extends('layouts.app')

@section('content')
    <div class="container my-4">
        @if (View::hasSection('errors'))
            @yield('errors')
        @else
            @if (\Session::has('status'))
                <div class="complete-msg"><img src="{{ asset('/images/icons/complete-icon.svg')}}" alt="Успешно">
                    <span>{{ \Session::get('status') }}</span>
                </div>
            @endif
        @endif

        @if (\Session::has('error'))
            <div class="danger-msg"><img src="{{ asset('/images/icons/danger-icon.svg') }}" alt="Ошибка">
                <span>{{ \Session::get('error') }}</span>
            </div>
        @endif
    </div>

    <div class="section-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-12 m-b30">
                    <div class="profile-bx text-center">

                        <div class="user-profile-thumb ava"
                             style="background-image:url({{ asset('storage/images/users/' . Auth::user()->img) }})">
                        </div>
                        <div class="profile-info">
                            <h4>{{ Auth::user()->name . ' ' . Auth::user()->surname }}</h4>
                            <span>{{ Auth::user()->email }}</span>
                        </div>
                        <a class="btn-secondry" href="{{ route('logout') }}">Выйти</a>
                        <div class="profile-tabnav">
                            @include('components.profile-menu')
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-8 col-sm-12 m-b30">
                    <div class="profile-content-bx">
                        <div class="tab-content">
                            <div class="profile-head">
                                <h3>{{ $title }}</h3>
                            </div>
                            @yield('pane')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection