@extends('layouts.app')

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
    @if(Auth::guest())
        <div class="alert alert-info" role="alert">Welcome to muusa.org! If you're interested in beginning the
            registration process, please start by logging in or creating a website account in the upper-right.
        </div>
    @elseif($registered == '0')
        <div class="alert alert-info" role="alert">Ready to register for MUUSA {{ $year->year }}? Start the 3-step
            process by clicking the Register button below.
        </div>
    @elseif($registered == '1')
        @if($paid == '0')
            <div class="alert alert-warning" role="alert">
                Your payment has not yet been processed. Either visit the Payment screen by clicking the link below or
                mail your check to the address on the same page.
            </div>
        @elseif($signedup == 0)
            <div class="alert alert-warning" role="alert">
                You are all paid up, but have not yet chosen any workshops. Use the button below to select any in which
                you might be interested.
            </div>
        @elseif($roomid == null || $roomid->roomid == null)
            <div class="alert alert-warning" role="alert">
                You are all paid up, but have not yet selected your room. Use the Room Selection Tool below to lock in a
                housing option or the Contact Us form above to reach out to the Registrar for assistance finding
                housing.
            </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">You're registered!</h3>
                    </div>
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
                            <p>Find the right place for you and your family to stay, and who might be your
                                neighbors.</p>
                            <a class="booty" href="{{ url('/roomselection') }}">Choose Room <i
                                        class="fa fa-arrow-right"></i>
                            </a>
                        </div>
                        <div class="col-md-4 text-center">
                            <p>&nbsp;</p>
                            <i class="fa fa-envelope-o fa-5x"></i><br/>
                            <h4>Confirmation Letter</h4>
                            <p>See the current status of your registration and fill out extra forms for your family.</p>
                            <a class="booty" href="{{ url('/confirm') }}">See Letter <i
                                        class="fa fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="carousel" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carousel" data-slide-to="0" class="active"></li>
                <li data-target="#carousel" data-slide-to="1"></li>
                <li data-target="#carousel" data-slide-to="2"></li>
                <li data-target="#carousel" data-slide-to="3"></li>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
                <div class="item active">
                    <img src="/images/volunteer.jpg" alt="Dana Cable, George Peck, et al">
                    <div id="carousel-caption4" class="carousel-caption">
                        <h3>Campers! We need you!</h3>
                        <p>Please consider helping out by taking advantage of one of our many volunteer opportunities.<br />
                            Coordinators will contact you with expectations and details before camp begins.<br/><br/>
                            <a class="booty" href="{{ url('/volunteer') }}">Volunteer Now <i
                                        class="fa fa-arrow-right"></i>
                            </a>
                        </p>
                    </div>
                </div>
                <div class="item">
                    <img src="/images/spacer0.png" alt="Marlin Lavanhar, 2017 Theme Speaker">
                    <div id="carousel-caption1" class="carousel-caption">
                        <h3>Our Theme: A Summer of Love</h3>
                        <p>A few years ago, UUA President, Peter Morales, suggested we can find common ground with
                            others, not so much by sharing our beliefs and opinions, but by sharing with one another
                            what we love. UU theologian Thandeka proclaims that in our tradi- tion we "love beyond
                            belief." The covenant in many UU congregations says "Love is the spirit of our church"
                            and
                            we "seek the truth in love." Dr. Martin Luther King Jr. said that we do not have to like
                            someone to love them. He also said that "power without love is reckless and abusive and
                            love
                            without power is sentimental and anemic."</p>
                        <p>What is this thing called love that seems to be so transforming and important? We often
                            talk
                            about "falling in love" as if it is an accident like falling down the stairs. It would
                            seem
                            sometimes like love is something that should just happen and as if it is simply a
                            feeling
                            that one experiences. What does love require of us? How can we love ourselves and our
                            neighbors? Is it possible to love our enemies? At camp this year we are going to make
                            this A
                            Summer of Love. Worship each day will be an opportunity for us to explore the depths and
                            experience the heights of this thing called love.</p>
                    </div>
                </div>
                <div class="item">
                    <img src="/images/theme.png" alt="2017 Art Fair">
                    <div id="carousel-caption2" class="carousel-caption">
                        <h3>Camper Art Fair</h3>
                        <p>Calling all MUUSA artists! Join us for the 6th Annual MUUSA Art Show and Sale. Items sold
                            must be original, handmade visual arts or crafts created by the artist attending MUUSA.
                            Applications and images need to be submitted by May 1st.</p>
                        <a class="booty" href="{{ url('/artfair') }}">Apply Online <i
                                    class="fa fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <div class="item">
                    <img src="/images/5k.jpg" alt="2017 MUUSA 5k Run/Walk">
                    <div id="carousel-caption3" class="carousel-caption">
                        <h3>MUUSA 5k Walk/Run</h3>
                        <p>Join your fellow campers on Thursday at 7am for the 7th Annual MUUSA 5K (3.1 miles)
                            Walk/Run.
                            There will be prizes for everyone! All are welcome and no one is too fast or too slow,
                            too
                            young or too old. Be a part of a healthy annual tradition!</p>
                    </div>
                </div>
            </div>
            <a class="left carousel-control" href="#carousel" role="button" data-slide="prev">
                <i class="fa fa-chevron-left fa-3x" aria-hidden="true"></i>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#carousel" role="button" data-slide="next">
                <i class="fa fa-chevron-right fa-3x" aria-hidden="true"></i>
                <span class="sr-only">Next</span>
            </a>
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
                @elseif($registered == '0')
                    <div class="panel-body">
                        <div class="col-md-3 col-md-offset-5 text-center">
                            <p>&nbsp;</p>
                            <a href="{{ url('/household') }}">
                                <div class="pulse-button">Register<br/>Now</div>
                            </a>
                            <p>Got 5 minutes? Let's begin the 3-step registration process!</p>
                        </div>
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
                            <p>This page can help you update your information specific to {{ $year->year }} and actually
                                perform the registation.</p>
                            <a class="booty" href="{{ url('/camper') }}">Update Campers <i
                                        class="fa fa-arrow-right"></i>
                            </a>
                        </div>
                        <div class="col-md-4 text-center bs-callout bs-callout-{{ $registered == '1' ? ($paid == '1' ? 'success' : 'error') : 'default' }}">
                            <p>&nbsp;</p>
                            <i class="fa fa-money fa-5x"></i><br/>
                            <h4>Payment</h4>
                            <p>After completing your registration, go to this page to check your balance and make a
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
                    <div class="col-md-3 text-center">
                        <p>&nbsp;</p>
                        <i class="fa fa-sitemap fa-5x"></i><br/>
                        <h4>Programs</h4>
                        <p>Most of MUUSA programming is divided into age groups. Find out what to expect for
                            anyone, young and old, at our retreat.</p>
                        <a class="booty" href="{{ url('/programs') }}">List Programs <i
                                    class="fa fa-arrow-right"></i>
                        </a>
                    </div>
                    <div class="col-md-3 text-center">
                        <p>&nbsp;</p>
                        <i class="fa fa-bath fa-5x"></i><br/>
                        <h4>Housing</h4>
                        <p>Thanks to the amazing staff at YMCA of the Ozarks, we have several types of housing
                            options available.</p>
                        <a class="booty" href="{{ url('/housing') }}">See Room Types <i
                                    class="fa fa-arrow-right"></i>
                        </a>
                    </div>
                    <div class="col-md-3 text-center">
                        <p>&nbsp;</p>
                        <i class="fa fa-calculator fa-5x"></i><br/>
                        <h4>Camp Cost Calculator</h4>
                        <p>Use this helpful tool to help estimate how much MUUSA will cost this year. Full
                            details can be found in the brochure.</p>
                        <a class="booty" href="{{ url('/cost') }}">Use Calculator <i
                                    class="fa fa-arrow-right"></i>
                        </a>
                    </div>
                    <div class="col-md-3 text-center">
                        <p>&nbsp;</p>
                        <i class="fa fa-universal-access fa-5x"></i><br/>
                        <h4>Scholarships</h4>
                        <p>By partnering with our facility, YMCA of the Ozarks, MUUSA is able to offer financial
                            assistance for those in need.</p>
                        <a class="booty" href="{{ url('/scholarship') }}">Find Details <i
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
    <script>
        $(".alert").fadeTo(5000, 1000).slideUp(1000, function () {
            $(".alert").slideUp(1000);
        });
    </script>
@endsection