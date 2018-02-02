@inject('home', 'App\Http\Controllers\HomeController')
@extends('layouts.app')

@section('content')
    <div class="jumbotron">
        <div class="container py-4 py-lg-6">
            <h2 class="text-center text-uppercase font-weight-bold my-0" data-animate="fadeIn" data-animate-delay="0.3">
                MUUSA
            </h2>
            <hr class="hr-lg mt-0 mb-3 w-10 mx-auto hr-primary" data-animate="fadeIn" data-animate-delay="0.3"/>
            <h4 class="text-center mt-2 mb-0 py-5" data-animate="fadeIn" data-animate-delay="0.7">
                An annual intergenerational Unitarian Universalist retreat for fun, fellowship, and personal growth
            </h4>
            <div class="row">
                <div class="col-md-4" data-animate="fadeIn" data-animate-delay="1.0">
                    <i class="fa fa-map-marker-alt fa-3x"></i>
                    <p><strong>Located</strong><br/>
                        at Trout Lodge in the YMCA of the Ozarks near Potosi, Missouri</p>
                </div>
                <div class="col-md-4" data-animate="fadeIn" data-animate-delay="1.2">
                    <i class="fa fa-calendar-alt fa-3x"></i>
                    <p><strong>Scheduled</strong><br/>
                        {{ $home->year()->first_day }} through {{ $home->year()->last_day }} {{ $home->year()->year }}
                    </p>
                </div>
                <div class="col-md-4" data-animate="fadeIn" data-animate-delay="1.4">
                    <i class="fa fa-fire fa-3x"></i>
                    <p><strong>All are welcome</strong><br/>
                        regardless of age, race, ethnicity, gender, sexual orientation, social class or ability</p>
                </div>
            </div>
        </div>
    </div>
    @if(Auth::guest())
        <div class="alert alert-info" role="alert">Welcome to muusa.org! If you're interested in beginning the
            registration process, please start by logging in or creating a website account in the upper-left.
        </div>
    @elseif($registered && !$paid)
        <div class="alert alert-warning" role="alert">
            Your payment has not yet been processed. Either visit the Payment screen by clicking the link below or
            mail your check to the address on the same page.
        </div>
    @elseif(!$registered)
        <div class="alert alert-info" role="alert">Ready to register for MUUSA {{ $home->year()->year }}? Start the
            3-step process by clicking the Register button below.
        </div>
    @elseif($registered && $home->year()->isLive())
        @if(!$signedup)
            <div class="alert alert-warning" role="alert">
                You are all paid up, but have not yet chosen any workshops. Use the button below to select any in which
                you might be interested.
            </div>
        @elseif($roomid == null)
            <div class="alert alert-warning" role="alert">
                You are all paid up, but have not yet selected your room. Use the Room Selection Tool below to lock in a
                housing option or the Contact Us form above to reach out to the Registrar for assistance finding
                housing.
            </div>
        @endif

        <div class="bg-faded py-3 py-lg-6">
            <div class="container">
                <h2 class="text-center text-uppercase font-weight-bold my-0">
                    You're registered!
                </h2>
                <hr class="hr-lg mt-0 mb-3 w-10 mx-auto hr-primary"/>
                @if(!$signedup)
                    <div class="progress mb-3">
                        Registered but no workshops selected...
                    </div>
                @elseif($roomid == null)
                    @component('snippet.progress', ['width' => 24, 'bg' => 'warning'])
                        Registered but room not selected...
                    @endcomponent
                @elseif(!$nametags)
                    @component('snippet.progress', ['width' => 50, 'bg' => 'warning'])
                        Registered but nametags not yet customized...
                    @endcomponent
                @elseif(!$confirmed)
                    @component('snippet.progress', ['width' => 76, 'bg' => 'warning'])
                        Registered but medical forms for children not submitted...
                    @endcomponent
                @else
                    @component('snippet.progress', ['width' => 100, 'bg' => 'success'])
                        Ready for camp!
                    @endcomponent
                @endif
                <div class="row">
                    <div class="col-md-3">
                        <div class="card bg-shadow text-center rounded py-3" data-animate="bounceInLeft"
                             data-animate-delay="0.2">
                            <h3>Workshops</h3>
                            <p class="price-banner border-grey card-body-overlap"><i
                                        class="fa fa-rocket fa-5x"></i>
                            </p>
                            <div class="card-body">
                                <p>Sign up for entertaining and intriguing seminars, organized by our Adult
                                    Programming Committee.</p>
                                <a href="{{ url('/workshopchoice') }}"
                                   class="btn btn-primary btn-block btn-rounded">
                                    Add Choices</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-shadow text-center rounded py-3" data-animate="bounceInLeft"
                             data-animate-delay="0.4">
                            <h3>Room Selection</h3>
                            <p class="price-banner border-grey card-body-overlap"><i
                                        class="fa fa-bed fa-5x"></i>
                            </p>
                            <div class="card-body">
                                <p>
                                    {{--@if($home->year()->isCrunch())--}}
                                        {{--This close to camp, all housing will be assigned by the Registrar. Please use--}}
                                        {{--the Contact Us form.--}}
                                    {{--@else--}}
                                        Find the right place for you and your family to stay, and who might be your
                                        neighbors.
                                    {{--@endif--}}
                                </p>
                                <a href="{{ url('/roomselection') }}"
                                   class="btn btn-primary btn-block btn-rounded">
                                    Choose Room</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-shadow text-center rounded py-3" data-animate="bounceInLeft"
                             data-animate-delay="0.6">
                            <h3>Nametags</h3>
                            <p class="price-banner border-grey card-body-overlap"><i
                                        class="fa fa-id-card fa-5x"></i>
                            </p>
                            <div class="card-body">
                                <p>Choose the best fields and format for the information that will be displayed on your
                                    name tag at camp.</p>
                                <a href="{{ url('/nametag') }}"
                                   class="btn btn-primary btn-block btn-rounded">
                                    Customize</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-shadow text-center rounded py-3" data-animate="bounceInLeft"
                             data-animate-delay="0.8">
                            <h3>Confirmation</h3>
                            <p class="price-banner border-grey card-body-overlap"><i
                                        class="fa fa-envelope fa-5x"></i>
                            </p>
                            <div class="card-body">
                                <p>See the current status of your registration and fill out medical and program forms
                                    for your family.</p>
                                <a href="{{ url('/confirm') }}"
                                   class="btn btn-primary btn-block btn-rounded">
                                    Read Letter</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="mt-4 owl-dots-center owl-nav-over" data-toggle="owl-carousel"
             data-owl-carousel-settings='{"responsive":{"0":{"items":1}, "600":{"items":1, "stagePadding":90, "margin":90}}, "center":true, "loop": true, "autoplay": true, "autoplayHoverPause": true, "dots":true, "autoHeight":true}'>

            <div class="item">
                <img src="/images/volunteer.jpg" alt="Dana Cable, George Peck, et al">
                <div id="carousel-caption0" class="carousel-caption">
                    <h4>Campers! We need you!</h4>
                    <p>Please consider helping out by taking advantage of one of our many volunteer
                        opportunities. Coordinators will contact you with expectations and details before camp
                        begins.<br/><br/></p>
                    <a class="btn btn-primary btn-rounded" href="{{ url('/volunteer') }}">Volunteer Now <i
                                class="fa fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            <div class="item">
                <img src="/images/nicord.png" alt="Reverend Nic Cable at his ordination">
                <div id="carousel-caption1" class="carousel-caption">
                    <h4>2018 Theme: Living Between Worlds</h4>
                    <p>As Unitarian Universalists, it can sometimes feel like we are living between worlds. We long to
                        live in a world grounded in core values of justice and compassion, of inclusion and
                        multiculturalism. And yet that world is not yet here. How do we live in that liminal space
                        between where we are and where we long to be, whether in our personal lives, our family and work
                        lives, our congregational lives, or our civic lives? Furthermore, how can MUUSA be a vehicle for
                        dreaming and scheming a way forward as we seek to bring about a truer embodiment of the Beloved
                        Community, one that might exist not just one week a year, but all the time? Rev. Nic Cable will
                        offer practical reflection and strategies for how we can find the spiritual fortitude and
                        vision for this journey ahead.</p>
                </div>
            </div>


            <div class="item">
                <img src="/images/theme.png" alt="2017 Art Fair">
                <div id="carousel-caption2" class="carousel-caption">
                    <h3>Camper Art Fair</h3>
                    <p>Calling all MUUSA artists! Join us for the 6th Annual MUUSA Art Show and Sale. Items sold
                        must be original, handmade visual arts or crafts created by the artist attending MUUSA.
                        Applications and images need to be submitted by May 1st.</p>
                    <a class="btn btn-primary btn-rounded" href="{{ url('/artfair') }}">Apply Online <i
                                class="fa fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            <div class="item">
                <img src="/images/5k.jpg" alt="2017 MUUSA 5k Run/Walk">
                <div id="carousel-caption3" class="carousel-caption">
                    <h3>Holly Jamison 5k Walk/Run</h3>
                    <p>Join your fellow campers on Thursday at 7am for the 7th Annual MUUSA 5K (3.1 miles) Walk/Run.
                        There will be prizes for everyone! All are welcome and no one is too fast or too slow, too young
                        or too old. Be a part of a healthy annual tradition!</p>
                </div>
            </div>
        </div>
    @endif
    @if(Auth::guest() || !$registered)
        <div class="row bg-faded p-3">
            <div class="col-12 col-lg-7 py-2">
                <h3 class="text-uppercase font-weight-bold mt-0 mb-2">Get Registered
                    for {{ $home->year()->year }}</h3>
                <h5 class="text-grey-dark">Complete the five-minute process to register yourself for camp.</h5>
            </div>
            <div class="col-12 col-lg-5 py-2 text-lg-right">
                <a href="{{ Auth::guest() ? url('/register') : url('/household') }}"
                   class="btn btn-lg btn-primary py-3 px-4">Register <i class="fa fa-arrow-right"></i></a>
            </div>
        </div>
    @else
        <div class="bg-faded py-3 py-lg-6">
            <div class="container">
                <h2 class="text-center text-uppercase font-weight-bold my-0">
                    {{ $home->year()->year }} Registration
                </h2>
                <hr class="hr-lg mt-0 mb-3 w-10 mx-auto hr-primary"/>

                @component('snippet.progress', ['width' => $paid ? 100 : 66, 'bg' => $paid ? 'success' : 'warning'])
                    @if($paid)
                        Registration complete!
                    @else
                        Registered but deposit not yet paid...
                    @endif
                @endcomponent
                <div class="row">
                    <div class="col-md-4">
                        <div class="card bg-shadow text-center rounded py-3" data-animate="bounceInLeft"
                             data-animate-delay="0.2">
                            <h3>Household Information</h3>
                            <p class="price-banner border-grey card-body-overlap"><i
                                        class="fa fa-home fa-5x"></i>
                            </p>
                            <div class="card-body">
                                <p>Go to this page to update your address and other information communal to
                                    everyone in
                                    your family.</p>
                                <a href="{{ url('/household') }}" class="btn btn-primary btn-block btn-rounded">Update
                                    Household</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-shadow text-center rounded py-3" data-animate="bounceInLeft"
                             data-animate-delay="0.4">
                            <h3>Camper Listing</h3>
                            <p class="price-banner border-grey card-body-overlap"><i
                                        class="fa fa-users fa-5x"></i>
                            </p>
                            <div class="card-body">
                                <p>This page can help you update your information specific
                                    to {{ $home->year()->year }}
                                    and
                                    choose which campers to register.</p>
                                <a href="{{ url('/camper') }}" class="btn btn-primary btn-block btn-rounded">Update
                                    Campers</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-shadow text-center rounded py-3" data-animate="bounceInLeft"
                             data-animate-delay="0.6">
                            <h3>Payment</h3>
                            <p class="price-banner border-grey card-body-overlap"><i
                                        class="fa fa-usd-square fa-5x"></i>
                            </p>
                            <div class="card-body">
                                <p>After completing your registration, go to this page to check your balance and
                                    make a
                                    payment.</p>
                                <a href="{{ url('/payment') }}" class="btn btn-primary btn-block btn-rounded">View
                                    Statement</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div id="spacer1" class="col-md-12 parallax">
        </div>
    </div>
    <div class="bg-faded py-3 py-lg-6">
        <div class="container">
            <h2 class="text-center text-uppercase font-weight-bold my-0">
                What is MUUSA like?
            </h2>
            <hr class="hr-lg mt-0 mb-3 w-10 mx-auto hr-primary"/>
            <div class="row">
                <div class="col-md-3">
                    <div class="card bg-shadow text-center rounded py-3" data-animate="bounceInLeft"
                         data-animate-delay="0.2">
                        <h3>Programs</h3>
                        <p class="price-banner border-grey card-body-overlap"><i
                                    class="fa fa-sitemap fa-5x"></i>
                        </p>
                        <div class="card-body">
                            <p>Most of MUUSA programming is divided into age groups. Find out what to expect for
                                anyone, young and old, at our retreat.</p>
                            <a href="{{ url('/programs') }}" class="btn btn-primary btn-block btn-rounded">List
                                Programs</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-shadow text-center rounded py-3" data-animate="bounceInLeft"
                         data-animate-delay="0.4">
                        <h3>Housing</h3>
                        <p class="price-banner border-grey card-body-overlap"><i class="fa fa-bath fa-5x"></i>
                        </p>
                        <div class="card-body">
                            <p>Thanks to the amazing staff and facilities at YMCA of the Ozarks, we have several
                                housing options available.</p>
                            <a href="{{ url('/housing') }}" class="btn btn-primary btn-block btn-rounded">See
                                Room
                                Types</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-shadow text-center rounded py-3" data-animate="bounceInLeft"
                         data-animate-delay="0.6">
                        <h3>Cost Calculator</h3>
                        <p class="price-banner border-grey card-body-overlap"><i
                                    class="fa fa-calculator fa-5x"></i>
                        </p>
                        <div class="card-body">
                            <p>Use this helpful tool to help estimate how much MUUSA will cost this year. Full
                                details can be found in the brochure.</p>
                            <a href="{{ url('/cost') }}" class="btn btn-primary btn-block btn-rounded">Use
                                Calculator</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-shadow text-center rounded py-3" data-animate="bounceInLeft"
                         data-animate-delay="0.8">
                        <h3>Scholarships</h3>
                        <p class="price-banner border-grey card-body-overlap"><i
                                    class="fa fa-universal-access fa-5x"></i>
                        </p>
                        <div class="card-body">
                            <p>By partnering with our facility, YMCA of the Ozarks, MUUSA is able to offer
                                financial assistance for those in need.</p>
                            <a href="{{ url('/scholarship') }}" class="btn btn-primary btn-block btn-rounded">Find
                                Details</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div id="spacer2" class="col-md-12 parallax">
        </div>
    </div>
    <div class="bg-faded py-3 py-lg-6">
        <div class="container">
            <h2 class="text-center text-uppercase font-weight-bold my-0">
                What is new for MUUSA in {{ $home->year()->year }}?
            </h2>
            <hr class="hr-lg mt-0 mb-3 w-10 mx-auto hr-primary"/>
            <div class="row">
                <div class="col-md-4">
                    <div class="card bg-shadow text-center rounded py-3" data-animate="bounceInLeft"
                         data-animate-delay="0.2">
                        <h3>Workshops</h3>
                        <p class="price-banner border-grey card-body-overlap"><i class="fa fa-map fa-5x"></i>
                        </p>
                        <div class="card-body">
                            <p>Here is a list of all
                                @if($home->year()->isLive())
                                    {{ $home->year()->year }} workshops available, as organized by our Adult
                                    Programming
                                    Committee.
                                @else
                                    {{ ($home->year()->year)-1 }} workshops, to give you a better idea of what
                                    to expect
                                    next year.
                                @endif
                            </p>
                            <a href="{{ url('/workshops') }}" class="btn btn-primary btn-block btn-rounded">View
                                Workshops</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-shadow text-center rounded py-3" data-animate="bounceInLeft"
                         data-animate-delay="0.4">
                        <h3>Excursions</h3>
                        <p class="price-banner border-grey card-body-overlap"><i
                                    class="fa fa-binoculars fa-5x"></i>
                        </p>
                        <div class="card-body">
                            <p>This is where you can find more details about single-day trips planned in
                                @if($home->year()->isLive())
                                    {{ $home->year()->year }}, if you're looking to try something new.
                                @else
                                    {{ ($home->year()->year)-1 }}, which may change in {{ $home->year()->year }}
                                    .
                                @endif
                            </p>
                            <a href="{{ url('/excursions') }}" class="btn btn-primary btn-block btn-rounded">View
                                Excursions</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-shadow text-center rounded py-3" data-animate="bounceInLeft"
                         data-animate-delay="0.6">
                        <h3>Theme Speaker</h3>
                        <p class="price-banner border-grey card-body-overlap"><i
                                    class="fa fa-microphone fa-5x"></i>
                        </p>
                        <div class="card-body">
                            <p>Find out more information about our {{ $home->year()->year }} Theme Speaker,
                                Reverend Nic
                                Cable.</p>
                            <a href="{{ url('/themespeaker') }}" class="btn btn-primary btn-block btn-rounded">View
                                Biography</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="p-5 bg-faded bg-video" data-bg-video="https://s3.us-east-2.amazonaws.com/muusa/jumpintoit.webm"
         data-settings='{"position":"33% 33%", "muted": "1", "posterType": "jpg"}'>
        <div id="jumpintoit" class="row">
            <div class="col-md-6 text-md-right">
                <h2 class="display-3">
                    Join us!
                </h2>
            </div>
        </div>
    </div>

    <div class="p-3 py-lg-6 bg-dark">
        <div class="container">
            <h2 class="text-white text-center text-uppercase font-weight-bold my-0">
                Quotes from the community
            </h2>
            <hr class="hr-lg mt-0 mb-3 w-10 mx-auto hr-primary"/>
            <h5 class="text-center font-weight-light mt-2 mb-0 text-grey">
                Over 60% of our campers return for multiple years
            </h5>
            <hr class="mb-5 w-50 mx-auto"/>
            <div class="row">
                <div class="col-md-4 d-md-flex">
                    <blockquote class="blockquote-bubble text-center" data-animate="flipInY"
                                data-animate-delay="0.2">
                        <p class="blockquote-bubble-content bg-white">"When you hear about the kinds of
                            experiences that change kids' lives, this is what they are talking about."</p>
                        <small class="text-grey">
                            Karen S.
                            <span class="text-primary font-weight-bold">/</span>
                            Wheaton, Illinois
                        </small>
                    </blockquote>
                </div>
                <div class="col-md-4 d-md-flex">
                    <blockquote class="blockquote-bubble text-center" data-animate="flipInY"
                                data-animate-delay="0.4">
                        <p class="blockquote-bubble-content bg-white text-center">"I love that I started the
                            week not
                            knowing anyone except my children, but ended the week with lifelong friends."</p>
                        <small class="text-grey">
                            Geeta P.
                            <span class="text-primary font-weight-bold">/</span>
                            Colorado Springs, Colorado
                        </small>
                    </blockquote>
                </div>
                <div class="col-md-4 d-md-flex">
                    <blockquote class="blockquote-bubble text-center" data-animate="flipInY"
                                data-animate-delay="0.6">
                        <p class="blockquote-bubble-content bg-white text-center">"MUUSA is a true community for
                            building meaningful friendships-- as well as a low stress family vacation where you
                            are not
                            always reaching for your wallet."</p>
                        <small class="text-grey">
                            Roger E.
                            <span class="text-primary font-weight-bold">/</span>
                            Atlanta, Georgia
                        </small>
                    </blockquote>
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