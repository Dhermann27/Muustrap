@inject('home', 'App\Http\Controllers\HomeController')

<div role="tabpanel" class="tab-pane fade{{ $looper->first && $camper->id != '0' ? ' active show' : '' }}"
     aria-expanded="{{ $loop->first && $camper->id != '0' ? 'true' : 'false' }}" id="{{ $camper->id }}">
    <p>&nbsp;</p>
    <input type="hidden" id="id-{{ $looper->index }}" name="id[]" value="{{ $camper->id }}"/>
    <div class="form-group row{{ $errors->has('days.' . $looper->index) ? ' has-danger' : '' }}">
        <label for="days-{{ $looper->index }}" class="col-md-4 control-label">
            @if($readonly === false)
                <button id="quickme" class="float-right" data-toggle="tooltip" title="@lang('messages.quickcopy')">
                    <i class="fa fa-copy"></i></button>
            @else
                <a href="#" class="p-2 float-right" data-toggle="tooltip"  data-html="true"
                   title="@lang('messages.attending')"><i class="fa fa-info"></i></a>
            @endif
            Attending in {{ $home->year()->year }}?
        </label>

        <div class="col-md-6">
            @if(isset($readonly))
                <select class="form-control days{{ $errors->has('days.' . $looper->index) ? ' is-invalid' : '' }}"
                        id="days-{{ $looper->index }}" name="days[]">
                    @for($i=7; $i>0; $i--)
                        <option value="{{ $i }}"
                                {{ $i == old('days.' . $looper->index, isset($camper->yearattending) ? $camper->yearattending->days : null) ? ' selected' : '' }}>
                            {{ $i }} nights
                        </option>
                    @endfor
                    <option value="0"{{ !isset($camper->yearattending) ? ' selected' : '' }}>
                        Not Attending
                    </option>
                </select>
            @else
                <select class="form-control days{{ $errors->has('days.' . $looper->index) ? ' is-invalid' : '' }}"
                        id="days-{{ $looper->index }}" name="days[]">
                    <option value="{{ isset($camper->yearattending) && $camper->yearattending->days > 0 ? $camper->yearattending->days : '6' }}">
                        Yes
                    </option>
                    <option value="0"{{ !isset($camper->yearattending) ? ' selected' : '' }}>
                        No
                    </option>
                </select>
            @endif

            @if ($errors->has('days.' . $looper->index))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('days.' . $looper->index) }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group row{{ $errors->has('pronounid.' . $looper->index) ? ' has-danger' : '' }}">
        <label for="pronounid-{{ $looper->index }}" class="col-md-4 control-label">
            <a href="#" class="p-2 float-right" data-toggle="tooltip"  data-html="true"
               title="@lang('messages.pronoun')"><i class="fa fa-info"></i></a>
            Gender Pronoun(s)
        </label>

        <div class="col-md-6">
            <select class="form-control{{ $errors->has('pronounid.' . $looper->index) ? ' is-invalid' : '' }}"
                    id="pronounid-{{ $looper->index }}" name="pronounid[]">
                <option value="0">Choose pronoun(s)</option>
                @foreach($pronouns as $pronoun)
                    <option value="{{ $pronoun->id }}"
                            {{ $pronoun->id == old('pronounid.' . $looper->index, $camper->pronounid) ? ' selected' : '' }}>
                        {{ $pronoun->name }}
                    </option>
                @endforeach
            </select>

            @if ($errors->has('pronounid.' . $looper->index))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('pronounid.' . $looper->index) }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group row{{ $errors->has('firstname.' . $looper->index) ? ' has-danger' : '' }}">
        <label for="firstname-{{ $looper->index }}" class="col-md-4 control-label">First
            Name</label>
        <div class="col-md-6">
            <input id="firstname-{{ $looper->index }}"
                   class="form-control campername{{ $errors->has('firstname.' . $looper->index) ? ' is-invalid' : '' }}"
                   name="firstname[]" value="{{ old('firstname.' . $looper->index, $camper->firstname) }}">

            @if ($errors->has('firstname.' . $looper->index))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('firstname.' . $looper->index) }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group row{{ $errors->has('lastname.' . $looper->index) ? ' has-danger' : '' }}">
        <label for="lastname-{{ $looper->index }}" class="col-md-4 control-label">Last
            Name</label>
        <div class="col-md-6">
            <input id="lastname-{{ $looper->index }}"
                   class="form-control campername{{ $errors->has('lastname.' . $looper->index) ? ' is-invalid' : '' }}"
                   name="lastname[]" value="{{ old('lastname.' . $looper->index, $camper->lastname) }}">

            @if ($errors->has('lastname.' . $looper->index))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('lastname.' . $looper->index) }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group row{{ $errors->has('email.' . $looper->index) ? ' has-danger' : '' }}">
        <label for="email-{{ $looper->index }}" class="col-md-4 control-label">Email</label>
        <div class="col-md-6">
            <div class="input-group">
                <input id="email-{{ $looper->index }}"
                       class="form-control{{ $errors->has('email.' . $looper->index) ? ' is-invalid' : '' }}"
                       name="email[]" value="{{ old('email.' . $looper->index, $camper->email) }}"
                       aria-describedby="email-addon-{{ $looper->index }}">
                <span class="input-group-addon" id="email-addon-{{ $looper->index }}">@</span>
            </div>
            @if($camper->logged_in)
                <span class="alert alert-warning p-0 m-0">
                    Changing this value will also change your muusa.org login.
                </span>
            @endif
            @if ($errors->has('email.' . $looper->index))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('email.' . $looper->index) }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group row{{ $errors->has('phonenbr.' . $looper->index) ? ' has-danger' : '' }}">
        <label for="phonenbr-{{ $looper->index }}" class="col-md-4 control-label">Phone
            Number</label>
        <div class="col-md-6">
            <input id="phonenbr-{{ $looper->index }}"
                   class="form-control phonemask{{ $errors->has('phonenbr.' . $looper->index) ? ' is-invalid' : '' }}"
                   name="phonenbr[]" data-mask="999-999-9999"
                   value="{{ old('phonenbr.' . $looper->index, $camper->formatted_phone) }}">

            @if ($errors->has('phonenbr.' . $looper->index))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('phonenbr.' . $looper->index) }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group row{{ $errors->has('birthdate.' . $looper->index) ? ' has-danger' : '' }}">
        <label for="birthdate-{{ $looper->index }}" class="col-md-4 control-label">Birthdate
            (yyyy-mm-dd)</label>
        <div class="col-md-6">
            <div class="input-group date" data-provide="datepicker"
                 data-date-format="yyyy-mm-dd" data-date-autoclose="true">
                <input id="birthdate-{{ $looper->index }}" type="text" class="form-control" name="birthdate[]"
                       value="{{ old('birthdate.' . $looper->index, $camper->birthdate) }}">
                <div class="input-group-addon">
                    <span class="fa fa-calendar"></span>
                </div>
            </div>
            @if ($errors->has('birthdate.' . $looper->index))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('birthdate.' . $looper->index) }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group row{{ $errors->has('gradyear.' . $looper->index) ? ' has-danger' : '' }}">
        <label for="gradyear-{{ $looper->index }}" class="col-md-4 control-label">
            <a href="#" class="p-2 float-right" data-toggle="tooltip"  data-html="true"
               title="@lang('messages.gradyear')"><i class="fa fa-info"></i></a>
            High School Graduation Year
        </label>

        <div class="col-md-6">
            <select class="form-control{{ $errors->has('gradyear.' . $looper->index) ? ' is-invalid' : '' }}"
                    id="gradyear-{{ $looper->index }}" name="gradyear[]">
                @for($i=($home->year()->year+18); $i>=1901; $i--)
                    <option value="{{ $i }}"
                            {{ $i == old('gradyear.' . $looper->index, $camper->gradyear) ? ' selected' : '' }}>
                        {{ $i }}
                    </option>
                @endfor
            </select>

            @if ($errors->has('gradyear.' . $looper->index))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('gradyear.' . $looper->index) }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group row{{ $errors->has('roommate.' . $looper->index) ? ' has-danger' : '' }}">
        <label for="roommate-{{ $looper->index }}" class="col-md-4 control-label">
            <a href="#" class="p-2 float-right" data-toggle="tooltip"  data-html="true"
               title="@lang('messages.roommate')"><i class="fa fa-info"></i></a>
            Roommate Preference
        </label>

        <div class="col-md-6">
            <input id="roommate-{{ $looper->index }}" type="text"
                   class="form-control easycamper{{ $errors->has('roommate.' . $looper->index) ? ' is-invalid' : '' }}"
                   name="roommate[]" autocomplete="off"
                   value="{{ old('roommate.' . $looper->index, $camper->roommate) }}"
                   placeholder="First and last name of the camper who has agreed to be your roommate.">

            @if ($errors->has('roommate.' . $looper->index))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('roommate.' . $looper->index) }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group row{{ $errors->has('sponsor.' . $looper->index) ? ' has-danger' : '' }}">
        <label for="sponsor-{{ $looper->index }}" class="col-md-4 control-label">
            <a href="#" class="p-2 float-right" data-toggle="tooltip"  data-html="true"
               title="@lang('messages.sponsor')"><i class="fa fa-info"></i></a>
            Sponsor (if necessary)
        </label>

        <div class="col-md-6">
            <input id="sponsor-{{ $looper->index }}" type="text"
                   class="form-control easycamper{{ $errors->has('sponsor.' . $looper->index) ? ' is-invalid' : '' }}"
                   name="sponsor[]" autocomplete="off" value="{{ old('sponsor.' . $looper->index, $camper->sponsor) }}"
                   placeholder="First and last name of the camper who has agreed to be your sponsor.">

            @if ($errors->has('sponsor.' . $looper->index))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('sponsor.' . $looper->index) }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group row{{ $errors->has('churchid.' . $looper->index) ? ' has-danger' : '' }}">
        <label for="churchid-{{ $looper->index }}" class="col-md-4 control-label">Church
            Affiliation</label>
        <div class="col-md-6">
            <input id="churchname-{{ $looper->index }}" type="text"
                   class="form-control churchlist{{ $errors->has('churchid.' . $looper->index) ? ' is-invalid' : '' }}"
                   name="churchname[]" value="{{ old('churchname.' . $looper->index, $camper->church->name) }}"
                   placeholder="Begin typing the name or city of your church.">
            <input id="churchid-{{ $looper->index }}" type="hidden" name="churchid[]"
                   value="{{ old('churchid.' . $looper->index, $camper->churchid) }}">

            @if ($errors->has('churchid.' . $looper->index))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('churchid.' . $looper->index) }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group row{{ $errors->has('is_handicap.' . $looper->index) ? ' has-danger' : '' }}">
        <label for="is_handicap-{{ $looper->index }}" class="col-md-8 control-label">Do you
            require a room accessible by the physically disabled?</label>
        <div class="col-md-2">
            <select class="form-control{{ $errors->has('is_handicap.' . $looper->index) ? ' is-invalid' : '' }}"
                    id="is_handicap-{{ $looper->index }}" name="is_handicap[]">
                <option value="0">No</option>
                <option value="1"{{ $camper->is_handicap == 1 ? ' selected' : '' }}>
                    Yes
                </option>
            </select>

            @if ($errors->has('is_handicap.' . $looper->index))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('is_handicap.' . $looper->index) }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group row{{ $errors->has('foodoptionid.' . $looper->index) ? ' has-danger' : '' }}">
        <label for="foodoptionid-{{ $looper->index }}" class="col-md-8 control-label">What
            option best describes your food restrictions?</label>
        <div class="col-md-2">
            <select class="form-control{{ $errors->has('foodoptionid.' . $looper->index) ? ' is-invalid' : '' }}"
                    id="foodoptionid-{{ $looper->index }}" name="foodoptionid[]">
                @foreach($foodoptions as $foodoption)
                    <option value="{{ $foodoption->id }}"
                            {{ $foodoption->id == old('foodoptionid.' . $looper->index, $camper->foodoptionid) ? ' selected' : '' }}>
                        {{ $foodoption->name }}
                    </option>
                @endforeach
            </select>

            @if ($errors->has('foodoptionid.' . $looper->index))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('foodoptionid.' . $looper->index) }}</strong>
                </span>
            @endif
        </div>
    </div>
    @include('snippet.formgroup', ['type' => 'next', 'label' => '', 'attribs' => ['name' => 'Next Camper']])
</div>