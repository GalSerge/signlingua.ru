@extends('admin.main', ['js' => ['https://api-maps.yandex.ru/2.1/?lang=ru_RU&apikey=' . config('services.yandex_maps'), '/js/ymap-topic-admin.js']])

@section('content')
    <script>
        tinymce.init({
            selector: 'textarea',
            language: 'ru',
            plugins: 'mentions anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed permanentpen footnotes advtemplate advtable advcode editimage tableofcontents mergetags powerpaste tinymcespellchecker autocorrect a11ychecker typography inlinecss',});
    </script>
    <div class="section-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 m-b30">
                    <h3>{{ $title }}</h3>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 m-b30">
                    @if (\Session::has('status'))
                        <div class="complete-msg"><img src="{{ asset('/images/icons/complete-icon.svg')}}" alt="Успешно">
                            <span>{{ \Session::get('status') }}</span>
                        </div>
                    @endif

                    @if (\Session::has('error'))
                        <div class="danger-msg"><img src="{{ asset('/images/icons/danger-icon.svg') }}" alt="Ошибка">
                            <span>{{ \Session::get('error') }}</span>
                        </div>
                    @endif
                </div>
                <div class="col-lg-6 col-md-8 col-sm-12 m-b30">
                    <form action="{{ route($callback, $id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method($method)
                        @each('admin.field', $fields, 'field')
                        <div class="form-group">
                            <button type="submit" class="btn btn-submit">Сохранить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

