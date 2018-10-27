@extends('layouts.app')

@section('css')
    <link rel="stylesheet" type="text/css" href="/css/jquery.background-video.css">
@endsection

@section('multisection')
    <section id="hero">
        <div id="owl-main" class="owl-carousel owl-one-item">
            <div class="item img-bg-center" style="background-image: url('/images/jumbotron.jpg');">
                <div class="container">
                    <div class="caption vertical-center text-center">
                        <h1 class="fadeInDown-1 light-color">Midwest Unitarian Universalist Summer Assembly</h1>
                        <p class="fadeInDown-2 light-color">An annual intergenerational Unitarian Universalist retreat
                            for fun, fellowship, and personal growth</p>
                        <div class="fadeInDown-3">
                            <a href="{{ url('/registration') }}" class="btn btn-large">Register
                                for {{ $year->year }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="features" class="light-bg">
        <div class="container inner-top">
            <div class="row">
                <div class="col-lg-8 col-md-9 mx-auto text-center aos-init aos-animate" data-aos="fade-up">
                    <header><h1>All are welcome.</h1>
                        <p>Regardless of age, race, ethnicity, gender, sexual orientation, social class or ability<br/>
                            Located at Trout Lodge in the YMCA of the Ozarks near Potosi, Missouri<br/>
                            Scheduled {{ $year->first_day }} through {{ $year->last_day }} {{ $year->year }}</p>
                    </header>
                </div>
            </div>
            <div class="row inner-top-sm">
                <div class="col-lg-3 inner-bottom-sm aos-init aos-animate" data-aos="fade-up"><h2>Meet us online</h2>
                    <p class="text-small">Want to learn more about us before taking the plunge? Find us on social media:
                        view our promotional video on YouTube, find our page or closed group on Facebook, or see our
                        innermost thoughts on Twitter.</p>
                    <a href="https://www.youtube.com/watch?v=QNWMdbrjxuE">
                        <i class="fab fa-youtube fa-2x"></i> <span
                                class="sr-only">YouTube</span> </a>
                    <a href="https://twitter.com/muusa1"> <i
                                class="fab fa-twitter fa-2x"></i> <span
                                class="sr-only">Twitter</span> </a>
                    <a href="https://www.facebook.com/{{ Auth::guest() ? 'Muusa2013/' : 'groups/Muusans/'}}">
                        <i class="fab fa-facebook fa-2x"></i> <span
                                class="sr-only">Facebook</span> </a>
                </div>
                <div class="col-lg-3 inner-bottom-sm aos-init aos-animate" data-aos="fade-up"><h2>Brochure</h2>
                    <p class="text-small">
                        @if($year->is_live)
                            The easiest way to learn all about MUUSA is to read the brochure, put out by our Planning
                            Council. It has it all: workshop descriptions, housing options, frequently asked questions,
                            and more.
                        @else
                            While you can register right now to reserve your spot, our Planning Council is working
                            diligently to prepare this year's brochure, which should be ready on February 1. You can
                            currently see last year's to get an idea of what it might contain.
                        @endif
                    </p>
                    <a href="{{ url('/brochure') }}" class="txt-btn">Take a look</a></div>
                <div class="col-lg-6 inner-left-xs aos-init aos-animate p-0" data-aos="fade-up">
                    <figure><img id="brochure" src="/images/brochure.png"></figure>
                </div>
            </div>
        </div>
    </section>

    <section id="services">
        <div class="container inner-top inner-bottom-sm">
            <div class="row">
                <div class="col-lg-8 col-md-9 mx-auto text-center aos-init aos-animate" data-aos="fade-up">
                    <header><h1>&quot;See you next week!&quot;</h1>
                        <p>Where you are welcomed to a warm and loving community. Where children are safe and cared for.
                            Where you’ll always be accepted. Where others share your values. Where your spirit will be
                            renewed!</p>
                    </header>
                </div>
            </div>
            <div class="row inner-top-sm text-center">
                <div class="col-md-4 inner-bottom-xs aos-init aos-animate" data-aos="fade-up">
                    <div class="icon"><i class="far fa-sitemap fa-3x"></i></div>
                    <h2>Programs</h2>
                    <p class="text-small text-left">Couples and singles, with and without children, can enjoy a variety
                        of workshop and recreational activities while children are in programs with others near their
                        own age, building friendships that will last well beyond the week of camp.</p>
                    <a href="{{ url('/programs') }}" class="txt-btn">Program Descriptions</a>
                </div>
                <div class="col-md-4 inner-bottom-xs aos-init aos-animate" data-aos="fade-up">
                    <div class="icon"><i class="far fa-bath fa-3x"></i></div>
                    <h2>Housing</h2>
                    <p class="text-small text-left">YMCA of the Ozarks, Trout Lodge, is located on 5,200 acres of pine
                        and oak forest on a private 360-acre lake 75 miles southwest of St. Louis, Missouri, outside of
                        Potosi. Accommodations are available for all budgets.</p>
                    <a href="{{ url('/housing') }}" class="txt-btn">Housing Options</a>
                </div>
                <div class="col-md-4 inner-bottom-xs aos-init aos-animate" data-aos="fade-up">
                    <div class="icon"><i class="fa fa-map fa-3x"></i></div>
                    <h2>Workshops</h2>
                    <p class="text-small text-left">Workshops offer opportunities for learning, personal growth, and
                        fun. They are an excellent way to get to know other campers in a small group setting and to
                        benefit from the wonderful talents, skills, and insights the workshop leaders have to offer.</p>
                    <a href="{{ url('/workshops') }}" class="txt-btn">
                        @if($year->is_live)
                            Workshop List
                        @else
                            Last Year's Workshops (Sample)
                        @endif
                    </a>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-md-4 inner-bottom-xs aos-init aos-animate" data-aos="fade-up">
                    <div class="icon"><i class="fa fa-fire fa-3x"></i></div>
                    <h2>Morning Celebrations</h2>
                    <p class="text-small text-left">Each morning, the Rev. Karen Mooney &amp; Rev. Pam Rumancik will
                        lead a multi-generational service on the theme topic. Services include children's stories and
                        choral music from the Awesome Choir, led by Pam Blevins Hinkle and accompanied by Bonnie
                        Ettinger.</p>
                    <a href="{{ url('/themespeaker') }}" class="txt-btn">Theme Speaker Biographies</a>
                </div>
                <div class="col-md-4 inner-bottom-xs aos-init aos-animate" data-aos="fade-up">
                    <div class="icon"><i class="far fa-universal-access fa-3x"></i></div>
                    <h2>Scholarship Opportunities</h2>
                    <p class="text-small text-left">If finances are tight and MUUSA doesn't quite fit into your budget
                        this year, we hope you will apply for a scholarship. These funds strengthen our community and we
                        want to be sure you know they are available.</p>
                    <a href="{{ url('/scholarship') }}" class="txt-btn">Application Process</a>
                </div>
                <div class="col-md-4 inner-bottom-xs aos-init aos-animate" data-aos="fade-up">
                    <div class="icon"><i class="fal fa-calculator fa-3x"></i></div>
                    <h2>Camp Cost Calculator</h2>
                    <p class="text-small text-left">Use this helpful tool to help estimate how much MUUSA will cost this
                        year. Please consider sharing a room with as many others as possible to reduce your cost and
                        make optimum use of housing. Full details can be found in the brochure.</p>
                    <a href="{{ url('/cost') }}" class="txt-btn">Full-Week Rates</a>
                </div>
            </div>
        </div>
    </section>

    <section id="testimonials" class="light-bg img-bg-softer"
             style="background-image: url(assets/images/art/pattern-background01.jpg);">
        <div class="container inner">
            <div class="row">
                <div class="col-lg-8 col-md-9 mx-auto text-center">
                    <header><h1>Quotes from the community</h1></header>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-md-9 mx-auto text-center">
                    <div id="owl-testimonials" class="owl-carousel owl-outer-nav owl-ui-md">
                        <div class="item">
                            <blockquote><p>When you hear about the kinds of experiences that change kids' lives, this is
                                    what they are talking about.</p>
                                <footer><cite>Karen S., Wheaton IL</cite></footer>
                            </blockquote>
                        </div>
                        <div class="item">
                            <blockquote>
                                <p>MUUSA is where I became a UU and where I return to renew my vows.</p>
                                <footer><cite>John S., Cincinnati OH</cite></footer>
                            </blockquote>
                        </div>
                        <div class="item">
                            <blockquote><p>I love that I started the week not knowing anyone except my children, but
                                    ended the week with lifelong friends.</p>
                                <footer><cite>Geeta P., Colorado Springs CO</cite></footer>
                            </blockquote>
                        </div>
                        <div class="item">
                            <blockquote><p>MUUSA is a true community for building meaningful friendships-- as well as a
                                    low stress family vacation where you are not always reaching for your wallet.</p>
                                <footer><cite>Roger E., Atlanta GA</cite></footer>
                            </blockquote>
                        </div>
                        <div class="item">
                            <blockquote><p>MUUSA gives me a space to deepen family bonds and recharge connections with
                                    my inner humanity.</p>
                                <footer><cite>Gregory R., Chicago IL</cite></footer>
                            </blockquote>
                        </div>
                        <div class="item">
                            <blockquote>
                                <p>Growing up at MUUSA helped teach me how to love and be loved.</p>
                                <footer><cite>Ellie M., Kalamazoo MI</cite></footer>
                            </blockquote>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="element-with-video-bg jquery-background-video-wrapper">
        <video data-bgvideo="true" class="jumpintoit jquery-background-video" loop autoplay muted playsinline
               poster="https://s3.us-east-2.amazonaws.com/muusa/jumpintoit.jpg">
            <source src="https://s3.us-east-2.amazonaws.com/muusa/jumpintoit.webm" type="video/webm"/>
        </video>
        <div class="container inner-sm pt-3" style="padding-bottom: 200px;">
            <div class="row">
                <div class="col-md-11 text-right aos-init aos-animate" data-aos="fade-up">
                    <h1 class="single-block" style="color: white;">
                        Join us.
                        <a href="{{ url('/registration') }}" class="btn btn-large">Register now</a>
                    </h1>
                </div>
            </div>
        </div>

    </section>
@endsection

@section('script')
    <script src="/js/jquery.background-video.js"></script>
@endsection