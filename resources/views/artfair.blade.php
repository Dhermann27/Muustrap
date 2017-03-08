@extends('layouts.app')

@section('content')
    <p>&nbsp;</p>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">MUUSA Artists & Crafters Show</div>
                    <div class="panel-body">
                        @if (!empty($success))
                            <div class="alert alert-success">
                                {{ $success }}
                            </div>
                        @endif
                        <p>Thank you for your interest in the MUUSA Artists &amp; Crafters Show! Please complete the
                            following application and materials and send to the Show Coordinator, Karen Seymour-Ells, by
                            April 1st. Replies will be sent to all applicants by May 1st. Late applications received
                            after April 1st will not be accepted.</p>
                        <p><strong>Please note the following regarding the sale:</strong></p>
                        <ul>
                            <li>30% of the sale price will be donated to MUUSA.</li>
                            <li>All money will be collected by those working the sale and a check cut back to the artist
                                for their portion of the sales within 2 weeks.
                            </li>
                            <li>Each participant must volunteer for some aspect of the sale, please see opportunities
                                listed above.
                            </li>
                        </ul>
                        <p><strong>Each entry needs to include:</strong></p>
                        <ul>
                            <li>Multiple high-quality images of your work (use the attachment button below or provide
                                links in the description).
                            </li>
                            <li>A description of your process so we can confirm the handmade nature of the item.</li>
                            <li>The below application filled out and submitted by the due date.</li>
                        </ul>
                        @if(Auth::check() && !empty($camper))
                            <form id="artfair" class="form-horizontal" role="form" method="POST"
                                  action="{{ url('/artfair') }}" enctype="multipart/form-data">
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <label for="name" class="col-md-4 control-label">Your Name</label>

                                    <div class="col-md-6">
                                        <strong>{{ $camper->firstname }} {{ $camper->lastname }}</strong>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                    <div class="col-md-6">
                                        <strong>{{ $camper->email }}</strong>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="address1" class="col-md-4 control-label">Address #1</label>

                                    <div class="col-md-6">
                                        <strong>{{ $camper->address1 }}</strong>
                                    </div>
                                </div>

                                @if($camper->address2 != '')
                                    <div class="form-group">
                                        <label for="address2" class="col-md-4 control-label">Address #2</label>

                                        <div class="col-md-6">
                                            <strong>{{ $camper->address2 }}</strong>
                                        </div>
                                    </div>
                                @endif

                                <div class="form-group">
                                    <label for="city" class="col-md-4 control-label">City</label>

                                    <div class="col-md-6">
                                        <strong>{{ $camper->city }}</strong>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="statecd" class="col-md-4 control-label">State</label>

                                    <div class="col-md-6">
                                        <strong>{{ $camper->statecd }}</strong>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="zipcd" class="col-md-4 control-label">Zip Code</label>

                                    <div class="col-md-6">
                                        <strong>{{ $camper->zipcd }}</strong>
                                    </div>
                                </div>

                                @if($camper->phonenbr != '')
                                    <div class="form-group">
                                        <label for="address2" class="col-md-4 control-label">Phone Number</label>

                                        <div class="col-md-6">
                                            <strong>{{ $camper->formatted_phone }}</strong>
                                        </div>
                                    </div>
                                @endif

                                @if($camper->room_number != '')
                                    <div class="form-group">
                                        <label for="address2" class="col-md-4 control-label">Phone Number</label>

                                        <div class="col-md-6">
                                            <strong>{{ $camper->buildingname }} {{ $camper->room_number }}</strong>
                                        </div>
                                    </div>
                                @endif

                                <div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
                                    <label for="message" class="col-md-4 control-label">Description of Work(s)</label>

                                    <div class="col-md-6">
                                    <textarea id="message" class="form-control" name="message"
                                              required>{{ old('message') }}</textarea>

                                        @if ($errors->has('message'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('message') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('pricerange') ? ' has-error' : '' }}">
                                    <label for="pricerange" class="col-md-4 control-label">Approximate Price
                                        Range</label>

                                    <div class="col-md-6">
                                        <input id="pricerange" type="text" class="form-control"
                                               name="pricerange"
                                               value="{{ old('pricerange') }}">

                                        @if ($errors->has('pricerange'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('pricerange') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('images') ? ' has-error' : '' }}">
                                    <label for="images" class="col-md-4 control-label">High-quality Images of Your
                                        Work(s)</label>

                                    <div class="col-md-6">
                                        <input type="file" name="images[]" multiple/>

                                        @if ($errors->has('images'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('images') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('table') ? ' has-error' : '' }}">
                                    <label for="table" class="col-md-4 control-label">Presentation Requests: do you
                                        need a full length (8' long, but narrow) table or would 1/2 a table work? Please
                                        describe your display needs.</label>

                                    <div class="col-md-6">
                                    <textarea id="table" class="form-control" name="table"
                                              required>{{ old('table') }}</textarea>

                                        @if ($errors->has('table'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('table') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="list-group col-md-6">
                                    <h4>Volunteer Availability</h4>
                                    The show will be located in Sunnen Center (the main lodge) and open throughout the
                                    day on Wednesday into the evening hours. The official hours will not be set until
                                    total volunteers are known. We want to make sure everyone has time to enjoy the sale
                                    and attend other events.
                                </div>
                                <div class="list-group col-md-6">
                                    <h5>Please click on the 2 shifts you most prefer</h5>
                                    <div class="timelist">
                                        <button type="button" data-content="T-setup"
                                                class="list-group-item list-group-item-info disabled">
                                            Tuesday Afternoon: Setup (Required for all artists)
                                        </button>
                                        <button type="button" data-content="T-open" class="list-group-item">Tuesday
                                            Evening: Opening Reception
                                        </button>
                                        <button type="button" data-content="W-morning" class="list-group-item">Wednesday
                                            Morning
                                        </button>
                                        <button type="button" data-content="W-afternoon" class="list-group-item">
                                            Wednesday Afternoon
                                        </button>
                                        <button type="button" data-content="W-dinner" class="list-group-item">Wednesday
                                            Early Evening
                                        </button>
                                        <button type="button" data-content="W-teardown"
                                                class="list-group-item list-group-item-info disabled">
                                            Wednesday Evening: Tear Down (Required for all artists)
                                        </button>
                                    </div>
                                    <input type="hidden" id="timeslots" name="timeslots"/>

                                    @if ($errors->has('timeslots'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('timeslots') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                                    <div class="col-md-6 col-md-offset-4">
                                        {!! app('captcha')->display() !!}

                                        @if ($errors->has('g-recaptcha-response'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary">Send Application</button>
                                    </div>
                                </div>
                            </form>
                        @else
                            <h3>Please register for camp (and login to your account) to complete this application.</h3>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(".timelist button").on("click", function (e) {
            e.preventDefault();
            $(this).toggleClass("active");
        });
        $("#artfair").on("submit", function (e) {
            var ids = new Array();
            $("#artfair").find("button.active").each(function () {
                ids.push($(this).attr("data-content"));
            });
            $("#timeslots").val(ids.join(","));
            return true;
        });
    </script>
@endsection