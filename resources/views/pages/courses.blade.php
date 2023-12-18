@extends('layouts.page', ['title' => 'Курсы'])

@section('section')
    <div class="container">
        <h2>Курсы</h2>
        <div class="container">
            <div class="row">
                @foreach($courses as $course)
                    <div class="col-md-6 col-lg-4 col-sm-6 m-b30">
                        <div class="cours-bx">
                            <div class="action-box">
                                <img src="{{ asset('storage/images/courses/' . $course['img']) }}" alt="">
                                <a href="{{ route('course', $course['id']) }}" class="btn">Узнать больше</a>
                            </div>
                            <div class="info-bx text-center">
                                <h5><h5>{{ $course['name'] }}</h5></h5>
                            </div>
                            <div class="cours-more-info">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection


