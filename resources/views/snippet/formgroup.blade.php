<div class="form-group{{ $errors->has($id) ? ' has-error' : '' }}">
    <label for="{{ $id }}" class="col-md-4 control-label">{{ $label }}</label>

    <div class="col-md-6">
        @if($type == 'text')
            <input id="{{ $id }}" class="form-control{{ $class }}" placeholder="{{ $placeholder }}">
            @if(isset($hidden))
                <input type="hidden" id="{{ $id . $hidden }}" name="{{ $id . $hidden }}"/>
            @endif
        @endif

        @if ($errors->has($id))
            <span class="help-block">
                <strong>{{ $errors->first($id) }}</strong>
            </span>
        @endif
    </div>
</div>