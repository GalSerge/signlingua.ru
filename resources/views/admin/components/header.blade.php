<div class="top-bar">
    <div class="container">
        <div class="row d-flex justify-content-between">
        <div class="menu-logo admin">
                <a href="/"><img src="https://signlingua.ru/images/logo-header.png" alt=""></a>
            </div>
            <div class="topbar-right">
                <div class="user-profile-thumb admin ava">
                    <a href="{{ route('admin.main') }}" style="background-image:url({{ asset('storage/images/users/' . Auth::user()->img) }})">
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>