<div role="tabpanel" class="tab-pane fade{{ $looper->first ? ' in active' : '' }}" id="{{ $camper->id }}">
    <p>&nbsp;</p>
    <input type="hidden" id="id-{{ $looper->index }}" name="id[]" value="{{ $camper->id }}"/>
    <div class="form-group{{ $errors->has('days.' . $looper->index) ? ' has-error' : '' }}">
        <label for="days-{{ $looper->index }}" class="col-md-4 control-label">Attending
            in {{ $year->year }}?</label>
        <a href="#" class="fa fa-info" data-toggle="tooltip" data-html="true"  
           title="<p>Use this dropdown to tell us if a family member is not attending
                    MUUSA this year.</p><p>If this family member will be registering separately,
                    please use the Contact Us form and we will split them off to their own
                    registration form.</p>"></a>

        <div class="col-md-6">
            @if(isset($readonly))
                <select class="form-control days" id="days-{{ $looper->index }}" name="days[]">
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
                @if($readonly === false)
                    <button id="quickme" class="pull-right fa fa-bolt" data-toggle="tooltip"
                            title="Mark everyone as attending 6 nights"></button>
                @endif
            @else
                <select class="form-control" id="days-{{ $looper->index }}" name="days[]">
                    <option value="{{ isset($camper->yearattending) && $camper->yearattending->days > 0 ? $camper->yearattending->days : '6' }}">
                        Yes
                    </option>
                    <option value="0"{{ !isset($camper->yearattending) ? ' selected' : '' }}>
                        No
                    </option>
                </select>
            @endif

            @if ($errors->has('days.' . $looper->index))
                <span class="help-block">
                    <strong>{{ $errors->first('days.' . $looper->index) }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group{{ $errors->has('pronounid.' . $looper->index) ? ' has-error' : '' }}">
        <label for="pronounid-{{ $looper->index }}" class="col-md-4 control-label">Pronoun Preference</label>
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
            <select class="form-control" id="pronounid-{{ $looper->index }}"
                    name="pronounid[]">
                <option value="0">Choose a pronoun</option>
                @foreach($pronouns as $pronoun)
                    <option value="{{ $pronoun->id }}"
                            {{ $pronoun->id == old('pronounid.' . $looper->index, $camper->pronounid) ? ' selected' : '' }}>
                        {{ $pronoun->name }}
                    </option>
                @endforeach
            </select>

            @if ($errors->has('pronounid.' . $looper->index))
                <span class="help-block">
                    <strong>{{ $errors->first('pronounid.' . $looper->index) }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group{{ $errors->has('firstname.' . $looper->index) ? ' has-error' : '' }}">
        <label for="firstname-{{ $looper->index }}" class="col-md-4 control-label">First
            Name</label>
        <div class="col-md-6">
            <input id="firstname-{{ $looper->index }}" class="form-control campername" name="firstname[]"
                   value="{{ old('firstname.' . $looper->index, $camper->firstname) }}">

            @if ($errors->has('firstname.' . $looper->index))
                <span class="help-block">
                    <strong>{{ $errors->first('firstname.' . $looper->index) }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group{{ $errors->has('lastname.' . $looper->index) ? ' has-error' : '' }}">
        <label for="lastname-{{ $looper->index }}" class="col-md-4 control-label">Last
            Name</label>
        <div class="col-md-6">
            <input id="lastname-{{ $looper->index }}" class="form-control campername" name="lastname[]"
                   value="{{ old('lastname.' . $looper->index, $camper->lastname) }}">

            @if ($errors->has('lastname.' . $looper->index))
                <span class="help-block">
                    <strong>{{ $errors->first('lastname.' . $looper->index) }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group{{ $errors->has('email.' . $looper->index) ? ' has-error' : '' }}">
        <label for="email-{{ $looper->index }}" class="col-md-4 control-label">Email</label>
        <div class="col-md-6">
            <div class="input-group">
                <input id="email-{{ $looper->index }}" class="form-control" name="email[]"
                       value="{{ old('email.' . $looper->index, $camper->email) }}"
                       aria-describedby="email-addon-{{ $looper->index }}">
                <span class="input-group-addon" id="email-addon-{{ $looper->index }}">@</span>
            </div>
            @if($camper->logged_in)
                <span class="label label-warning">
                    Changing this value will also change your muusa.org login.
                </span>
            @endif
            @if ($errors->has('email.' . $looper->index))
                <span class="help-block">
                    <strong>{{ $errors->first('email.' . $looper->index) }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group{{ $errors->has('phonenbr.' . $looper->index) ? ' has-error' : '' }}">
        <label for="phonenbr-{{ $looper->index }}" class="col-md-4 control-label">Phone
            Number</label>
        <div class="col-md-6">
            <input id="phonenbr-{{ $looper->index }}" class="form-control phonemask"
                   name="phonenbr[]" data-mask="999-999-9999"
                   value="{{ old('phonenbr.' . $looper->index, $camper->formatted_phone) }}">

            @if ($errors->has('phonenbr.' . $looper->index))
                <span class="help-block">
                    <strong>{{ $errors->first('phonenbr.' . $looper->index) }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group{{ $errors->has('birthdate.' . $looper->index) ? ' has-error' : '' }}">
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
                <span class="help-block">
                    <strong>{{ $errors->first('birthdate.' . $looper->index) }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group{{ $errors->has('gradeoffset.' . $looper->index) ? ' has-error' : '' }}">
        <label for="gradeoffset-{{ $looper->index }}" class="col-md-4 control-label">Grade
            Entering in Fall {{ $year->year }}</label>
        <div class="col-md-6">
            <select class="form-control" id="gradeoffset-{{ $looper->index }}" name="gradeoffset[]">
                <option value="13">Not Applicable</option>
                <option value="0">Kindergarten or earlier</option>
                @for($i=1; $i<13; $i++)
                    <option value="{{ $i }}"
                            {{ $i == old('grade.' . $looper->index, $camper->grade) ? ' selected' : '' }}>
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

            @if ($errors->has('gradeoffset.' . $looper->index))
                <span class="help-block">
                    <strong>{{ $errors->first('gradeoffset.' . $looper->index) }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group{{ $errors->has('roommate.' . $looper->index) ? ' has-error' : '' }}">
        <label for="roommate-{{ $looper->index }}" class="col-md-4 control-label">Roommate Preference</label>
        <a href="#" class="fa fa-info" data-toggle="tooltip"   data-placement="left" data-html="true"  
           title="<p>There is no need to add family members to this field; we assume that
                   you would like to room with them unless contacted with another request.</p>"></a>

        <div class="col-md-6">
            <input id="roommate-{{ $looper->index }}" type="text"
                   class="form-control easycamper" name="roommate[]" autocomplete="off"
                   value="{{ old('roommate.' . $looper->index, $camper->roommate) }}"
                   placeholder="First and last name of the camper who has agreed to be your roommate.">

            @if ($errors->has('roommate.' . $looper->index))
                <span class="help-block">
                    <strong>{{ $errors->first('roommate.' . $looper->index) }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group{{ $errors->has('sponsor.' . $looper->index) ? ' has-error' : '' }}">
        <label for="sponsor-{{ $looper->index }}" class="col-md-4 control-label">Sponsor (if
            necessary)</label>
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
            <input id="sponsor-{{ $looper->index }}" type="text" class="form-control easycamper"
                   name="sponsor[]" autocomplete="off" value="{{ old('sponsor.' . $looper->index, $camper->sponsor) }}"
                   placeholder="First and last name of the camper who has agreed to be your sponsor.">

            @if ($errors->has('sponsor.' . $looper->index))
                <span class="help-block">
                    <strong>{{ $errors->first('sponsor.' . $looper->index) }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group{{ $errors->has('churchid.' . $looper->index) ? ' has-error' : '' }}">
        <label for="churchid-{{ $looper->index }}" class="col-md-4 control-label">Church
            Affiliation</label>
        <div class="col-md-6">
            <input id="churchname-{{ $looper->index }}" type="text" class="form-control churchlist" name="churchname[]"
                   value="{{ old('churchname.' . $looper->index, $camper->church->name) }}"
                   placeholder="Begin typing the name or city of your church.">
            <input id="churchid-{{ $looper->index }}" type="hidden" name="churchid[]"
                   value="{{ old('churchid.' . $looper->index, $camper->churchid) }}">

            @if ($errors->has('churchid.' . $looper->index))
                <span class="help-block">
                    <strong>{{ $errors->first('churchid.' . $looper->index) }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group{{ $errors->has('is_handicap.' . $looper->index) ? ' has-error' : '' }}">
        <label for="is_handicap-{{ $looper->index }}" class="col-md-8 control-label">Do you
            require a room accessible by the physically disabled?</label>
        <div class="col-md-2">
            <select class="form-control" id="is_handicap-{{ $looper->index }}" name="is_handicap[]">
                <option value="0">No</option>
                <option value="1"{{ $camper->is_handicap == 1 ? ' selected' : '' }}>
                    Yes
                </option>
            </select>

            @if ($errors->has('is_handicap.' . $looper->index))
                <span class="help-block">
                    <strong>{{ $errors->first('is_handicap.' . $looper->index) }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group{{ $errors->has('foodoptionid.' . $looper->index) ? ' has-error' : '' }}">
        <label for="foodoptionid-{{ $looper->index }}" class="col-md-8 control-label">What
            option best describes your food restrictions?</label>
        <div class="col-md-2">
            <select class="form-control" id="foodoptionid-{{ $looper->index }}"
                    name="foodoptionid[]">
                @foreach($foodoptions as $foodoption)
                    <option value="{{ $foodoption->id }}"
                            {{ $foodoption->id == old('foodoptionid.' . $looper->index, $camper->foodoptionid) ? ' selected' : '' }}>
                        {{ $foodoption->name }}
                    </option>
                @endforeach
            </select>

            @if ($errors->has('foodoptionid.' . $looper->index))
                <span class="help-block">
                    <strong>{{ $errors->first('foodoptionid.' . $looper->index) }}</strong>
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