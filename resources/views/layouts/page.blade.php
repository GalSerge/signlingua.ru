@extends('layouts.app')

@section('content')
    <div class="breadcrumb-row">
        @include('components.breadcrumbs')
    </div>

    <div class="section-area section-sp1">
        @yield('section')
    </div>
@endsection