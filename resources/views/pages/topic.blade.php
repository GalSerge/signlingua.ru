@extends('layouts.page',
['title' => $topic['name'],
'prev' => ['route' => 'topics', 'label' => 'Словари'],
'js' => ['https://api-maps.yandex.ru/2.1/?lang=ru_RU&apikey=' . config('services.yandex_maps'), '/js/ymap-topic.js']])

@section('section')
    <script>
        var words = @json($topic['words']);
        const topic_id = {{ $topic['id'] }};
        const search_url = '{{ route('words.search') }}';
    </script>

    <div class="container">
        <div class="row d-flex ">
            <div class="col-lg-3 col-md-4 col-sm-12 m-b30 dict-list">
                <h4>Выберете слово</h4>
                <div class="form-group">
                    <input type="text" class="form-control" onchange="onChangeHandler()" id="search-word-input" placeholder="Введите текст и нажмите &crarr;"/>
                </div>
                <div id="words-list">
                    @foreach($topic['words'] as $word)
                        <a href="##" class="btn m-1 px-2" onclick="setWordRegions('{{ $word['id'] }}')">{{ $word['text'] }}</a>
                    @endforeach
                </div>
            </div>

            <div class="col-lg-9 col-md-8 col-sm-12">
            <h4>Смотрите его обозначение на карте</h4>
                <div style="width: 100%; height: 600px; padding: 0; margin: 0;" id="map"></div>
            </div>
        </div>
    </div>
   
@endsection



