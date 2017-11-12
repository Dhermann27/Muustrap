<?php
$xclass = "";
if (!empty($class)) $xclass .= ' ' . $class;
if ($errors->has($attribs["name"])) $xclass .= ' is-invalid';
if (!isset($formobject)) {
    $old = old($attribs["name"]);
} else {
    $old = old($attribs["name"], $formobject[$attribs["name"]]);
}
?>
<div class="form-group row{{ $errors->has($attribs["name"]) ? ' has-danger' : '' }}">
    <label for="{{ $attribs["name"] }}" class="col-md-4 control-label">{{ $label }}</label>
    @if(isset($title))
        <a href="#" class="fa fa-info" data-toggle="tooltip" data-placement="bottom" data-html="true"  
           title="@lang('messages.' . $title)"></a>
    @endif

    <div class="col-md-6">
        @if(isset($type))
            @if($type == 'select')
                <select id="{{ $attribs["name"] }}" name="{{ $attribs["name"] }}"
                        class="form-control{{ $xclass }}">
                    @if(!empty($default))
                        <option value="0">{{ $default }}</option>
                    @endif
                    @foreach($list as $item)
                        <option value="{{ $item["id"] }}"{{ $old == $item["id"] ? " selected" : "" }}>
                            {{ $item[$option] }}
                        </option>
                    @endforeach
                </select>
            @elseif($type == 'text')
                <textarea id="{{ $attribs["name"] }}" name="{{ $attribs["name"] }}"
                          class="form-control{{ $xclass }}">
                    {{ $old }}
                </textarea>
            @elseif($type == 'captcha')
                {!! app('captcha')->display() !!}
            @elseif($type == 'submit')
                <div class="text-lg-right">
                    <input type="submit" class="btn btn-lg btn-primary py-3 px-4 " value="{{ $attribs["name"] }}"/>
                </div>
            @elseif($type == 'info')
                <span id="{{ $attribs["name"] }}"><strong>{{ $default }}</strong></span>
            @endif
        @else
            <input id="{{ $attribs["name"] }}" class="form-control{{ $xclass }}" value="{{ $old }}"
            @foreach($attribs as $attrib => $value)
                {{ $attrib }}="{{ $value }}"
            @endforeach
            />
            @if(isset($hidden))
                <input type="hidden" id="{{ $attribs["name"] . $hidden }}" name="{{ $attribs["name"] . $hidden }}"/>
            @endif
        @endif

        @if ($errors->has($attribs["name"]))
            <span class="invalid-feedback">
                <strong>{{ $errors->first($attribs["name"]) }}</strong>
            </span>
        @endif
    </div>
</div>