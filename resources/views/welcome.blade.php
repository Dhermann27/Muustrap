@extends('layouts.appstrap')

@section('content')

    <div id="highlighted" class="bg-black">
        <div class="overlay overlay-op-6 text-left" data-animate="fadeInRight" data-toggle="backstretch"
             data-backstretch-target="self" data-backstretch-overlay=false
             data-backstretch-imgs="{{ env('IMG_PATH') }}/images/lodge1.jpg,{{ env('IMG_PATH') }}/images/lodge2.jpg,{{ env('IMG_PATH') }}/images/lodge3.jpg,{{ env('IMG_PATH') }}/images/lodge4.jpg,{{ env('IMG_PATH') }}/images/lodge5.jpg">
            <div data-toggle="full-height" class="container px-3 py-5 py-lg-7 flex-valign-b" data-animate="fadeInRight">
                <h2 class="display-4 text-white font-weight-bold text-letter-spacing-xs text-uppercase mt-lg-7">
                    Midwest Unitarian Universalist Summer Assembly
                </h2>
                <h4 class="text-grey font-weight-normal op-9">
                    An annual intergenerational Unitarian Universalist retreat for fun, fellowship, and personal growth
                </h4>
                <div class="mt-4 text-sm text-white">
                    {{ $year->first_day }} through {{ $year->last_day }} {{ $year->year }}
                </div>
                <div class="mt-4">
                    <a href="{{ url('/registration') }}" id="register-button" class="btn btn-primary font-weight-bold">
                        Register for {{ $year->year }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="py-4 pt-md-6 py-md-5 py-md-5 bg-op-5 bg-white">
        <div class="container w-100 w-lg-70">
            <div class="row my-2">
                <div class="col-lg-6 d-sm-flex">
                    <a href="{{ url('/brochure') }}">
                        <img class="card-img-top img-fluid" src="/images/brochure.png" alt="Web Brochure cover">
                    </a>
                </div>
                <div class="col-lg-6 d-sm-flex align-content-center d-flex align-items-center">
                    <div class="mr-auto py-0 pl-lg-5 my-3 my-md-0">
                        <h2 class="display-4 mt-3 mt-lg-0">
                            Web Brochure
                        </h2>
                        <p class="line-height-30 py-md-2 op-7">
                            @if($year->is_live)
                                The easiest way to learn all about MUUSA is to read the brochure, put out by our
                                Planning
                                Council. It has it all: workshop descriptions, housing options, frequently asked
                                questions,
                                and more.
                            @else
                                While you can register right now to reserve your spot, our Planning Council is working
                                diligently to prepare this year's brochure, which should be ready on February 1. You can
                                currently see last year's to get an idea of what it might contain.
                            @endif
                        </p>
                        <a href="{{ url('/brochure') }}"
                           class="mb-1 py-2 px-4 btn btn-primary btn-shadow btn-flat btn-sm btn-bold text-uppercase text-letter-spacing rounded-0">
                            Take a look
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-primary py-4">
        <div class="container text-white d-lg-flex justify-content-center">
            <h3 class="my-lg-0 mr-lg-3 font-weight-normal">
                Just <span class="countdown font-weight-bold" data-countdown="{{ $year->start_date }} 14:00:01"
                           data-countdown-format="%-D %!D:day,days;"></span> until check-in!
            </h3>
            <a href="{{ url('/registration') }}" class="btn btn-primary btn-invert shadow-sm font-weight-bold">Register
                Now!</a>

        </div>
    </div>

    <div class="card-deck p-3">
        <div class="card">
            <img class="card-img-top img-fluid" src="/images/programs@half.jpg" alt="Laurel and Jim Hermann"/>
            <div class="card-body">
                <h4 class="card-title">
                    Programs
                </h4>
                <p class="card-text">Couples and singles, with and without children, can enjoy a variety
                    of workshop and recreational activities while children are in programs with others near
                    their
                    own age, building friendships that will last well beyond the week of camp.</p>
            </div>
            <a href="{{ url('/programs') }}" class="btn btn-primary">Program Descriptions</a>
        </div>
        <div class="card">
            <img class="card-img-top img-fluid" src="/images/housing@half.jpg" alt="Trout Lodge"/>
            <div class="card-body">
                <h4 class="card-title">
                    Housing
                </h4>
                <p class="card-text">YMCA of the Ozarks, Trout Lodge, is located on 5,200 acres of pine
                    and oak forest on a private 360-acre lake 75 miles southwest of St. Louis, Missouri,
                    outside of
                    Potosi. Accommodations are available for all budgets.</p>
            </div>
            <a href="{{ url('/housing') }}" class="btn btn-primary">Housing Options</a>
        </div>
        <div class="card">
            <img class="card-img-top img-fluid" src="/images/workshops@half.jpg"
                 alt="Justin and Eleanor Hobbs, performing at coffeehouse"/>
            <div class="card-body">
                <h4 class="card-title">
                    Workshops
                </h4>
                <p class="card-text">Workshops offer opportunities for learning, personal growth, and
                    fun. They are an excellent way to get to know other campers in a small group setting and to
                    benefit from the wonderful talents, skills, and insights the workshop leaders have to
                    offer.</p>
            </div>
            <a href="{{ url('/workshops') }}" class="btn btn-primary">
                @if($year->is_live)
                    Workshop List
                @else
                    Last Year's Workshops (Sample)
                @endif
            </a>
        </div>
    </div>

    <div class="card-deck p-3">
        <div class="card">
            <img class="card-img-top img-fluid" src="/images/biographies@half.jpg"
                 alt="Chalice lit during morning celebrations"/>
            <div class="card-body">
                <h4 class="card-title">
                    Morning Celebrations
                </h4>
                <p class="card-text">Each morning, the Rev. Karen Mooney &amp; Rev. Pam Rumancik will
                    lead a multi-generational service on the theme topic. Services include children's
                    stories and
                    choral music from the Awesome Choir, led by Pam Blevins Hinkle and accompanied by Bonnie
                    Ettinger.</p>
            </div>
            <a href="{{ url('/themespeaker') }}" class="btn btn-primary">Theme Speaker Biographies</a>
        </div>
        <div class="card">
            <img class="card-img-top img-fluid" src="/images/scholarship@half.jpg"
                 alt="A hummingbird in dire need of a sugar scholarship"/>
            <div class="card-body">
                <h4 class="card-title">
                    Scholarship Opportunities
                </h4>
                <p class="card-text">If finances are tight and MUUSA doesn't quite fit into your budget
                    this year, we hope you will apply for a scholarship. These funds strengthen our
                    community and we
                    want to be sure you know they are available.</p>
            </div>
            <a href="{{ url('/scholarship') }}" class="btn btn-primary">Application Process</a>
        </div>
        <div class="card">
            <img class="card-img-top img-fluid" src="/images/calculator@half.jpg"
                 alt="Hanna Davis, Brochure Editor"/>
            <div class="card-body">
                <h4 class="card-title">
                    Camp Cost Calculator
                </h4>
                <p class="card-text">Use this helpful tool to help estimate how much MUUSA will cost this
                    year. Please consider sharing a room with as many others as possible to reduce your cost
                    and
                    make optimum use of housing. Full details can be found in the brochure.</p>
            </div>
            <a href="{{ url('/cost') }}" class="btn btn-primary">Full-Week Rates</a>
        </div>
    </div>

    <div class="p-4 py-lg-5 bg-grey-dark text-center overlay overlay-default overlay-op-7 my-3"
         data-bg-img="{{ env('IMG_PATH') }}/images/yoga.jpg">
        <h2 class="display-4 text-white m-0">&quot;See you next week!&quot;</h2>
        <h5 class="p-5 text-white lead">Where you are welcomed to a warm and loving community.
            Where children are safe and cared for.<br/>
            Where you'll always be accepted.
            Where others share your values.<br/>
            Where your spirit will be renewed!</h5>
    </div>



    <h3 class="pt-5 px-8">
        Quotes from the community
    </h3>
    <div class="mt-4 owl-dots-center owl-nav-over" data-toggle="owl-carousel"
         data-owl-carousel-settings='{"responsive":{"0":{"items":1}, "600":{"items":1, "stagePadding":150, "margin":150}}, "autoplay": true, "center":true, "dots":true, "autoHeight":true}'>

        <blockquote class="blockquote-bubble">
            <p class="blockquote-bubble-content">"When you hear about the kinds of experiences that change
                kids' lives, this is
                what they are talking about."</p>
            <small>
                Karen S. <span class="text-primary font-weight-bold">/</span> Wheaton IL
            </small>
        </blockquote>
        <blockquote class="blockquote-bubble">
            <p class="blockquote-bubble-content">"When you hear about the kinds of experiences that change
                kids' lives, this is
                what they are talking about."</p>
            <small>
                Karen S. <span class="text-primary font-weight-bold">/</span> Wheaton IL
            </small>
        </blockquote>
        <blockquote class="blockquote-bubble">
            <p class="blockquote-bubble-content">"MUUSA is where I became a UU and where I return to renew
                my vows."</p>
            <small>
                John S. <span class="text-primary font-weight-bold">/</span> Cincinnati OH
            </small>
        </blockquote>
        <blockquote class="blockquote-bubble">
            <p class="blockquote-bubble-content">"I love that I started the week not knowing anyone except
                my children, but
                ended the week with lifelong friends."</p>
            <small>
                Geeta P. <span class="text-primary font-weight-bold">/</span> Colorado Springs CO
            </small>
        </blockquote>
        <blockquote class="blockquote-bubble">
            <p class="blockquote-bubble-content">"MUUSA is a true community for building meaningful
                friendships-- as well as a
                low stress family vacation where you are not always reaching for your wallet."</p>
            <small>
                Roger E. <span class="text-primary font-weight-bold">/</span> Atlanta GA
            </small>
        </blockquote>
        <blockquote class="blockquote-bubble">
            <p class="blockquote-bubble-content">"MUUSA gives me a space to deepen family bonds and recharge
                connections with
                my inner humanity."</p>
            <small>
                Gregory R. <span class="text-primary font-weight-bold">/</span> Chicago IL
            </small>
        </blockquote>
        <blockquote class="blockquote-bubble">
            <p class="blockquote-bubble-content">"Growing up at MUUSA helped teach me how to love and be
                loved."</p>
            <small>
                Ellie M. <span class="text-primary font-weight-bold">/</span> Kalamazoo MI
            </small>
        </blockquote>
    </div>

    <hr class="my-5"/>

    <!-- Video background MDR -->
    <div class="p-4 p-lg-6 bg-light text-center overlay overlay-dark overlay-op-5"
         data-settings='{ "posterType": "jpg" }'
         data-bg-video="https://s3.us-east-2.amazonaws.com/muusa/jumpintoit.webm" data-animate="fadeIn">
        <div class="container">
            <h2 class="text-white display-4 text-shadow">
                Join us.
            </h2>
            <a href="{{ url('/registration') }}" class="btn btn-xlg btn-rounded btn-primary mt-4">
                Register for {{ $year->year }}</a>

        </div>
    </div>
@endsection
