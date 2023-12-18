<div class="top-bar">
    <div class="container">
        <div class="row d-flex justify-content-between">
            <div class="topbar-left">
                <ul>
                    <li><a href="https://signlingua.ru/profile/courses">Личный кабинет</a>
                    </li>
                 </ul>
            </div>
            <div class="topbar-right">

                @auth
                    @php
                        $notifications = Auth::user()->unreadNotifications->toArray();
                    @endphp
                    @if(count($notifications) > 0)
                        <div class="dropdown show dropleft notice">
                            <a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                               aria-expanded="false">
                                <img src="/images/icons/notice.svg" alt="Уведомления">
                                <span class="notice-number">{{ count($notifications) }}</span>
                            </a>

                            <div class="dropdown-menu notice-block" aria-labelledby="dropdownMenuLink">
                                <div class="container">
                                    <div class="row">
                                        @foreach($notifications as $notification)
                                            @if(isset($notification['data']['msg']))
                                                <div class="col-12 notice-item">
                                                    {{--<p><strong>{{ $notification['data']['msg'] }}</strong></p>--}}
                                                    <p>{{ $notification['data']['msg'] }}</p>
                                                </div>
                                            @endif
                                        @endforeach
                                        <div class="col-12 notice-item">
                                            <form method="POST" class="text-center" action="{{ route('profile.read-notes') }}">
                                                @csrf
                                                <button class="btn" type="submit">Отметить все как прочитанные</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="user-profile-thumb ava">
                        <a href="{{ route('profile.courses') }}" style="background-image:url({{ asset('storage/images/users/' . Auth::user()->img) }})">
                        </a>
                    </div>

                   
                @endauth
                @guest
                    <ul>
                        <li><a href="{{ route('login') }}">Вход</a></li>
                        <li><a href="{{ route('register') }}">Регистрация</a></li>
                    </ul>
                @endguest
            </div>
        </div>
    </div>
</div>
<div class="sticky-header navbar-expand-lg">
    <div class="menu-bar clearfix">
        <div class="container clearfix">
            <div class="menu-logo">
                <a href="/"><img src="{{ asset('images/logo-header.png') }}" alt=""></a>
            </div>
            <button class="navbar-toggler collapsed menuicon justify-content-end" type="button"
                    data-toggle="collapse" data-target="#menuDropdown" aria-controls="menuDropdown"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <div class="secondary-menu">
                <div class="secondary-inner">
                    <ul>
                        <li><a target="_blank" href="#" class="btn-link"><i class="fa fa-vk"></i></a></li>
                        <li><a target="_blank" href="#" class="btn-link"><i class="fa fa-telegram"></i></a></li>
                        <li><a target="_blank" href="https://perevod.asu.edu.ru/" class="btn-link"><i class="fa fa-globe"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="menu-links navbar-collapse collapse justify-content-start" id="menuDropdown">
                <div class="menu-logo">
                    <a href="#"><img src="{{ asset('images/logo-header.png') }}" alt=""></a>
                </div>
                <ul class="nav navbar-nav">
                    <li class="active"><a href="{{ route('courses') }}">Курсы</a></li>
                    <li class="active"><a href="{{ route('subscriptions') }}">Подписки</a></li>
                    <li class="active"><a href="{{ route('topics') }}">Словари</a></li>
                    <li class="active"><a href="{{ route('feedback') }}">Контакты</a></li>
                 </ul>
                <div class="nav-social-link">
                    <a target="_blank" href="#"><i class="fa fa-vk"></i></a>
                    <a target="_blank" href="#"><i class="fa fa-telegram"></i></a>
                    <a target="_blank" href="https://perevod.asu.edu.ru/"><i class="fa fa-globe"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>