@extends('layouts.app')
@if(Auth::guest())
    <div class="alert alert-info" role="alert">Due to the site upgrade, all campers will need to create a new
        account using their preferred email address. Historical information will be attached to the account
        automatically.
    </div>
@endif
@section('content')
    <div class="jumbotron">
        <h1>MUUSA</h1>
        <p>An annual intergenerational Unitarian Universalist retreat for
            fun, fellowship, and personal growth</p>
        <div class="row">
            <div class="col-md-4">
                <div>
                    <span class="fa fa-map-marker fa-4x"></span>
                </div>
                <h3>Located</h3>
                <p>at Trout Lodge in the YMCA of the Ozarks near Potosi,
                    Missouri</p>
            </div>
            <div class="col-md-4">
                <div>
                    <span class="fa fa-calendar fa-4x"></span>
                </div>
                <h3>Scheduled</h3>
                <p>Sunday, July 2nd through Saturday, July 8th 2017</p>
            </div>
            <div class="col-md-4">
                <div>
                    <span class="fa fa-fire fa-4x"></span>
                </div>
                <h3>All are welcome</h3>
                <p>regardless of age, race, ethnicity, gender, sexual
                    orientation, social class or ability</p>
            </div>
        </div>
    </div>
    @if(Auth::check() && $registered == '1')
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">You're registered!</h3>
                    </div>
                    @if ($paid == '0')
                        <div class="panel-body">
                            <div class="col-md-6 text-center">
                                Please pay your deposit by clicking on the <a href="{{ url('/payment') }}">payment</a>,
                                or
                                you will need to wait until your check is processed via mail.
                            </div>
                            @else
                                <div class="panel-body">
                                    <div class="col-md-4 text-center">
                                        <p>&nbsp;</p>
                                        <i class="fa fa-rocket fa-5x"></i><br/>
                                        <h4>Workshop Preferences</h4>
                                        <p>Sign up from a wide variety of entertaining and intriguing seminars,
                                            organized by our Adult Programming Committee.</p>
                                        <a class="booty" href="{{ url('/workshopchoice') }}">Add Choices <i
                                                    class="fa fa-arrow-right"></i>
                                        </a>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <p>&nbsp;</p>
                                        <i class="fa fa-bed fa-5x"></i><br/>
                                        <h4>Room Selection</h4>
                                        <p>Coming soon!</p>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <p>&nbsp;</p>
                                        <i class="fa fa-envelope-o fa-5x"></i><br/>
                                        <h4>Confirmation Letter</h4>
                                        <p>Coming soon!</p>
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                </div>
            </div>
            <div class="row">
                <div id="spacer0" class="col-md-12 parallax">
                </div>
            </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Get Registered for {{ $year->year }}</h3>
                        </div>
                        @if (Auth::guest())
                            <div class="panel-body">
                                <div class="col-md-6 text-center">
                                    <a class="booty" href="{{ url('/login') }}">Login</a></div>
                                <div class="col-md-6">
                                    <a class="booty" href="{{ url('/register') }}">Create Account</a></div>
                            </div>
                        @else
                            <div class="panel-body">
                                <div class="col-md-4 text-center bs-callout bs-callout-{{ $updatedFamily == '1' ? 'success' : 'warning' }}">
                                    <p>&nbsp;</p>
                                    <i class="fa fa-home fa-5x"></i><br/>
                                    <h4>Household Information</h4>
                                    <p>Go to this page to update your address and other mailing information.</p>
                                    <a class="booty" href="{{ url('/household') }}">Update Household <i
                                                class="fa fa-arrow-right"></i>
                                    </a>
                                </div>
                                <div class="col-md-4 text-center bs-callout bs-callout-{{ $updatedCamper == '1' ? 'success' : 'warning' }}">
                                    <p>&nbsp;</p>
                                    <i class="fa fa-group fa-5x"></i><br/>
                                    <h4>Camper Listing</h4>
                                    <p>This page can help you update your information specific to {{ $year->year }} and
                                        actually
                                        perform the registation.</p>
                                    <a class="booty" href="{{ url('/camper') }}">Update Campers <i
                                                class="fa fa-arrow-right"></i>
                                    </a>
                                </div>
                                <div class="col-md-4 text-center bs-callout bs-callout-{{ $registered == '1' ? ($paid == '1' ? 'success' : 'error') : 'default' }}">
                                    <p>&nbsp;</p>
                                    <i class="fa fa-money fa-5x"></i><br/>
                                    <h4>Payment</h4>
                                    <p>After completing your registration, go to this page to check your balance and
                                        make a
                                        payment.</p>
                                    <a class="booty" href="{{ url('/payment') }}">View Statement <i
                                                class="fa fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div id="spacer1" class="col-md-12 parallax">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">What is MUUSA like?</h3>
                        </div>
                        <div class="panel-body">
                            <div class="col-md-4 text-center">
                                <p>&nbsp;</p>
                                <i class="fa fa-sitemap fa-5x"></i><br/>
                                <h4>Programs</h4>
                                <p>Most of MUUSA programming is divided into age groups. Find out what to expect for
                                    anyone, young and old, at our retreat.</p>
                                <a class="booty" href="{{ url('/programs') }}">List Programs <i
                                            class="fa fa-arrow-right"></i>
                                </a>
                            </div>
                            <div class="col-md-4 text-center">
                                <p>&nbsp;</p>
                                <i class="fa fa-bath fa-5x"></i><br/>
                                <h4>Housing</h4>
                                <p>Thanks to the amazing staff at YMCA of the Ozarks, we have several types of housing
                                    options available.</p>
                                <a class="booty" href="{{ url('/housing') }}">See Room Types <i
                                            class="fa fa-arrow-right"></i>
                                </a>
                            </div>
                            <div class="col-md-4 text-center">
                                <p>&nbsp;</p>
                                <i class="fa fa-calculator fa-5x"></i><br/>
                                <h4>Camp Cost Calculator</h4>
                                <p>Use this helpful tool to help estimate how much MUUSA will cost this year. Full
                                    details can be found in the brochure.</p>
                                <a class="booty" href="{{ url('/campcost') }}">Use Calculator <i
                                            class="fa fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div id="spacer2" class="col-md-12 parallax">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">What is new for MUUSA in {{ $year->year }}?</h3>
                        </div>
                        <div class="panel-body">
                            <div class="col-md-4 text-center">
                                <p>&nbsp;</p>
                                <i class="fa fa-map-o fa-5x"></i><br/>
                                <h4>Workshops</h4>
                                <p>Here is a list of all available workshops put on by the Adult Programming
                                    Council.</p>
                                <a class="booty" href="{{ url('/workshops') }}">View Workshops <i
                                            class="fa fa-arrow-right"></i>
                                </a>
                            </div>
                            <div class="col-md-4 text-center">
                                <p>&nbsp;</p>
                                <i class="fa fa-binoculars fa-5x"></i><br/>
                                <h4>Excursions</h4>
                                <p>This is where you can find more details about the single-day trips planned.</p>
                                <a class="booty" href="{{ url('/excursions') }}">View Excursions <i
                                            class="fa fa-arrow-right"></i>
                                </a>
                            </div>
                            <div class="col-md-4 text-center">
                                <p>&nbsp;</p>
                                <i class="fa fa-microphone fa-5x"></i><br/>
                                <h4>Theme Speaker</h4>
                                <p>Find out more information about our Theme Speaker, the Reverend Marlin Lavanhar.</p>
                                <a class="booty" href="{{ url('/themespeaker') }}">View Biography <i
                                            class="fa fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endsection

            @section('script')
                <script type="text/javascript">
                    $('[data-toggle="tooltip"]').tooltip();
                </script>
@endsection