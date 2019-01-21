<div role="tabpanel" class="tab-pane fade{{ $looper == 0 ? ' active show' : '' }}"
     aria-expanded="{{ $looper == 0 ? 'true' : 'false' }}" id="tab-{{ $camper->id }}">
    <p>&nbsp;</p>
    <input type="hidden" id="id-{{ $looper }}" name="id[]" value="{{ $camper->id }}"/>
    <div class="form-group row{{ $errors->has('days.' . $looper) ? ' has-danger' : '' }}">
        <label for="days-{{ $looper }}" class="col-md-4 control-label">
            @if($readonly === false)
                <button id="quickme" class="float-right" data-toggle="tooltip" title="@lang('messages.quickcopy')">
                    <i class="far fa-copy"></i></button>
            @else
                <a href="#" class="p-2 float-right" data-toggle="tooltip" data-html="true"
                   title="@lang('messages.attending')"><i class="far fa-info"></i></a>
            @endif
            Attending in {{ $year->year }}?
        </label>

        <div class="col-md-6">
            @if(isset($readonly))
                <select class="form-control days{{ $errors->has('days.' . $looper) ? ' is-invalid' : '' }}"
                        id="days-{{ $looper }}" name="days[]">
                    @for($i=6; $i>0; $i--)
                        <option value="{{ $i }}"
                                {{ $i == old('days.' . $looper, $camper->currentdays) ? ' selected' : '' }}>
                            {{ $i }} nights
                        </option>
                    @endfor
                    <option value="0"{{ $camper->currentdays == 0 ? ' selected' : '' }}>
                        Not Attending
                    </option>
                </select>
            @else
                <select class="form-control days{{ $errors->has('days.' . $looper) ? ' is-invalid' : '' }}"
                        id="days-{{ $looper }}" name="days[]">
                    <option value="{{ $camper->currentdays > 0 ? $camper->currentdays : '6' }}">
                        Yes
                    </option>
                    <option value="0"{{ $camper->currentdays <= 0 ? ' selected' : '' }}>
                        No
                    </option>
                </select>
            @endif

            @if ($errors->has('days.' . $looper))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('days.' . $looper) }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group row{{ $errors->has('pronounid.' . $looper) ? ' has-danger' : '' }}">
        <label for="pronounid-{{ $looper }}" class="col-md-4 control-label">
            <a href="#" class="p-2 float-right" data-toggle="tooltip" data-html="true"
               title="@lang('messages.pronoun')"><i class="far fa-info"></i></a>
            Gender Pronoun(s)
        </label>

        <div class="col-md-6">
            <select class="form-control{{ $errors->has('pronounid.' . $looper) ? ' is-invalid' : '' }}"
                    id="pronounid-{{ $looper }}" name="pronounid[]">
                <option value="0">Choose pronoun(s)</option>
                @foreach($pronouns as $pronoun)
                    <option value="{{ $pronoun->id }}"
                            {{ $pronoun->id == old('pronounid.' . $looper, $camper->pronounid) ? ' selected' : '' }}>
                        {{ $pronoun->name }}
                    </option>
                @endforeach
            </select>

            @if ($errors->has('pronounid.' . $looper))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('pronounid.' . $looper) }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group row{{ $errors->has('firstname.' . $looper) ? ' has-danger' : '' }}">
        <label for="firstname-{{ $looper }}" class="col-md-4 control-label">First
            Name</label>
        <div class="col-md-6">
            <input id="firstname-{{ $looper }}"
                   class="form-control{{ $errors->has('firstname.' . $looper) ? ' is-invalid' : '' }}"
                   name="firstname[]" value="{{ old('firstname.' . $looper, $camper->firstname) }}">

            @if ($errors->has('firstname.' . $looper))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('firstname.' . $looper) }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group row{{ $errors->has('lastname.' . $looper) ? ' has-danger' : '' }}">
        <label for="lastname-{{ $looper }}" class="col-md-4 control-label">Last
            Name</label>
        <div class="col-md-6">
            <input id="lastname-{{ $looper }}"
                   class="form-control{{ $errors->has('lastname.' . $looper) ? ' is-invalid' : '' }}"
                   name="lastname[]" value="{{ old('lastname.' . $looper, $camper->lastname) }}">

            @if ($errors->has('lastname.' . $looper))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('lastname.' . $looper) }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group row{{ $errors->has('email.' . $looper) ? ' has-danger' : '' }}">
        <label for="email-{{ $looper }}" class="col-md-4 control-label">Email</label>
        <div class="col-md-6">
            <div class="input-group">
                <input id="email-{{ $looper }}"
                       class="form-control{{ $errors->has('email.' . $looper) ? ' is-invalid' : '' }}"
                       name="email[]" value="{{ old('email.' . $looper, $camper->email) }}"
                       aria-describedby="email-addon-{{ $looper }}">
                <div class="input-group-append"><span class="input-group-text">@</span></div>
            </div>
            @if($camper->email == Auth::user()->email)
                <span class="alert alert-warning p-0 m-0">
                    Changing this value will also change your muusa.org login.
                </span>
            @endif
            @if ($errors->has('email.' . $looper))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('email.' . $looper) }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group row{{ $errors->has('phonenbr.' . $looper) ? ' has-danger' : '' }}">
        <label for="phonenbr-{{ $looper }}" class="col-md-4 control-label">Phone
            Number</label>
        <div class="col-md-6">
            <div class="input-group">
                <input id="phonenbr-{{ $looper }}" name="phonenbr[]"
                       class="form-control{{ $errors->has('phonenbr.' . $looper) ? ' is-invalid' : '' }}"
                       value="{{ old('phonenbr.' . $looper, $camper->phone) }}">
                <div class="input-group-append"><span class="input-group-text"><i class="fas fa-phone"></i></span></div>
            </div>

            @if ($errors->has('phonenbr.' . $looper))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('phonenbr.' . $looper) }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group row{{ $errors->has('birthdate.' . $looper) ? ' has-danger' : '' }}">
        <label for="birthdate-{{ $looper }}" class="col-md-4 control-label">Birthdate
            (yyyy-mm-dd)</label>
        <div class="col-md-6">
            <div class="input-group date" data-provide="datepicker"
                 data-date-format="yyyy-mm-dd" data-date-start-view="decades" data-date-autoclose="true">
                <input id="birthdate-{{ $looper }}" type="text" class="form-control" name="birthdate[]"
                       value="{{ old('birthdate.' . $looper, $camper->birthdate) }}">
                <div class="input-group-append">
                    <span class="input-group-text"><i class="far fa-calendar"></i></span>
                </div>
                <div class="input-group-addon">
                </div>
            </div>
            @if ($errors->has('birthdate.' . $looper))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('birthdate.' . $looper) }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group row{{ $errors->has('programid.' . $looper) ? ' has-danger' : '' }}">
        <label for="programid-{{ $looper }}" class="col-md-4 control-label">
            Program
        </label>

        <div class="col-md-6">
            <select class="form-control select-program{{ $errors->has('programid.' . $looper) ? ' is-invalid' : '' }}"
                    id="programid-{{ $looper }}" name="programid[]">
                <option value="0">Choose a program</option>
                @foreach($programs as $program)
                    <option value="{{ $program->id }}"
                            {{ $program->id == old('programid.' . $looper,  $camper->lastprogramid) ? ' selected' : '' }}>
                        {{ str_replace("YEAR", $year->year, $program->display) }}
                    </option>
                @endforeach
            </select>
            <span class="alert alert-warning p-0 m-0 d-none">
                    Changing this value will only save if the camper is attending this year.
            </span>

            @if ($errors->has('programid.' . $looper))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('programid.' . $looper) }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group row{{ $errors->has('roommate.' . $looper) ? ' has-danger' : '' }}">
        <label for="roommate-{{ $looper }}" class="col-md-4 control-label">
            <a href="#" class="p-2 float-right" data-toggle="tooltip" data-html="true"
               title="@lang('messages.roommate')"><i class="far fa-info"></i></a>
            Roommate Preference
        </label>

        <div class="col-md-6">
            <input id="roommate-{{ $looper }}" type="text"
                   class="form-control {{ $errors->has('roommate.' . $looper) ? ' is-invalid' : '' }}"
                   name="roommate[]" autocomplete="off"
                   value="{{ old('roommate.' . $looper, $camper->roommate) }}"
                   placeholder="First and last name of the camper who has agreed to be your roommate."/>

            @if ($errors->has('roommate.' . $looper))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('roommate.' . $looper) }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group row{{ $errors->has('sponsor.' . $looper) ? ' has-danger' : '' }}">
        <label for="sponsor-{{ $looper }}" class="col-md-4 control-label">
            <a href="#" class="p-2 float-right" data-toggle="tooltip" data-html="true"
               title="@lang('messages.sponsor')"><i class="far fa-info"></i></a>
            Sponsor (if necessary)
        </label>

        <div class="col-md-6">
            <input id="sponsor-{{ $looper }}" type="text"
                   class="form-control {{ $errors->has('sponsor.' . $looper) ? ' is-invalid' : '' }}"
                   name="sponsor[]" autocomplete="off" value="{{ old('sponsor.' . $looper, $camper->sponsor) }}"
                   placeholder="First and last name of the camper who has agreed to be your sponsor.">

            @if ($errors->has('sponsor.' . $looper))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('sponsor.' . $looper) }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group row{{ $errors->has('churchid.' . $looper) ? ' has-danger' : '' }}">
        <label for="churchid-{{ $looper }}" class="col-md-4 control-label">Church Affiliation</label>
        <div class="col-md-6">
            <select id="churchid-{{ $looper }}" name="churchid[]"
                    class="form-control churchlist{{ $errors->has('churchid.' . $looper) ? ' is-invalid' : '' }}">
                @if(isset($camper->churchid))
                    <option value="{{ old('churchid.' . $looper, $camper->churchid) }}" selected="selected">
                        {{ $camper->churchname }} ({{ $camper->churchcity }}, {{ $camper->churchstate }})
                    </option>
                @endif
            </select>

            @if ($errors->has('churchid.' . $looper))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('churchid.' . $looper) }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group row{{ $errors->has('is_handicap.' . $looper) ? ' has-danger' : '' }}">
        <label for="is_handicap-{{ $looper }}" class="col-md-8 control-label">Do you require assistance or any
            needs of which the Registrar should be aware?
            <a href="#" class="p-2 float-right" data-toggle="tooltip" data-html="true"
               title="@lang('messages.specialneeds')"><i class="far fa-info"></i></a>
        </label>
        <div class="col-md-2">
            <select class="form-control{{ $errors->has('is_handicap.' . $looper) ? ' is-invalid' : '' }}"
                    id="is_handicap-{{ $looper }}" name="is_handicap[]">
                <option value="0">No</option>
                <option value="1"{{ $camper->is_handicap == 1 ? ' selected' : '' }}>
                    Yes
                </option>
            </select>

            @if ($errors->has('is_handicap.' . $looper))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('is_handicap.' . $looper) }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group row{{ $errors->has('foodoptionid.' . $looper) ? ' has-danger' : '' }}">
        <label for="foodoptionid-{{ $looper }}" class="col-md-8 control-label">What
            option best describes your food restrictions?</label>
        <div class="col-md-2">
            <select class="form-control{{ $errors->has('foodoptionid.' . $looper) ? ' is-invalid' : '' }}"
                    id="foodoptionid-{{ $looper }}" name="foodoptionid[]">
                @foreach($foodoptions as $foodoption)
                    <option value="{{ $foodoption->id }}"
                            {{ $foodoption->id == old('foodoptionid.' . $looper, $camper->foodoptionid) ? ' selected' : '' }}>
                        {{ $foodoption->name }}
                    </option>
                @endforeach
            </select>

            @if ($errors->has('foodoptionid.' . $looper))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('foodoptionid.' . $looper) }}</strong>
                </span>
            @endif
        </div>
    </div>
    @include('snippet.formgroup', ['type' => 'next', 'label' => '', 'attribs' => ['name' => 'Next Camper']])
</div>