<div class="form-group row">
    <label class="col-md-4 control-label">{{ $label }}</label>
    <div class="col-md-6 btn-group" data-toggle="buttons">
        @foreach($list as $key => $value)
            <label class="btn btn-default">
                <input type="checkbox" name="{{ $id }}-{{ $key }}" autocomplete="off"/>
                {{ $value }}
            </label>
        @endforeach
    </div>
</div>
