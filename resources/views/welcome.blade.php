@extends('layouts.appstrap')

@section('content')
    <div id="highlighted" class="bg-black">
        <div class="overlay overlay-op-6 text-left" data-animate="fadeIn" data-toggle="backstretch"
             data-backstretch-target="self" data-backstretch-overlay=false
             data-backstretch-imgs="/images/jumbotron.jpg">
            <div data-toggle="full-height" class="container px-3 py-5 py-lg-7 flex-valign-b"
                 data-animate="fadeIn" data-animate-delay="0.4">
                <h2 class="display-4 text-white font-weight-bold text-letter-spacing-xs text-uppercase mt-lg-7">
                    Midwest Unitarian Universalist Summer Assembly
                </h2>
                <h4 class="text-grey font-weight-normal op-9">
                    An annual intergenerational Unitarian Universalist retreat for fun, fellowship, and personal growth
                </h4>
                <div class="mt-4 text-sm text-white">
                    {{ $year->first_day }} through {{ $year->last_day }} {{ $year->year }}
                </div>
                <div class="mt-4"><a href="{{ url('/registration') }}" class="btn btn-primary font-weight-bold"
                                     data-toggle="scroll-link" data-animate="fadeIn" data-animate-delay="0.6">Register
                        for {{ $year->year }}</a></div>
            </div>
        </div>
    </div>
    <!-- Countdown -->
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


    {{--<div class="row inner-top-sm">--}}
    {{--<div class="col-lg-3 inner-bottom-sm aos-init aos-animate" data-aos="fade-up"><h2>Meet us online</h2>--}}
    {{--<p class="text-small">Want to learn more about us before taking the plunge? Find us on social media:--}}
    {{--view our promotional video on YouTube, find our page or closed group on Facebook, or see our--}}
    {{--innermost thoughts on Twitter.</p>--}}
    {{--<a href="https://www.youtube.com/watch?v=QNWMdbrjxuE">--}}
    {{--<i class="fab fa-youtube fa-2x"></i> <span--}}
    {{--class="sr-only">YouTube</span> </a>--}}
    {{--<a href="https://twitter.com/muusa1"> <i--}}
    {{--class="fab fa-twitter fa-2x"></i> <span--}}
    {{--class="sr-only">Twitter</span> </a>--}}
    {{--<a href="https://www.facebook.com/{{ Auth::guest() ? 'Muusa2013/' : 'groups/Muusans/'}}">--}}
    {{--<i class="fab fa-facebook fa-2x"></i> <span--}}
    {{--class="sr-only">Facebook</span> </a>--}}
    {{--</div>--}}
    {{--<div class="col-lg-3 inner-bottom-sm aos-init aos-animate" data-aos="fade-up"><h2>Brochure</h2>--}}
    {{--<p class="text-small">--}}
    {{--@if($year->is_live)--}}
    {{--The easiest way to learn all about MUUSA is to read the brochure, put out by our Planning--}}
    {{--Council. It has it all: workshop descriptions, housing options, frequently asked questions,--}}
    {{--and more.--}}
    {{--@else--}}
    {{--While you can register right now to reserve your spot, our Planning Council is working--}}
    {{--diligently to prepare this year's brochure, which should be ready on February 1. You can--}}
    {{--currently see last year's to get an idea of what it might contain.--}}
    {{--@endif--}}
    {{--</p>--}}
    {{--<a href="{{ url('/brochure') }}" class="txt-btn">Take a look</a></div>--}}
    {{--<div class="col-lg-6 inner-left-xs aos-init aos-animate p-0" data-aos="fade-up">--}}
    {{--<figure><img id="brochure" src="/images/brochure.png"></figure>--}}
    {{--</div>--}}
    {{--</div>--}}

    {{--<section id="services">--}}
    {{--<div class="container inner-top inner-bottom-sm">--}}
    {{--<div class="row">--}}
    {{--<div class="col-lg-8 col-md-9 mx-auto text-center aos-init aos-animate" data-aos="fade-up">--}}
    {{--<header><h1>&quot;See you next week!&quot;</h1>--}}
    {{--<p>Where you are welcomed to a warm and loving community. Where children are safe and cared for.--}}
    {{--Where you’ll always be accepted. Where others share your values. Where your spirit will be--}}
    {{--renewed!</p>--}}
    {{--</header>--}}
    {{--</div>--}}
    {{--</div>--}}

    <div class="card-deck p-3">
        <div class="card">
            <img class="card-img-top img-fluid" src="/images/programs.png" alt="Laurel and Jim Hermann"/>
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
            <img class="card-img-top img-fluid" src="/images/housing.png"
                 alt="Mark Lukow, intrepid explorer"/>
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
            <img class="card-img-top img-fluid" src="/images/workshops.png"
                 alt="Peter and Harpy Gettle, performing at coffeehouse"/>
            <div class="card-body">
                <h4 class="card-title">
                    Workshops
                </h4>
                <p class="card-text">Workshops offer opportunities for learning, personal growth, and
                    fun. They are an excellent way to get to know other campers in a small group setting and
                    to
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
            <img class="card-img-top img-fluid" src="/images/biographies.png"
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
            <img class="card-img-top img-fluid" src="/images/scholarship.png"
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
            <img class="card-img-top img-fluid" src="/images/calculator.png"
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

    <div class="p-4 py-lg-5 bg-grey-dark text-center overlay overlay-slate overlay-op-4 my-3" data-bg-img="/images/yoga.png">
        <h2 class="text-uppercase font-weight-bold m-0">&quot;See you next week!&quot;</h2>
        <h5 class="p-5">Where you are welcomed to a warm and loving community.
            Where children are safe and cared for.<br />
            Where you'll always be accepted.
            Where others share your values.<br />
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
