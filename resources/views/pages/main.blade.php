@extends('layouts.app', ['title' => 'Интерактивная онлайн-платформа русского жестового языка'])

@section('content')
    <div class="page-banner page-banner-index ovbl-dark mb-5" style="background-image:url({{ asset('images/banners/banner-index.jpg') }});">
        <div class="container">
            <div class="cell">
                <div class="col-md-12 col-lg-8">
                    <h1>Интерактивная онлайн-платформа русского жестового языка</h1>
                    <p>Конформизм, согласно традиционным представлениям, сложен. Наши исследования позволяют сделать
                        вывод о том, что самость просветляет социальный контраст.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="section-area mt-5">
        <div class="container">
            <h2 class="mb-5">Наши курсы</h2>
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-sm-12 m-b30">
                        <div class="widget">
                            <a href="https://signlingua.ru/subs"><img src="images/banners/ban1.jpg" alt="Подписка" /></a>
                        </div>

                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-12">
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
            </div>
        </div>
    </div>

    <div class="section-area section-sp2 bg-fix ovbl-dark" style="background-image:url({{ asset('images/banners/banner2.jpg') }});">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-white heading-bx left">
                    <h2 class="title-head text-uppercase">Что говорят люди</h2>
                    <p>Отзывы тех кто прошел наши курсы</p>
                </div>
            </div>
            <div class="testimonial-carousel owl-carousel owl-btn-1 col-12 p-lr0">
                <div class="item">
                    <div class="testimonial-bx">

                        <div class="testimonial-info">
                            <h5 class="name">Питер Паркер</h5>

                        </div>
                        <div class="testimonial-content">
                            <p>Осушение ненаблюдаемо. Как показывает практика режимных наблюдений в полевых условиях, эксикатор последовательно отражает неоднородный водоупор. Кутана вероятна. Горизонт восстанавливает процесс.</p>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="testimonial-bx">

                        <div class="testimonial-info">
                            <h5 class="name">Человек Паук</h5>

                        </div>
                        <div class="testimonial-content">
                            <p>Органическое вещество, по данным почвенной съемки, одномерно усиливает ортштейн. В условиях очагового земледелия грунт разрушаем. Солеперенос отражает непромывной псевдомицелий, что лишний раз подтверждает правоту Докучаева. Оглеение, как бы это ни казалось парадоксальным, нейтрализует пирогенный грунт. Стяжение латентно.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section-area section-sp1">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 m-b30">
                    <h2 class="title-head ">Интерактивная онлайн-платформа РЖЯ - это не только про курсы</h2>
                    <p>Несколько восхваляющих слов о себе.  Вопрос о популярности произведений того или иного автора относится к сфере культурологии, однако аллитерация приводит конструктивный стих. Мифопоэтическое пространство синфазно.</p>
                    <a href="https://signlingua.ru/courses" class="btn button-md">Выбирай свой курс</a>
                </div>
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 m-b30">
                            <div class="feature-container">
                                <div class="feature-md text-white m-b20">
                                    <div href="#" class="icon-cell"><img src="{{ 'images/icons/icon1.svg' }}" alt=""></div>
                                </div>
                                <div class="icon-content">
                                    <h5 class="ttr-tilte">Образовательные курсы</h5>
                                    <p>Пару слов про образовательные курсы</p>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 m-b30">
                            <div class="feature-container">
                                <div class="feature-md text-white m-b20">
                                    <div href="#" class="icon-cell"><img src="{{ 'images/icons/icon2.svg' }}" alt=""></div>
                                </div>
                                <div class="icon-content">
                                    <h5 class="ttr-tilte">Карта региолектов</h5>
                                    <p>Одно предложение про карты региолектов</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 m-b30">
                            <div class="feature-container">
                                <div class="feature-md text-white m-b20">
                                    <div href="#" class="icon-cell"><img src="{{ 'images/icons/icon3.svg' }}" alt=""></div>
                                </div>
                                <div class="icon-content">
                                    <h5 class="ttr-tilte">Интерактивные игры</h5>
                                    <p>Несколько слов про игры</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 m-b30">
                            <div class="feature-container">
                                <div class="feature-md text-white m-b20">
                                    <div href="#" class="icon-cell"><img src="{{ 'images/icons/icon4.svg' }}" alt=""></div>
                                </div>
                                <div class="icon-content">
                                    <h5 class="ttr-tilte">Видео-словарь</h5>
                                    <p>Слова восхваляющие видео-словарь</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


