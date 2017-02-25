@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css"/>
    <link rel="stylesheet" href="/css/bootstrap-datepicker.min.css"/>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.min.css"/>
@endsection

@section('content')
    <p>&nbsp;</p>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">Camper Information</div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/camper') .
                 (isset($readonly) && $readonly === false ? '/' . $campers->first()->familyid : '')}}">
                    {{ csrf_field() }}

                    @if(!empty($success))
                        <div class="alert alert-success">
                            {!! $success !!}
                        </div>
                    @endif
                    @if(count($errors))
                        <div class="alert alert-danger">
                            Changes were not saved. Please review each camper and
                            correct the errors outlined in red. {{ $errors->first() }}
                        </div>
                    @endif
                    <ul class="nav nav-tabs" role="tablist">
                        @foreach($campers->where('id', '!=', '0') as $camper)
                            <li role="presentation"{!! $loop->first ? ' class="active"' : '' !!}>
                                <a href="#{{ $camper->id }}" aria-controls="{{ $camper->id }}" role="tab"
                                   data-toggle="tab">{{ $camper->firstname }} {{ $camper->lastname }}</a></li>
                        @endforeach
                        <li>
                            <a id="newcamper" href="#0" role="tab">Create New Camper <i class="fa fa-plus"></i></a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        @foreach($campers as $camper)
                            <div role="tabpanel" class="tab-pane fade{{ $loop->first ? ' in active' : '' }}"
                                 id="{{ $camper->id }}">
                                <p>&nbsp;</p>
                                <div class="form-group{{ $errors->has($camper->id . '-days') ? ' has-error' : '' }}">
                                    <label for="{{ $camper->id }}-days" class="col-md-4 control-label">Attending
                                        in {{ $year->year }}?</label>
                                    <a href="#" class="fa fa-info" data-toggle="tooltip" data-html="true"  
                                       title="<p>Use this dropdown to tell us if a family member is not attending
                                            MUUSA this year.</p><p>If this family member will be registering separately,
                                            please use the Contact Us form and we will split them off to their own
                                            registration form.</p>"></a>

                                    <div class="col-md-6">
                                        @if(isset($readonly))
                                            <select class="form-control days" id="{{ $camper->id }}-days"
                                                    name="{{ $camper->id }}-days">
                                                @for($i=6; $i>0; $i--)
                                                    <option value="{{ $i }}"
                                                            {{ $i == old($camper->id . '-days', isset($camper->yearattending) ? $camper->yearattending->days : null) ? ' selected' : '' }}>
                                                        {{ $i }} nights
                                                    </option>
                                                @endfor
                                                <option value="0"{{ !isset($camper->yearattending) ? ' selected' : '' }}>
                                                    Not Attending
                                                </option>
                                            </select>
                                            @if($readonly === false)
                                                <button id="quickme" class="pull-right fa fa-bolt" data-toggle="tooltip"
                                                        title="Mark everyone as attending 6 nights"></button>
                                            @endif
                                        @else
                                            <select class="form-control" id="{{ $camper->id }}-days"
                                                    name="{{ $camper->id }}-days">
                                                <option value="{{ isset($camper->yearattending) && $camper->yearattending->days > 0  ? $camper->yearattending->days : '6' }}">
                                                    Yes
                                                </option>
                                                <option value="0"{{ !isset($camper->yearattending) ? ' selected' : '' }}>
                                                    No
                                                </option>
                                            </select>
                                        @endif

                                        @if ($errors->has($camper->id . '-days'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first($camper->id . '-days') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has($camper->id . '-pronounid') ? ' has-error' : '' }}">
                                    <label for="{{ $camper->id }}-pronounid" class="col-md-4 control-label">Pronoun
                                        Preference</label>
                                    <a href="#" class="fa fa-info" data-toggle="tooltip"
                                       data-placement="left" data-html="true"
                                       title="<strong>Why do we ask?</strong>
                                                <p>MUUSA is an intentionally inclusive community that
                                                              welcomes everyone regardless of their biological sex or gender
                                                              identification. We ask that you include your preferred pronoun
                                                              for two reasons:</p>
                                                       <p>For lodging purposes, we segregate our Junior High
                                                              campers into one of two cabins in accordance with Missouri
                                                              state law. Please contact us to make special arrangements for
                                                              any camper who would prefer alternatives.</p>
                                                       <p>If you are a single camper and have not found a roommate,
                                                              our Registrar attempts to match you with someone of the same
                                                              pronoun preference and age range. If this applies to you, we
                                                              strongly suggest that you seek out your own roommate using
                                                              social media or your church community.</p>"></a>

                                    <div class="col-md-6">
                                        <select class="form-control" id="{{ $camper->id }}-pronounid"
                                                name="{{ $camper->id }}-pronounid">
                                            <option value="0">Choose a pronoun</option>
                                            @foreach($pronouns as $pronoun)
                                                <option value="{{ $pronoun->id }}"
                                                        {{ $pronoun->id == old($camper->id . '-pronounid', $camper->pronounid) ? ' selected' : '' }}>
                                                    {{ $pronoun->name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has($camper->id . '-pronounid'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first($camper->id . '-pronounid') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has($camper->id . '-firstname') ? ' has-error' : '' }}">
                                    <label for="{{ $camper->id }}-firstname" class="col-md-4 control-label">First
                                        Name</label>
                                    <div class="col-md-6">
                                        <input id="{{ $camper->id }}-firstname" class="form-control campername"
                                               name="{{ $camper->id }}-firstname"
                                               value="{{ old($camper->id . '-firstname', $camper->firstname) }}"
                                               required>

                                        @if ($errors->has($camper->id . '-firstname'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first($camper->id . '-firstname') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has($camper->id . '-lastname') ? ' has-error' : '' }}">
                                    <label for="{{ $camper->id }}-lastname" class="col-md-4 control-label">Last
                                        Name</label>
                                    <div class="col-md-6">
                                        <input id="{{ $camper->id }}-lastname" class="form-control campername"
                                               name="{{ $camper->id }}-lastname"
                                               value="{{ old($camper->id . '-lastname', $camper->lastname) }}"
                                               required>

                                        @if ($errors->has($camper->id . '-lastname'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first($camper->id . '-lastname') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has($camper->id . '-email') ? ' has-error' : '' }}">
                                    <label for="{{ $camper->id }}-email" class="col-md-4 control-label">Email</label>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <input id="{{ $camper->id }}-email" class="form-control"
                                                   name="{{ $camper->id }}-email"
                                                   value="{{ old($camper->id . '-email', $camper->email) }}"
                                                   aria-describedby="{{ $camper->id }}-email-addon">
                                            <span class="input-group-addon" id="{{ $camper->id }}-email-addon">@</span>
                                        </div>
                                        @if($camper->logged_in)
                                            <span class="label label-warning">Changing this value will also change your
                                                muusa.org login.
                                            </span>
                                        @endif
                                        @if ($errors->has($camper->id . '-email'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first($camper->id . '-email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has($camper->id . '-phonenbr') ? ' has-error' : '' }}">
                                    <label for="{{ $camper->id }}-phonenbr" class="col-md-4 control-label">Phone
                                        Number</label>
                                    <div class="col-md-6">
                                        <input id="{{ $camper->id }}-phonenbr" class="form-control phonemask"
                                               name="{{ $camper->id }}-phonenbr" data-mask="999-999-9999"
                                               value="{{ old($camper->id . '-phonenbr', $camper->formatted_phone) }}">

                                        @if ($errors->has($camper->id . '-phonenbr'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first($camper->id . '-phonenbr') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has($camper->id . '-birthdate') ? ' has-error' : '' }}">
                                    <label for="{{ $camper->id }}-birthdate"
                                           class="col-md-4 control-label">Birthdate</label>
                                    <div class="col-md-6">
                                        <div class="input-group date" data-provide="datepicker"
                                             data-date-format="yyyy-mm-dd" data-date-autoclose="true">
                                            <input id="{{ $camper->id }}-birthdate" type="text" class="form-control"
                                                   name="{{ $camper->id }}-birthdate"
                                                   value="{{ old($camper->id . '-birthdate', $camper->birthdate) }}"
                                                   required>
                                            <div class="input-group-addon">
                                                <span class="fa fa-calendar"></span>
                                            </div>
                                        </div>
                                        @if ($errors->has($camper->id . '-birthdate'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first($camper->id . '-birthdate') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has($camper->id . '-gradeoffset') ? ' has-error' : '' }}">
                                    <label for="{{ $camper->id }}-gradeoffset" class="col-md-4 control-label">Grade
                                        Entering in Fall {{ $year->year }}</label>
                                    <div class="col-md-6">
                                        <select class="form-control" id="{{ $camper->id }}-gradeoffset"
                                                name="{{ $camper->id }}-gradeoffset">
                                            <option value="13">Not Applicable</option>
                                            <option value="0">Kindergarten or earlier</option>
                                            @for($i=1; $i<13; $i++)
                                                <option value="{{ $i }}"
                                                        {{ $i == old($camper->grade . '-grade', $camper->grade) ? ' selected' : '' }}>
                                                    @if($i == 1)
                                                        1st
                                                    @elseif($i == 2)
                                                        2nd
                                                    @elseif($i == 3)
                                                        3rd
                                                    @else
                                                        {{ $i }}th
                                                    @endif
                                                </option>
                                            @endfor
                                        </select>

                                        @if ($errors->has($camper->id . '-gradeoffset'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first($camper->id . '-gradeoffset') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has($camper->id . '-roommate') ? ' has-error' : '' }}">
                                    <label for="{{ $camper->id }}-roommate" class="col-md-4 control-label">Roommate
                                        Preference</label>
                                    <a href="#" class="fa fa-info" data-toggle="tooltip"   data-placement="left"
                                       data-html="true"  
                                       title="<p>There is no need to add family members to this field; we assume that
                                       you would like to room with them unless contacted with another request.</p>"></a>

                                    <div class="col-md-6">
                                        <input id="{{ $camper->id }}-roommate" type="text" class="form-control"
                                               name="{{ $camper->id }}-roommate"
                                               value="{{ old($camper->id . '-roommate', $camper->roommate) }}"
                                               placeholder="First and last name of the camper who has agreed to be your roommate.">

                                        @if ($errors->has($camper->id . '-roommate'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first($camper->id . '-roommate') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has($camper->id . '-sponsor') ? ' has-error' : '' }}">
                                    <label for="{{ $camper->id }}-sponsor"
                                           class="col-md-4 control-label">Sponsor (if necessary)</label>
                                    <a href="#" class="fa fa-info" data-toggle="tooltip"   data-placement="left"
                                       data-html="true"  
                                       title="<strong>When is a sponsor required?</strong> 
                                       <p>A sponsor is required if the camper will be under the age  of 18 on the first
                                       day of camp and a parent or legal guardian is not attending for the entire length
                                       of time that the camper will be on YMCA property. A sponsor is asked to attend
                                       the informational meetings in the parents' stead, and if the camper is asked to
                                       leave for any reason, the sponsor will be required to assist the camper home.</p>
                                       <p>If you are having difficulty finding a sponsor, please let us know using the
                                       Contact Us form above. Oftentimes, we have adults in your area who are willing to
                                       volunteer, and may also be willing to offer transportation.</p>"></a>

                                    <div class="col-md-6">
                                        <input id="{{ $camper->id }}-sponsor" type="text" class="form-control"
                                               name="{{ $camper->id }}-sponsor"
                                               value="{{ old($camper->id . '-sponsor', $camper->sponsor) }}"
                                               placeholder="First and last name of the camper who has agreed to be your sponsor.">

                                        @if ($errors->has($camper->id . '-sponsor'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first($camper->id . '-sponsor') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has($camper->id . '-churchid') ? ' has-error' : '' }}">
                                    <label for="{{ $camper->id }}-churchid"
                                           class="col-md-4 control-label">Church Affiliation</label>

                                    <div class="col-md-6">
                                        <input id="{{ $camper->id }}-churchname" type="text"
                                               class="form-control churchlist" name="{{ $camper->id }}-churchname"
                                               value="{{ old($camper->id . '-churchname', $camper->church->name) }}"
                                               placeholder="Begin typing the name or city of your church.">
                                        <input id="{{ $camper->id }}-churchid" type="hidden"
                                               name="{{ $camper->id }}-churchid"
                                               value="{{ old($camper->id . '-churchid', $camper->churchid) }}">

                                        @if ($errors->has($camper->id . '-churchid'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first($camper->id . '-churchid') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has($camper->id . '-is_handicap') ? ' has-error' : '' }}">
                                    <label for="{{ $camper->id }}-is_handicap" class="col-md-8 control-label">Do you
                                        require a room accessible by the physically disabled?</label>
                                    <div class="col-md-2">
                                        <select class="form-control" id="{{ $camper->id }}-is_handicap"
                                                name="{{ $camper->id }}-is_handicap">
                                            <option value="0">No</option>
                                            <option value="1"{{ $camper->is_handicap == 1 ? ' selected' : '' }}>
                                                Yes
                                            </option>
                                        </select>

                                        @if ($errors->has($camper->id . '-is_handicap'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first($camper->id . '-is_handicap') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has($camper->id . '-foodoptionid') ? ' has-error' : '' }}">
                                    <label for="{{ $camper->id }}-foodoptionid" class="col-md-8 control-label">What
                                        option best describes your food restrictions?</label>
                                    <div class="col-md-2">
                                        <select class="form-control" id="{{ $camper->id }}-foodoptionid"
                                                name="{{ $camper->id }}-foodoptionid">
                                            @foreach($foodoptions as $foodoption)
                                                <option value="{{ $foodoption->id }}"
                                                        {{ $foodoption->id == old($camper->id . '-foodoptionid', $camper->foodoptionid) ? ' selected' : '' }}>
                                                    {{ $foodoption->name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has($camper->id . '-foodoptionid'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first($camper->id . '-foodoptionid') }}</strong>
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
    <script
            src="//code.jquery.com/ui/1.12.1/jquery-ui.min.js"
            integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
            crossorigin="anonymous"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js"></script>
    <script src="/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript">
        var camperCount = 100;

        $(function () {

            @if(count($errors))
                $('.nav-tabs a[href="#' + $("span.help-block").first().parents('div.tab-pane').attr('id') + '"]').trigger('click');
            @endif

            $('[data-toggle="tooltip"]').tooltip({
                content: function () {
                    return this.getAttribute("title");
                }
            });
            $('button#quickme').on('click', function (e) {
                e.preventDefault();
                $("select.days").val('6');
            })
            $('.next').click(function () {
                var next = $('.nav-tabs > .active').next('li').find('a');
                if (next.attr("id") != 'newcamper') {
                    next.trigger('click');
                    $('html,body').animate({
                        scrollTop: 0
                    }, 700);
                } else {
                    $('button[type="submit"]').trigger("focus");
                    $('html,body').animate({
                        scrollTop: 9999
                    }, 700);
                }
            });
            $('.campername').on('change', function () {
                var tab = $(this).parents('div.tab-pane');
                var name = tab.find("input.campername");
                if (name.length == 2) {
                    $('a[href="#' + tab.attr('id') + '"]').text(name[0].value + " " + name[1].value);
                }
            });
            $('.churchlist').autocomplete({
                source: "/data/churchlist",
                minLength: 3,
                select: function (event, ui) {
                    $(this).val(ui.item.name);
                    $(this).next("input").val(ui.item.id);
                    return false;
                }
            }).autocomplete('instance')._renderItem = function (ul, item) {
                return $("<li>")
                    .append("<div>" + item.name + " (" + item.city + ", " + item.statecd + ")</div>")
                    .appendTo(ul);
            };
            $('#0 select, #0 input').prop('disabled', true);
            $("#newcamper").on('click', function (e) {
                e.preventDefault();
                $(this).closest('li').before('<li role="presentation"><a href="#' + camperCount + '" aria-controls="' + camperCount + '" role="tab" data-toggle="tab">New Camper</a></li>');
                var emptycamper = $("#0");
                var empty = emptycamper.clone(true, true).attr("id", camperCount);
                empty.find("input, select").each(function () {
                    $(this).attr("id", $(this).attr("id").replace('0', camperCount));
                    $(this).attr("name", $(this).attr("name").replace('0', camperCount));
                    $(this).prop('disabled', false);
                });
                emptycamper.before(empty);
                $('.nav-tabs a[href="#' + camperCount++ + '"]').trigger('click');
            });
            @if(isset($readonly) && $readonly === true)
                $("input:not(#camper), select").prop("disabled", "true");
            @endif
        })
        ;
    </script>
@endsection