@extends('layouts.app')

@section('css')
    <link href="https://fonts.googleapis.com/css?family=Bangers|Fredericka+the+Great|Great+Vibes|Indie+Flower|Mystery+Quest"
          rel="stylesheet">
@endsection

@section('content')
    <p>&nbsp;</p>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">Customize Nametags</div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/nametag') .
                 (isset($readonly) && $readonly === false ? '/f/' . $campers->first()->familyid : '')}}">
                    {{ csrf_field() }}

                    @if(!empty($success))
                        <div class="alert alert-success">
                            {!! $success !!}
                        </div>
                    @endif
                    <ul class="nav nav-tabs" role="tablist">
                        @foreach($campers as $camper)
                            <li role="presentation"{!! $loop->first ? ' class="active"' : '' !!}>
                                <a href="#{{ $camper->id }}" aria-controls="{{ $camper->id }}" role="tab"
                                   data-toggle="tab">{{ $camper->firstname }} {{ $camper->lastname }}</a></li>
                        @endforeach
                    </ul>

                    <div class="tab-content">
                        @foreach($campers as $camper)
                            <div role="tabpanel" class="tab-pane fade{{ $loop->first ? ' in active' : '' }}"
                                 id="{{ $camper->id }}">
                                <p>&nbsp;</p>
                                <button class="btn btn-default copyAnswers pull-right">Copy Preferences to<br/>All
                                    Family Members
                                </button>
                                <div class="preview{{ $camper->yearattending->fontapply == '2' ? ' ' . $camper->yearattending->font_value : '' }}">
                                    <div class="pronoun">{{ $camper->yearattending->pronoun_value }}</div>
                                    <div class="name {{ $camper->yearattending->font_value }}"
                                         style="font-size: {{ $camper->yearattending->namesize+1 }}em;">{{ $camper->yearattending->name_value }}</div>
                                    <div class="surname">{{ $camper->yearattending->surname_value  }}</div>
                                    <div class="line1">{{ $camper->yearattending->line1_value }}</div>
                                    <div class="line2">{{ $camper->yearattending->line2_value }}</div>
                                    <div class="line3">{{ $camper->yearattending->line3_value }}</div>
                                    <div class="line4">{{ $camper->yearattending->line4_value }}</div>
                                    @if($camper->age<18)
                                        <div class="parent">{!! $camper->parent !!}</div>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has($camper->id . '-nametag-pronoun') ? ' has-error' : '' }}">
                                    <label for="{{ $camper->id }}-nametag-pronoun"
                                           class="col-md-4 control-label">Pronoun</label>

                                    <div class="col-md-6">
                                        <select class="form-control" id="{{ $camper->id }}-nametag-pronoun"
                                                name="{{ $camper->id }}-nametag-pronoun">
                                            <option value="2"{{ $camper->yearattending->pronoun == '2' ? ' selected' : '' }}>
                                                Displayed in Corner
                                            </option>
                                            <option value="1"{{ $camper->yearattending->pronoun == '1' ? ' selected' : '' }}>
                                                Not Displayed
                                            </option>
                                        </select>

                                        @if ($errors->has($camper->id . '-nametag-pronoun'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first($camper->id . '-nametag-pronoun') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has($camper->id . '-nametag-name') ? ' has-error' : '' }}">
                                    <label for="{{ $camper->id }}-nametag-name"
                                           class="col-md-4 control-label">Name Format</label>

                                    <div class="col-md-6">
                                        <select class="form-control" id="{{ $camper->id }}-nametag-name"
                                                name="{{ $camper->id }}-nametag-name">
                                            <option value="2"
                                                    {{ $camper->yearattending->name == '2' ? ' selected' : '' }}
                                                    data-content="{{ $camper->firstname }} {{ $camper->lastname }}||">
                                                First Last
                                            </option>
                                            <option value="1"
                                                    {{ $camper->yearattending->name == '1' ? ' selected' : '' }}
                                                    data-content="{{ $camper->firstname }}||{{ $camper->lastname }}">
                                                First then Last (on next line)
                                            </option>
                                            <option value="3"
                                                    {{ $camper->yearattending->name == '3' ? ' selected' : '' }}
                                                    data-content="{{ $camper->firstname }} {{ $camper->lastname }}||{{ $camper->family->family_name }}">
                                                First Last then Family Name (on next line)
                                            </option>
                                            <option value="1"
                                                    {{ $camper->yearattending->name == '4' ? ' selected' : '' }}
                                                    data-content="{{ $camper->firstname }}||">
                                                First Only
                                            </option>
                                        </select>

                                        @if ($errors->has($camper->id . '-nametag-name'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first($camper->id . '-nametag-name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has($camper->id . '-nametag-namesize') ? ' has-error' : '' }}">
                                    <label for="{{ $camper->id }}-nametag-namesize"
                                           class="col-md-4 control-label">Name Size</label>

                                    <div class="col-md-6">
                                        <select class="form-control" id="{{ $camper->id }}-nametag-namesize"
                                                name="{{ $camper->id }}-nametag-namesize">
                                            <option value="2"{{ $camper->yearattending->namesize == '2' ? ' selected' : '' }}>
                                                Normal
                                            </option>
                                            <option value="3"{{ $camper->yearattending->namesize == '3' ? ' selected' : '' }}>
                                                Big
                                            </option>
                                            <option value="4"{{ $camper->yearattending->namesize == '4' ? ' selected' : '' }}>
                                                Bigger
                                            </option>
                                            <option value="5"{{ $camper->yearattending->namesize == '5' ? ' selected' : '' }}>
                                                Bigly
                                            </option>
                                            <option value="1"{{ $camper->yearattending->namesize == '1' ? ' selected' : '' }}>
                                                Small
                                            </option>
                                        </select>

                                        @if ($errors->has($camper->id . '-nametag-namesize'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first($camper->id . '-nametag-namesize') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has($camper->id . '-nametag-line1') ? ' has-error' : '' }}">
                                    <label for="{{ $camper->id }}-nametag-line1"
                                           class="col-md-4 control-label">Line #1</label>

                                    <div class="col-md-6">
                                        <select class="form-control" id="{{ $camper->id }}-nametag-line1"
                                                name="{{ $camper->id }}-nametag-line1">
                                            <option value="2"
                                                    {{ $camper->yearattending->line1 == '2' ? ' selected' : '' }}
                                                    data-content="{{ $camper->family->city . ", " . $camper->family->statecd }}">
                                                Home (City, State)
                                            </option>
                                            <option value="1"
                                                    {{ $camper->yearattending->line1 == '1' ? ' selected' : '' }}
                                                    data-content="{{ $camper->church->name }}">
                                                Congregation (Name)
                                            </option>
                                            @if(count($camper->yearattending->positions) > 0)
                                                <option value="3"
                                                        {{ $camper->yearattending->line1 == '3' ? ' selected' : '' }}
                                                        data-content="Your PC Position">
                                                    Planning Council Position
                                                </option>
                                            @endif
                                            @if($camper->yearattending->is_firsttime == '0')
                                                <option value="4"
                                                        {{ $camper->yearattending->line1 == '4' ? ' selected' : '' }}
                                                        data-content="First-time Camper">
                                                    First-time Camper (Status)
                                                </option>
                                            @endif
                                            <option value="5"
                                                    {{ $camper->yearattending->line1 == '5' ? ' selected' : '' }}
                                                    data-content="">
                                                Nothing
                                            </option>
                                        </select>

                                        @if ($errors->has($camper->id . '-nametag-line1'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first($camper->id . '-nametag-line1') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has($camper->id . '-nametag-line2') ? ' has-error' : '' }}">
                                    <label for="{{ $camper->id }}-nametag-line2"
                                           class="col-md-4 control-label">Line #2</label>

                                    <div class="col-md-6">
                                        <select class="form-control" id="{{ $camper->id }}-nametag-line2"
                                                name="{{ $camper->id }}-nametag-line2">
                                            <option value="2"
                                                    {{ $camper->yearattending->line2 == '2' ? ' selected' : '' }}
                                                    data-content="{{ $camper->family->city . ", " . $camper->family->statecd }}">
                                                Home (City, State)
                                            </option>
                                            <option value="1"
                                                    {{ $camper->yearattending->line2 == '1' ? ' selected' : '' }}
                                                    data-content="{{ $camper->church->name }}">
                                                Congregation (Name)
                                            </option>
                                            @if(count($camper->yearattending->positions) > 0)
                                                <option value="3"
                                                        {{ $camper->yearattending->line2 == '3' ? ' selected' : '' }}
                                                        data-content="Your PC Position">
                                                    Planning Council Position
                                                </option>
                                            @endif
                                            @if($camper->yearattending->is_firsttime == '0')
                                                <option value="4"
                                                        {{ $camper->yearattending->line2 == '4' ? ' selected' : '' }}
                                                        data-content="First-time Camper">
                                                    First-time Camper (Status)
                                                </option>
                                            @endif
                                            <option value="5"
                                                    {{ $camper->yearattending->line2 == '5' ? ' selected' : '' }}
                                                    data-content="">
                                                Nothing
                                            </option>
                                        </select>

                                        @if ($errors->has($camper->id . '-nametag-line3'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first($camper->id . '-nametag-line3') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has($camper->id . '-nametag-line3') ? ' has-error' : '' }}">
                                    <label for="{{ $camper->id }}-nametag-line3"
                                           class="col-md-4 control-label">Line #3</label>

                                    <div class="col-md-6">
                                        <select class="form-control" id="{{ $camper->id }}-nametag-line3"
                                                name="{{ $camper->id }}-nametag-line3">
                                            <option value="2"
                                                    {{ $camper->yearattending->line3 == '2' ? ' selected' : '' }}
                                                    data-content="{{ $camper->family->city . ", " . $camper->family->statecd }}">
                                                Home (City, State)
                                            </option>
                                            <option value="1"
                                                    {{ $camper->yearattending->line3 == '1' ? ' selected' : '' }}
                                                    data-content="{{ $camper->church->name }}">
                                                Congregation (Name)
                                            </option>
                                            @if(count($camper->yearattending->positions) > 0)
                                                <option value="3"
                                                        {{ $camper->yearattending->line3 == '3' ? ' selected' : '' }}
                                                        data-content="Your PC Position">
                                                    Planning Council Position
                                                </option>
                                            @endif
                                            @if($camper->yearattending->is_firsttime == '0')
                                                <option value="4"
                                                        {{ $camper->yearattending->line3 == '4' ? ' selected' : '' }}
                                                        data-content="First-time Camper">
                                                    First-time Camper (Status)
                                                </option>
                                            @endif
                                            <option value="5"
                                                    {{ $camper->yearattending->line3 == '5' ? ' selected' : '' }}
                                                    data-content="">
                                                Nothing
                                            </option>
                                        </select>

                                        @if ($errors->has($camper->id . '-nametag-line3'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first($camper->id . '-nametag-line3') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has($camper->id . '-nametag-line4') ? ' has-error' : '' }}">
                                    <label for="{{ $camper->id }}-nametag-line4"
                                           class="col-md-4 control-label">Line #4</label>

                                    <div class="col-md-6">
                                        <select class="form-control" id="{{ $camper->id }}-nametag-line4"
                                                name="{{ $camper->id }}-nametag-line4">
                                            <option value="2"
                                                    {{ $camper->yearattending->line4 == '2' ? ' selected' : '' }}
                                                    data-content="{{ $camper->family->city . ", " . $camper->family->statecd }}">
                                                Home (City, State)
                                            </option>
                                            <option value="1"
                                                    {{ $camper->yearattending->line4 == '1' ? ' selected' : '' }}
                                                    data-content="{{ $camper->church->name }}">
                                                Congregation (Name)
                                            </option>
                                            @if(count($camper->yearattending->positions) > 0)
                                                <option value="3"
                                                        {{ $camper->yearattending->line4 == '3' ? ' selected' : '' }}
                                                        data-content="Your PC Position">
                                                    Planning Council Position
                                                </option>
                                            @endif
                                            @if($camper->yearattending->is_firsttime == '0')
                                                <option value="4"
                                                        {{ $camper->yearattending->line4 == '4' ? ' selected' : '' }}
                                                        data-content="First-time Camper">
                                                    First-time Camper (Status)
                                                </option>
                                            @endif
                                            <option value="5"
                                                    {{ $camper->yearattending->line4 == '5' ? ' selected' : '' }}
                                                    data-content="">
                                                Nothing
                                            </option>
                                        </select>

                                        @if ($errors->has($camper->id . '-nametag-line4'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first($camper->id . '-nametag-line4') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has($camper->id . '-nametag-fontapply') ? ' has-error' : '' }}">
                                    <label for="{{ $camper->id }}-nametag-fontapply"
                                           class="col-md-4 control-label">Font Application</label>

                                    <div class="col-md-6">
                                        <select class="form-control" id="{{ $camper->id }}-nametag-fontapply"
                                                name="{{ $camper->id }}-nametag-fontapply">
                                            <option value="1"{{ $camper->yearattending->fontapply == '1' ? ' selected' : '' }}>
                                                Apply Font to Primary Name Only
                                            </option>
                                            <option value="2"{{ $camper->yearattending->fontapply == '2' ? ' selected' : '' }}>
                                                Apply Font to All Text
                                            </option>
                                        </select>

                                        @if ($errors->has($camper->id . '-nametag-fontapply'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first($camper->id . '-nametag-fontapply') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has($camper->id . '-nametag-font') ? ' has-error' : '' }}">
                                    <label for="{{ $camper->id }}-nametag-font"
                                           class="col-md-4 control-label">Font</label>
                                    <a href="#" class="fa fa-info" data-toggle="tooltip" data-html="true"  
                                       title="<div style='font-size: 1.5em'><p class='opensans'>Open Sans</p>
                                            <p class='indie'>Indie Flower</p>
                                            <p class='ftg'>Fredericka the Great</p>
                                            <p class='quest'>Mystery Quest</p>
                                            <p class='vibes'>Great Vibes</p>
                                            <p class='bangers'>Bangers</p>
                                            <p class='comic'>Comic Sans</p></div>"></a>

                                    <div class="col-md-6">
                                        <select class="form-control" id="{{ $camper->id }}-nametag-font"
                                                name="{{ $camper->id }}-nametag-font">
                                            <option data-content="opensans"
                                                    value="1"{{ $camper->yearattending->font == '1' ? ' selected' : '' }}>
                                                Open Sans
                                            </option>
                                            <option data-content="indie"
                                                    value="2"{{ $camper->yearattending->font == '2' ? ' selected' : '' }}>
                                                Indie Flower
                                            </option>
                                            <option data-content="ftg"
                                                    value="3"{{ $camper->yearattending->font == '3' ? ' selected' : '' }}>
                                                Fredericka the Great
                                            </option>
                                            <option data-content="quest"
                                                    value="4"{{ $camper->yearattending->font == '4' ? ' selected' : '' }}>
                                                Mystery Quest
                                            </option>
                                            <option data-content="vibes"
                                                    value="5"{{ $camper->yearattending->font == '5' ? ' selected' : '' }}>
                                                Great Vibes
                                            </option>
                                            <option data-content="bangers"
                                                    value="6"{{ $camper->yearattending->font == '6' ? ' selected' : '' }}>
                                                Bangers
                                            </option>
                                            <option data-content="comic"
                                                    value="7"{{ $camper->yearattending->font == '7' ? ' selected' : '' }}>
                                                Comic Sans
                                            </option>
                                        </select>

                                        @if ($errors->has($camper->id . '-nametag-font'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first($camper->id . '-nametag-font') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-2 col-md-offset-8">
                                        <button type="button" class="btn btn-default next">
                                            Next Camper
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if(!isset($readonly) || $readonly === false)
                        <div class="form-group">
                            <div class="col-md-2 col-md-offset-8">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">

        $(function () {
            @if(count($errors))
                $('.nav-tabs a[href="#' + $("span.help-block").first().parents('div.tab-pane').attr('id') + '"]').trigger('click');
            @endif

            $("[data-toggle='tooltip']").tooltip({
                content: function () {
                    return this.getAttribute("title");
                }
            });

            $('.next').click(function () {
                $('.nav-tabs > .active').next('li').find('a').trigger('click');
                $('html,body').animate({
                    scrollTop: 0
                }, 700);
            });

            $(".copyAnswers").on('click', function () {
                var mytab = $(this).parents(".tab-pane");
                var alltabs = mytab.parents(".tab-content").find(".tab-pane");
                var elements = mytab.find("select");
                alltabs.each(function () {
                    $(this).find("select").each(function (index) {
                        if (($(this).find("option[value=" + elements[index].value + "]").length !== 0)) {
                            $(this).val(elements[index].value);
                        } else {
                            $(this).val("5");
                        }
                    });
                    redraw($(this));
                });
                return false;
            });

            $("form select").on('change', function () {
                redraw($(this).parents(".tab-pane"));
            });

            @if(isset($readonly) && $readonly === true)
                $("input:not(#camper), select").prop("disabled", "true");
            @endif
        });

        function redraw(obj) {
            var id = obj.attr("id");
            var font = $("#" + id + "-nametag-font option:selected").attr("data-content");
            $("#" + id + "-nametag-pronoun").val() === '1' ? obj.find(".pronoun").hide() : obj.find(".pronoun").show();
            var names = $("#" + id + "-nametag-name option:selected").attr("data-content").split("||");
            obj.find(".name").text(names[0]).attr("style", "font-size: " + (parseInt($("#" + id + "-nametag-namesize").val(), 10) + 1) + "em").removeClass().addClass("name").addClass(font);
            obj.find(".surname").text(names[1]);
            for (var i = 1; i < 5; i++) {
                obj.find(".line" + i).text($("#" + id + "-nametag-line" + i + " option:selected").attr("data-content"));
            }
            obj.find(".preview").removeClass().addClass("preview");
            if ($("#" + id + "-nametag-fontapply").val() === '2') {
                obj.find(".preview").addClass(font);
            }
        }

    </script>
@endsection