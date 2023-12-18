<div class="form-group">
    <label class="form-label">{{ $field['label'] }}</label>

    @if($field['element'] == 'input')
        <input type="{{ $field['type'] }}" name="{{ $field['name'] }}" value="{{ $field['value'] ?? '' }}"
               @required($field["required"]) class="form-control" />

    @elseif($field['element'] == 'input-img')
        <input class="form-control" type="file" name="{{ $field['name'] }}" accept="{{ $field['accept'] }}" @required($field["required"])
        class="form-control" />
        <img width="40%" style="padding: 4px" src="{{ asset('storage/images/courses/' . ($field['value'] ?? '')) }}"/>

    @elseif($field['element'] == 'textarea')
        <textarea class="form-control" name="{{ $field['name'] }}">{{ $field['value'] ?? '' }}</textarea>

    @elseif($field['element'] == 'checkbox')
        <input type="checkbox" name="{{ $field['name'] }}" value="1" @checked((bool)$field['value']) />

    @elseif($field['element'] == 'input-number')
        <input class="form-control" type="number" name="{{ $field['name'] }}" value="{{ $field['value'] ?? '' }}" min="{{ $field['min'] }}"
               max="{{ $field['max'] }}" step="{{ $field['step'] }}"/>

    @elseif($field['element'] == 'multiple')
        <select style="height: auto" class="form-control" multiple="multiple" name="{{ $field['name'] }}[]" id="{{ $field['name'] }}">
            @foreach($field['options'] as $value => $option)
                <option value="{{ $value }}" @selected($option['selected'])>{{ $option['label'] }}</option>
            @endforeach
        </select>

    @elseif($field['element'] == 'map')
        <input type="text" class="form-control" name="{{ $field['input_latitude'] }}" id="input_latitude" value="{{ $field['value_latitude'] ?? '' }}"
               @required($field["required"]) />
        <input type="text" class="form-control" name="{{ $field['input_longitude'] }}" id="input_longitude" value="{{ $field['value_longitude'] ?? '' }}"
               @required($field["required"]) />
{{--        @once--}}
{{--            @include('admin.scripts.add-map')--}}
{{--        @endonce--}}

        <div style="width: 100%; height: 400px; padding: 0; margin: 0;" id="map"></div>
    @endif

    @if($errors->has($field['name']))
        <div class="error">{{ $errors->first($field['name']) }}</div>
    @endif
</div>