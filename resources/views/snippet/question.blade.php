<div class="form-group row">
    <label for="{{ $name }}" class="control-label col-md-8">{{ $label }}</label>

    <div class="col-md-2">
        <select id="{{ $name }}" name="{{ $name }}" class="form-control">
            @foreach($list as $item)
                <option value="{{ $item["id"] }}"{{ (old($name, $formobject[$name]) == $item["id"]) ? " selected" : "" }}>
                     {{ $item["option"] }}
                </option>
            @endforeach
        </select>
    </div>
</div>