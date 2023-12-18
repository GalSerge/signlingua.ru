@extends('admin.main')

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
                <div class="col-lg-6 col-md-6 col-sm-12 m-b30">
                    <form action="{{ route($callback, $word['id'] ?? null) }}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        @method($method)
                        <input type="hidden" id="word_id" value="{{ $word['id'] ?? '' }}"/>
                        <input type="hidden" id="word_tag" value="{{ $word['tag'] ?? '' }}"/>
                        <div class="form-group">
                            <label class="form-label">Слово</label>
                            <input class="form-control" type="text" name="text" value="{{ $word['text'] ?? '' }}"
                                   class="form-control" required>
                            @if($errors->has('text'))
                                <div class="error">{{ $errors->first('text') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="form-label">Словари</label>
                            <select style="height: auto" class="form-control" multiple="multiple" name="topics[]"
                                    id="topics">
                                @foreach($topics as $topic)
                                    <option value="{{ $topic['id'] }}" @selected($topic['selected'])>{{ $topic['name'] }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('topics'))
                                <div class="error">{{ $errors->first('topics') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-submit">Сохранить</button>
                        </div>
                    </form>
                    <div style="border: 1px solid #e9e9e9; padding: 2%;">
                        @if(isset($word['regions']))
                            <label class="form-label">Регионы</label>
                            <div id="regions_list">
                                @foreach($word['regions'] as $regin)
                                    <span class="region-item" id="{{ 'region_' . $regin['id'] }}">
                    <a href="##"
                       onclick="editRegionHandler('{{ $regin['id'] }}', '{{ $regin['name'] }}')">{{ $regin['name'] }}</a>
                    <a href="##" class="region-del" onclick="deleteRegionHandler('{{ $regin['id'] }}')">&#10006;</a>
                </span>
                                @endforeach
                            </div>
                        @endif
                        @if(isset($word['id']))
                            <div class="form-group">
                                <button type="button" onclick="clearFormRegionHandler()" class="btn btn-submit">Очистить
                                    форму
                                </button>
                            </div>
                            <form enctype="multipart/form-data" id="add_region_form">
                                <div class="form-group">
                                    <select class="form-control" name="region_id" id="region_id">
                                        @foreach($regions as $region)
                                            <option value="{{ $region['id'] }}">{{ $region['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <video width="100%" controls>
                                        <source src="" id="region_video" type="video/mp4">
                                    </video>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" type="file" accept="video/mp4" name="region_video_file"
                                           id="region_video_file"/>
                                </div>
                                <div class="form-group">
                                    <button type="button" onclick="addRegionHandler()" id="add_region_button"
                                            class="btn btn-submit">
                                        Добавить
                                    </button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


    <style>
        .region-item {
            background-color: var(--primary);
            padding: 5px 10px;
            border-radius: 3px;
            font-size: 13px;
            margin-right: 2px;
        }

        .region-item a {
            color: #FFFFFF;
        }

        a.region-del {
            text-decoration: none;
        }

        a.region-del:hover {
            color: var(--primary);
        }

        #regions_list {
            margin-bottom: 10px;
        }
    </style>
    <script>
        let regions = @json($regions ?? []);

        const clearFormRegionHandler = async () => {
            await clearFormRegion();
        };

        const addRegionHandler = async () => {
            await addRegion();
        };

        const editRegionHandler = async (...args) => {
            await editRegion(...args);
        };

        const deleteRegionHandler = async (...args) => {
            await deleteRegion(args);
        };

        async function editRegion(regionId, regionName) {
            const wordId = document.getElementById('word_id').value;
            const wordTag = document.getElementById('word_tag').value;
            document.getElementById('region_video').src = `/storage/videos/words/${wordTag}_${wordId}_${regionId}.mp4`;

            await resetSelector();

            const select = document.getElementById('region_id');

            const option = document.createElement('option');
            option.value = regionId;
            option.text = regionName;

            select.add(option, null);
            select.value = regionId;
        }

        async function deleteRegion(regionId) {
            let response = await fetch(`{{ route('words.region.delete', $word['id'] ?? 0) }}?region_id=${regionId}`, {
                method: 'DELETE',
            });

            if (response.ok) {
                document.getElementById(`region_${regionId}`).remove();
                await resetSelector();

                alert('Запись удалена.');
            } else {
                alert('Произошла ошибка.');
            }
        }

        async function addRegion() {
            let response = await fetch('{{ route('words.region.add', $word['id'] ?? 0) }}', {
                method: 'POST',
                body: new FormData(document.getElementById('add_region_form'))
            });

            if (response.ok) {
                const select = document.getElementById('region_id');
                const regionId = select.options[select.selectedIndex].value;
                const regionName = select.options[select.selectedIndex].text;

                const wordId = document.getElementById('word_id').value;
                const wordTag = document.getElementById('word_tag').value;

                let list = document.getElementById('regions_list')
                list.innerHTML +=
                    `<span class="region-item" id="region_${regionId}">
                        <a href="##"
                           onclick="editRegion('${regionId}', '${regionId}')">${regionName}</a>
                        <a href="##" class="region-del" onclick="deleteRegion('${regionId}')">&#10006;</a>
                    </span>`;

                document.getElementById('region_video').src = `/storage/videos/words/${wordTag}_${wordId}_${regionId}.mp4`;

                alert('Новая запись добавлена.');
            } else {
                alert('Произошла ошибка.');
            }
        }

        async function clearFormRegion() {
            document.getElementById('region_video').src = '';
            document.getElementById('region_video_file').value = '';

            await resetSelector();
        }

        function clearSelector() {
            const select = document.getElementById('region_id');

            select.value = '';
            select.innerHTML = '';

            for (let i = 0; i < regions.length; i++) {
                let option = document.createElement('option');
                option.value = regions[i].id;
                option.text = regions[i].name;
                select.add(option, null);
            }
        }

        async function resetSelector() {
            const select = document.getElementById('region_id');

            select.value = '';
            select.innerHTML = '';

            let response = await fetch('{{ route('words.regions.get', $word['id'] ?? 0) }}', {
                method: 'GET'
            });

            if (response.ok) {
                let result = await response.json();

                for (let i = 0; i < result.length; i++) {
                    let option = document.createElement('option');
                    option.value = result[i].id;
                    option.text = result[i].name;
                    select.add(option, null);
                }
            }
        }
    </script>
@endsection