@extends('layouts.appstrap')

@section('title')
    MUUSA Artists &amp; Crafters Show
@endsection

@section('heading')
    Submit your work for sale at our annual camp-wide art fair, benefitting both local artists like you and the MUUSA Scholarship Fund!
@endsection

@section('content')
    <div class="container">
        <p>Thank you for your interest in the MUUSA Artists &amp; Crafters Show! Please complete the
            following application and materials and send to the Show Coordinator, Geeta Palumbo, by
            April 1st. Replies will be sent to all applicants by May 1st.</p>
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
            <form id="artfair" class="form-horizontal" role="form" method="POST" action="{{ url('/artfair') }}"
                  enctype="multipart/form-data">
                @include('snippet.flash')

                @include('snippet.address', ['camper' => $camper])

                @if($camper->room_number != '')
                    @include('snippet.formgroup', ['type' => 'info', 'label' => 'Your Name',
                    'attribs' => ['name' => 'yourname'], 'default' => $camper->buildingname . ' ' . $camper->room_number])
                @endif

                @include('snippet.formgroup', ['type' => 'text', 'label' => 'Description of Work(s)',
                    'attribs' => ['name' => 'message']])

                @include('snippet.formgroup', ['label' => 'Approximate Price Range', 'attribs' => ['name' => 'pricerange']])

                <div class="form-group row{{ $errors->has('images') ? ' has-danger' : '' }}">
                    <label for="images" class="col-md-4 control-label">High-quality Images of Your
                        Work(s)</label>

                    <div class="col-md-6">
                        <input type="file" name="images[]" multiple/>

                        @if ($errors->has('images'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('images') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                @include('snippet.formgroup', ['type' => 'text', 'label' => 'Presentation Requests: do you
                        need a full length (8 foot long, but narrow) table or would 1/2 a table work? Please
                        describe your display needs.',
                    'attribs' => ['name' => 'table']])


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
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('timeslots') }}</strong>
                        </span>
                    @endif
                </div>
                <p>&nbsp;</p>

                @include('snippet.formgroup', ['type' => 'captcha', 'label' => 'CAPTCHA Test',
                    'attribs' => ['name' => 'g-recaptcha-response']])

                @include('snippet.formgroup', ['type' => 'submit', 'label' => '', 'attribs' => ['name' => 'Send Application']])
            </form>
        @else
            <h3>Please register for camp (and login to your account) to complete this application.</h3>
        @endif
    </div>
@endsection

@section('script')
    {!! NoCaptcha::renderJs() !!}
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