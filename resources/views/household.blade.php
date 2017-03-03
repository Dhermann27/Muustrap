@extends('layouts.app')

@section('content')
    <p>&nbsp;</p>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">Household Information</div>
            <div class="panel-body">
                <form id="payment" class="form-horizontal" role="form" method="POST" action="{{ url('/household') .
                (isset($readonly) && $readonly === false ? '/' . $family->id : '') }}">
                    {{ csrf_field() }}

                    @if(!empty($message))
                        <div class="alert alert-success">
                            {!! $message !!}
                        </div>
                    @endif

                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Family Name</label>
                        <a href="#" class="fa fa-info" data-toggle="tooltip" data-placement="bottom" data-html="true"  
                           title="<p><h4>What is a Family Name?</h4>
                            <p>Family Name is the display name for your family as a whole. It will appear on your
                            mailing label and be the only entry in the roster, alphabetized by the first letter of this
                            name.</p>
                            <p>Examples:</p>
                            <ul>
                                <li>Most people will choose their family's last name: &quot;Washington&quot;.</li>
                                <li>Families with different surnames might choose: &quot;Lincoln / Todd&quot;.</li>
                                <li>Please do not add &quot;The&quot; or make your family's name plural: &quot;The
                                Obamas&quot;.</li>
                             </ul>
                             <p>If you would like a separate entry in the roster for any member of your family, please
                             register them separately. There is no additional cost for this option."></a>

                        <div class="col-md-6">
                            <input id="name" class="form-control" name="name" value="{{ old('name', $family->name) }}"
                                   required>

                            @if ($errors->has('name'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('address1') ? ' has-error' : '' }}">
                        <label for="address1" class="col-md-4 control-label">Address Line #1</label>

                        <div class="col-md-6">
                            <input id="address1" class="form-control" name="address1"
                                   value="{{ old('address1', $family->address1) }}"
                                   required>

                            @if ($errors->has('address1'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('address1') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('address2') ? ' has-error' : '' }}">
                        <label for="address2" class="col-md-4 control-label">Address Line #2</label>

                        <div class="col-md-6">
                            <input id="address2" class="form-control" name="address2"
                                   value="{{ old('address2', $family->address2) }}">

                            @if ($errors->has('address2'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('address2') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                        <label for="city" class="col-md-4 control-label">City</label>

                        <div class="col-md-6">
                            <input id="city" class="form-control" name="city" value="{{ old('city', $family->city) }}"
                                   required>

                            @if ($errors->has('city'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('city') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('statecd') ? ' has-error' : '' }}">
                        <label for="statecd" class="col-md-4 control-label">State</label>

                        <div class="col-md-6">
                            <select id="statecd" name="statecd" class="form-control">
                                <option value="0">Please choose a state</option>
                                @foreach($statecodes as $code)
                                    <option value="{{ $code->code }}"{{ (old('statecd', $family->statecd) == $code->code) ? " selected" : "" }}>
                                        {{ $code->name }}
                                    </option>
                                @endforeach
                            </select>

                            @if ($errors->has('statecd'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('statecd') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('zipcd') ? ' has-error' : '' }}">
                        <label for="zipcd" class="col-md-4 control-label">Zip</label>

                        <div class="col-md-6">
                            <input id="zipcd" class="form-control" name="zipcd"
                                   value="{{ old('zipcd', $family->zipcd) }}"
                                   required maxlength="5">

                            @if ($errors->has('zipcd'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('zipcd') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
                        <label for="country" class="col-md-4 control-label">Country</label>

                        <div class="col-md-6">
                            <input id="country" class="form-control" name="country"
                                   value="{{ old('country', $family->country ? $family->country : 'USA') }}"
                                   required>

                            @if ($errors->has('country'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('country') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('is_ecomm') ? ' has-error' : '' }}">
                        <label for="is_ecomm" class="control-label col-md-8">Please indicate if you would like to
                            receive a paper brochure in the mail.</label>

                        <div class="col-md-2">
                            <select id="is_ecomm" name="is_ecomm" class="form-control">
                                <option value="1">No, do not mail me anything</option>
                                <option value="0"{{ old('is_ecomm', $family->is_ecomm) == '0' ? ' selected' : '' }}>Yes,
                                    please mail me a brochure
                                </option>
                            </select>
                            @if ($errors->has('is_ecomm'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('is_ecomm') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('is_scholar') ? ' has-error' : '' }}">
                        <label for="is_scholar" class="control-label col-md-8">Please indicate if you will be applying
                            for a
                            scholarship this year.</label>

                        <div class="col-md-2">
                            <select id="is_scholar" name="is_scholar" class="form-control">
                                <option value="0">No</option>
                                <option value="1"{{ old('is_scholar', $family->is_scholar) == '1' ? ' selected' : '' }}>
                                    Yes, I will be completing the separate process
                                </option>
                            </select>
                            @if ($errors->has('is_scholar'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('is_scholar') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    @if(!isset($readonly) || $readonly === false)
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    @if($family->id)
                                        Update Household
                                    @else
                                        Create Household
                                    @endif
                                </button>
                            </div>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        @if(isset($readonly) && $readonly === true)
                $("input:not(#camper), select").prop("disabled", "true");
        @endif

        $('[data-toggle="tooltip"]').tooltip({
            content: function () {
                return this.getAttribute("title");
            }
        });
    </script>
@endsection