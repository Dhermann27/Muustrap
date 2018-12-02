<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="description"
          content="Midwest Unitarian Universalist Summer Assembly, located outside Potosi, Missouri (Formerly Lake Geneva Summer Assembly in Williams Bay, Wisconsin)">
    <meta name="author" content="Dan Hermann">
    <title>Midwest Unitarian Universalist Summer Assembly</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.5.0/css/all.css"
          integrity="sha384-j8y0ITrvFafF4EkV1mPW0BKm6dp3c+J9Fky22Man50Ofxo2wNe5pT1oZejDH9/Dt" crossorigin="anonymous">

    <link rel="stylesheet" href="/css/theme-style.min.css">
    <link rel="stylesheet" href="/css/colour-slate.min.css">
    <link rel="stylesheet" href="/css/muustrap.css" type="text/css"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Fira+Sans+Extra+Condensed|Krub"/>
    <link rel="shortcut icon" href="/favicon.ico">

    @role(['admin', 'council'])
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.min.css"/>
    @endrole

@yield('css')

<!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>

<body class="page page-index-static navbar-layout-default" data-plugins-localpath="/plugins/">
<a href="#content" id="top" class="sr-only">Skip to content</a>

<div id="header">
    <div data-toggle="sticky">

        <div class="header header-dark bg-dark bg-op-2 sticky-bg-op-9">
            <div class="header-inner container">

                <div class="header-block-flex order-1 mr-auto">
                    <nav class="nav nav-sm header-block-flex">
                        @if (Auth::guest())
                            <a href="{{ url('/login') }}" class="nav-link text-s text-uppercase d-md-block">Login</a>
                            <a href="{{ url('/register') }}" class="nav-link text-s text-uppercase d-md-block">Create
                                Account</a>
                        @else
                            <a href="{{ url('/logout') }}" class="nav-link text-s text-uppercase d-md-block"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                Logout
                            </a>

                            <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                                  style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        @endif
                        <div class="header-divider header-divider-sm"></div>
                        @if($home->year()->next_muse !== false)
                            <a href="{{ url('/themuse') }}"
                               class="nav-link text-s text-uppercase d-md-block">{{ $home->year()->next_muse }}</a>
                        @endif
                        @if($home->year()->is_live)
                            <a href="{{ url('MUUSA_' . $home->year()->year . '_Brochure.pdf') }}"
                               class="nav-link text-s text-uppercase d-md-block">Web Brochure</a>
                        @elseif(Auth::check() && $home->year()->is_workshop_proposal)
                            <a href="{{ url('/proposal') }}" class="nav-link text-s text-uppercase d-md-block">Workshop
                                Proposal</a>
                        @endif
                        <a href="{{ url('/contact') }}" class="nav-link text-s text-uppercase d-md-block">Contact Us</a>
                    </nav>
                </div>

                <!--branding/logo -->
                <div class="header-brand">
                    <a class="header-brand-text" href="/" title="Home">
                        <h1 class="h2">
                            <span class="header-brand-text-alt">App</span>Strap<span class="header-brand-text-alt">.</span>
                        </h1>
                    </a>
                    <div class="header-divider d-none d-lg-block"></div>
                    <div class="header-slogan d-none d-lg-block">Bootstrap 4 Theme</div>
                </div>
                <!-- other header content -->
                <div class="header-block order-12">

                    <!--Search trigger -->
                    <a href="#search" class="btn btn-icon btn-link text-white header-btn float-right order-11" data-toggle="search-form" data-target=".header-search"><i class="fa fa-search fa-flip-horizontal search-icon"></i></a>

                    <!-- mobile collapse menu button - data-toggle="collapse" = default BS menu - data-toggle="off-canvas" = Off-cavnas Menu - data-toggle="overlay" = Overlay Menu -->
                    <a href="#top" class="btn btn-link btn-icon text-white header-btn float-right d-lg-none" data-toggle="off-canvas" data-target=".navbar-main" data-settings='{"cloneTarget":true, "targetClassExtras": "navbar-offcanvas"}'> <i class="fa fa-bars"></i> </a>
                </div>

                <div class="navbar navbar-expand-md navbar-static-top">
                    <!--everything within this div is collapsed on mobile-->
                    <div class="navbar-main collapse">
                        <!--main navigation-->
                        <ul class="nav navbar-nav navbar-dark navbar-nav-stretch float-lg-right dropdown-effect-fade">

                            <!-- Homepages -->
                            <li class="nav-item dropdown dropdown-mega-menu active">
                                <a href="#" class="nav-link dropdown-toggle" id="indexs-drop" data-toggle="dropdown" data-hover="dropdown"> <i class="fa fa-home nav-link-icon"></i> <span class="d-none">Home</span> </a>
                                <!-- Dropdown Menu - mega menu-->
                                <div class="dropdown-menu">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <h4 class="dropdown-header d-none d-lg-block mt-0">
                                                Classic Homepages
                                            </h4>
                                            <div class="row">
                                                <div class="col-lg-6"> <a href="intro.html" class="dropdown-item">Intro</a> <a href="index.html" class="dropdown-item active">Homepage (default)</a> <a href="index-static.html" class="dropdown-item">Homepage No Slider</a> <a href="index-boxed.html" class="dropdown-item">Homepage Boxed</a> <a href="index-promo-header.html" class="dropdown-item">Promo Header</a> <a href="index-coming-soon.html" class="dropdown-item">Coming Soon</a> <a href="index-coming-soon-newsletter.html" class="dropdown-item">Coming Soon with newsletter</a> <a href="index-onepager.html" class="dropdown-item">One Pager Slideshow</a> </div>
                                                <div class="col-lg-6"> <a href="index-onepager-image.html" class="dropdown-item">One Pager Image</a> <a href="index-onepager-image-full-height.html" class="dropdown-item">One Pager Image Full Height</a> <a href="index-onepager-bg-slideshow.html" class="dropdown-item">One Pager Background Slideshow</a> <a href="index-onepager-dotted-menu-left.html" class="dropdown-item">One Pager Dotted Menu Left</a> <a href="index-onepager-dotted-menu-right.html" class="dropdown-item">One Pager Dotted Menu Right</a> <a href="index-onepager-dotted-menu-bottom.html" class="dropdown-item">One Pager Dotted Menu Bottom</a> <a href="index-onepager-submenu.html" class="dropdown-item">One Pager Submenu</a> </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <h4 class="dropdown-header d-none d-lg-block mt-0">
                                                Industry/Niche Homepages
                                            </h4>
                                            <div class="row">
                                                <div class="col-lg-6"> <a href="demo-travel-blog.html" class="dropdown-item">Travel Blog</a> <a href="index-app-landing.html" class="dropdown-item">App Landing Page</a> <a href="index-music.html" class="dropdown-item">Music Homepage</a> <a href="index-event.html" class="dropdown-item">Event Homepage</a> <a href="index-gym.html" class="dropdown-item">Gym Homepage</a> <a href="index-jobs.html" class="dropdown-item">Jobs Homepage</a> <a href="index-corporate.html" class="dropdown-item active">Corporate Homepage</a> <a href="index-restaurant.html" class="dropdown-item">Restaurant Homepage</a> <a href="index-photographer.html" class="dropdown-item">Photographer Homepage</a> </div>
                                                <div class="col-lg-6"> <a href="index-freelancer-portfolio.html" class="dropdown-item">Freelancer Homepage</a> <a href="index-wedding.html" class="dropdown-item">Wedding Homepage</a> <a href="index-realestate-single.html" class="dropdown-item">Real Estate (Single) Homepage</a> <a href="index-technology.html" class="dropdown-item">Technology Homepage</a> <a href="index-forum.html" class="dropdown-item">Forum Homepage</a> <a href="index-charity.html" class="dropdown-item">Charity Homepage</a> <a href="page-faq.html" class="dropdown-item">FAQ / Documentation</a> <a href="index-magazine.html" class="dropdown-item">Magazine Homepage</a> <a href="shop.html" class="dropdown-item">Shop Homepage</a> </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>


                <ul class="social">
                    <li><a href="https://www.youtube.com/watch?v=QNWMdbrjxuE">
                            <i class="icon-s-youtube"></i> <span
                                    class="sr-only">YouTube</span> </a></li>
                    <li><a href="https://twitter.com/muusa1"> <i
                                    class="icon-s-twitter"></i> <span
                                    class="sr-only">Twitter</span> </a></li>
                    <li><a href="https://www.facebook.com/{{ Auth::guest() ? 'Muusa2013/' : 'groups/Muusans/'}}">
                            <i class="icon-s-facebook"></i> <span
                                    class="sr-only">Facebook</span> </a>
                    </li>
                </ul>

                <a class="navbar-brand" href="/"><img src="/images/brand.png" class="logo" alt=""></a>

                <a class="navbar-toggler btn responsive-menu float-right" data-toggle="collapse"
                   data-target=".navbar-collapse"><i class='icon-menu-1'></i></a>

            </div>
        </div>


        <div class="yamm">
            <div class="navbar-collapse collapse">
                <div class="container">

                    <a class="navbar-brand" href="/">
                        <img src="/images/print_logo.png" class="logo"
                             alt="Midwest Unitarian Universalist Summer Assembly">
                    </a>

                    <ul class="nav navbar-nav">
                        @role(['admin', 'council'])
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Admin</a>

                            <ul class="dropdown-menu">

                                @role(['admin'])
                                <li class="dropdown-submenu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Administrator
                                        Functions</a>

                                    <ul class="dropdown-menu">
                                        <li><a href="{{ url('/household/f/0') }}">Create New Family</a></li>
                                        <li><a href="{{ url('/admin/distlist') }}">Distribution Lists</a></li>
                                        <li><a href="{{ url('/confirm/all') }}">Invoices (all)</a></li>
                                        <li><a href="{{ url('/admin/master') }}">Master Control Program</a></li>
                                        <li>
                                            <a href="{{ url('/confirm/letters') }}">Medical/Program Letters (all)</a>
                                        </li>
                                        <li><a href="{{ url('/admin/positions') }}">Staff Positions</a></li>
                                        <li><a href="{{ url('/admin/roles') }}">User Roles</a></li>
                                    </ul>
                                </li>
                                @endrole

                                <li class="dropdown-submenu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Reports</a>

                                    <ul class="dropdown-menu">
                                        <li><a href="{{ url('/reports/deposits') }}">Bank Deposits</a></li>
                                        <li><a href="{{ url('/reports/firsttime') }}">First-time Campers</a></li>
                                        <li><a href="{{ url('/reports/guarantee') }}">Guarantee Status</a></li>
                                        <li><a href="{{ url('/reports/payments') }}">Ledger</a></li>
                                        <li><a href="{{ url('/reports/outstanding') }}">Outstanding Balances</a></li>
                                        <li><a href="{{ url('/reports/programs') }}">Program Participants</a></li>
                                        <li><a href="{{ url('/reports/rates') }}">Rates</a></li>
                                        <li><a href="{{ url('/reports/campers') }}">Registered Campers</a></li>
                                        <li><a href="{{ url('/reports/chart') }}">Registration Chart</a></li>
                                        <li><a href="{{ url('/reports/roommates') }}">Roommates</a></li>
                                        <li><a href="{{ url('/reports/rooms') }}">Rooms</a></li>
                                        <li><a href="{{ url('/reports/states') }}">States &amp; Churches</a></li>
                                        <li><a href="{{ url('/reports/volunteers') }}">Volunteers</a></li>
                                        <li><a href="{{ url('/reports/workshops') }}">Workshop Attendees</a></li>
                                        <li><a href="{{ url('/reports/conflicts') }}">Workshop Conflicts</a></li>
                                    </ul>
                                </li>

                                <li class="dropdown-submenu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Tools</a>

                                    <ul class="dropdown-menu">
                                        <li><a href="{{ url('/coffeehouse') }}">Coffeehouse Schedule</a></li>
                                        <li>
                                            <a href="{{ url('/tools/cognoscenti') }}">Cognoscenti (Planning Council)</a>
                                        </li>
                                        <li><a href="{{ url('/tools/nametags') }}">Nametag Printer</a></li>
                                        <li><a href="{{ url('/tools/nametags/all') }}">Nametags (all)</a></li>
                                        <li><a href="{{ url('/tools/programs') }}">Programs</a></li>
                                        <li><a href="{{ url('/roomselection/map') }}">Room Selection Map</a></li>
                                        <li><a href="{{ url('/tools/staffpositions') }}">Staff Assignments</a></li>
                                        <li><a href="{{ url('/tools/workshops') }}">Workshops</a></li>
                                    </ul>
                                </li>

                            </ul>
                        </li>
                        @endrole

                        <li class="dropdown">
                            <a href="{{ url('/registration') }}" class="dropdown-toggle"
                               data-toggle="dropdown">Register</a>

                            <ul class="dropdown-menu">
                                @if (Auth::guest())
                                    <li><a href="{{ url('/login') }}">Login</a>
                                    </li>
                                    <li><a href="{{ url('/register') }}">Create Account</a></li>
                                @elseif(true)
                                    <li><a href="{{ url('/registration') }}"><i class="far fa-chevron-right fa-fw"></i>
                                            Start Registration</a>
                                    </li>
                                @else
                                    <li><a href="{{ url('/household') }}"><i class="far fa-home fa-fw"></i>
                                            Household</a>
                                    </li>
                                    <li><a href="{{ url('/camper') }}"><i class="far fa-users fa-fw"></i> Campers</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/payment') }}"><i class="far fa-usd-square fa-fw"></i> Payment</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/workshopchoice') }}"><i class="far fa-rocket fa-fw"></i>
                                            Workshops</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/roomselection') }}"><i class="far fa-bed fa-fw"></i> Room
                                            Selection</a>
                                    </li>
                                    <li><a href="{{ url('/nametag') }}"><i class="far fa-id-card fa-fw"></i>
                                            Nametags</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/confirm') }}"><i class="far fa-envelope fa-fw"></i>
                                            Confirmation</a>
                                    </li>
                                @endif
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="{{ url('/information') }}" class="dropdown-toggle" data-toggle="dropdown">Information</a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{ url('/cost') }}"><i class="far fa-calculator fa-fw"></i> Cost Calculator</a>
                                </li>
                                <li>
                                    <a href="{{ url('/excursions') }}"><i class="far fa-binoculars fa-fw"></i>
                                        Excursions</a>
                                </li>
                                <li><a href="{{ url('/housing') }}"><i class="far fa-bath fa-fw"></i> Housing
                                        Options</a></li>
                                <li><a href="{{ url('/programs') }}"><i class="far fa-sitemap fa-fw"></i> Programs</a>
                                </li>
                                <li>
                                    <a href="{{ url('/themespeaker') }}"><i class="far fa-microphone fa-fw"></i> Theme
                                        Speakers</a>
                                </li>
                                <li><a href="{{ url('/workshops') }}"><i class="far fa-map fa-fw"></i> Workshop List</a>
                                </li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Your Details</a>
                            <ul class="dropdown-menu">
                                @if (Auth::guest())
                                    <li><a href="{{ url('/login') }}">Login</a>
                                    </li>
                                @else
                                    @if($year->is_artfair)
                                        <li>
                                            <a href="{{ url('/artfair') }}">
                                                <i class="far fa-shopping-bag fa-fw"></i>
                                                Art Fair Submission
                                            </a>

                                        </li>
                                    @endif
                                    @if($year->is_calendar)
                                        <li>
                                            <a href="{{ url('/calendar') }}">
                                                <i class="far fa-calendar-alt fa-fw"></i> Daily Schedule
                                            </a>
                                        </li>
                                    @endif
                                    @if($year->next_muse !== false)
                                        <li>
                                            <a href="{{ url('/themuse') }}">
                                                <i class="fal fa-newspaper fa-fw"></i> {{ $year->next_muse }}
                                            </a>
                                        </li>
                                    @endif
                                    <li>
                                        <a href="{{ url('/directory') }}">
                                            <i class="far fa-address-book fa-fw"></i> Online Directory
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/volunteer') }}">
                                            <i class="far fa-handshake fa-fw"></i> Volunteer Opportunities
                                        </a>
                                    </li>
                                    @if($year->is_live)
                                        <li><a href="{{ url('/brochure') }}">
                                                <i class="far fa-desktop fa-fw"></i> Web Brochure
                                            </a>
                                        </li>
                                    @endif
                                    @if($year->is_workshop_proposal)
                                        <li><a href="{{ url('/proposal') }}">
                                                <i class="fal fa-chalkboard-teacher fa-fw"></i> Workshop Proposal
                                            </a>
                                        </li>
                                    @endif
                                @endif
                            </ul>
                        </li>

                        <li class="dropdown"><a href="{{ url('/contact') }}">Contact Us</a></li>

                    </ul>
                </div>
            </div>
        </div>
    </div>

    @role(['admin', 'council'])
    <div class="input-group p-0 m-0">
        <div class="input-group-prepend">
            @include('admin.controls', ['id' =>  (preg_match('/\/(c|f)\/\d+$/', $_SERVER['REQUEST_URI'], $matches) ? substr($_SERVER['REQUEST_URI'], -6) : 'c/0'), 'inputgroup' => 'true'])
        </div>

        <input type="text" id="camper" class="form-control camperlist" placeholder="Camper Name"/>
    </div>
    @endrole
</header>

<main class="js-reveal">

    @hassection('title')
        <section id="hero" class="light-bg img-bg-bottom img-bg-softer"
                 style="background-image: url(/images/jumbotron.jpg);">
            <div class="container inner">
                <div class="row">
                    <div class="col-lg-8 col-md-9 aos-init aos-animate" data-aos="fade-up">
                        <header>
                            <h1>
                                @yield('title')
                            </h1>
                            @hassection('heading')
                                <h3>
                                    @yield('heading')
                                </h3>
                            @endif
                        </header>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @hassection('multisection')
        @yield('multisection')
    @else
        <section>
            <div class="inner-top inner-left-sm aos-init aos-animate p-5" data-aos="fade-up">
                @yield('content')
            </div>
        </section>
    @endif
</main>

<footer class="dark-bg">
    <div class="container inner">
        <div class="row">

            <div class="col-lg-4 col-md-6 inner">
                <h4>Important Dates</h4>
                <ul>
                    <li><strong>February 1</strong>: Workshop registration and scholarship applications open. Housing
                        selection and changes open to all campers who have paid their deposit.
                    </li>
                    <li><strong>April 15</strong>: Scholarship applications due.</li>
                    <li><strong>May 15</strong>: Scholarships granted and applicants notified of awards.</li>
                    <li><strong>May 31</strong>: Deadline for cancellations. Deposits will not be refunded for
                        cancellations after May 31.
                    </li>
                </ul>
            </div>

            <div class="col-lg-4 col-md-6 inner">
                <h4>Get In Touch</h4>
                <p>Mail checks to the address below, or email our Registrar with questions.</p>
                <ul class="contacts">
                    <li><i class="far fa-money-check-alt fa-fw"></i> 423 N Waiola Ave., La Grange Park, IL 60526</li>
                    <li><a href="mailto:registrar@muusa.org"><i class="far fa-envelope fa-fw"></i>
                            registrar@muusa.org</a>
                    </li>
                </ul>
            </div>

            <div class="col-lg-4 col-md-6 inner">
                <h4>Mailing List</h4>
                <p>Interested in receiving our web brochure when it is published in February?</p>
                <form id="mailinglist" class="form-inline newsletter" role="form" method="POST"
                      action="{{ url('/mailinglist') }}">
                    <label class="sr-only" for="email">Email address</label>
                    <input type="email" class="form-control" id="email" required
                           placeholder="Enter your email address">
                    <button type="submit" class="btn btn-submit">Sign Up</button>
                </form>
            </div>

        </div>
    </div>

    <div class="footer-bottom">
        <div class="container inner clearfix">
            <p class="float-left">&copy; {{ $year->year }} Midwest Unitarian Universalist Summer Assembly. All rights
                reserved.</p>
            <ul class="footer-menu float-right">
                <li><a href="/">Home</a></li>
                <li><a href="{{ url('/registration') }}">Register</a></li>
                <li><a href="{{ url('/information') }}">Information</a></li>
                <li><a href="{{ url('/contact') }}">Contact</a></li>
            </ul>
        </div>
    </div>
</footer>


<script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>


<script type="text/javascript">
    function nextCamper() {
        var next = $('.nav-tabs .active').parent().next('li').find('a');
        if (next !== undefined && next.attr("id") !== 'newcamper') {
            next.tab('show');
            $('html,body').animate({
                scrollTop: 0
            }, 700);
        } else {
            $('input[type="submit"]').trigger("focus");
            $('html,body').animate({
                scrollTop: 9999
            }, 100);
        }
    }

    $('button.nextcamper').click(nextCamper);

    $('form#mailinglist button:submit').on('click', function (e) {
        e.preventDefault();
        var form = $("form#mailinglist");
        $(this).val("Sending").removeClass("btn-success btn-danger").prop("disabled", true);
        $.ajax({
            url: form.attr("action"),
            type: 'post',
            data: form.serialize(),
            success: function () {
                $("button:submit").val("Success").addClass("btn-success").prop("disabled", false);
            },
            error: function () {
                $("input:submit").val("Error").addClass("btn-danger").prop("disabled", false);
            }
        });
    });
</script>
@role(['admin', 'council'])
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.min.js"
        integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
<script type="text/javascript">
    @if(isset($readonly) && $readonly === true)
    $("input:not(#camper), select").prop("disabled", "true");
    @endif
    $('[data-toggle="tooltip"]').tooltip({
        content: function () {
            return this.getAttribute("title");
        }
    });
    $("select.orderby").on('change', function (e) {
        e.preventDefault();
        window.location = $("#orderby-url").val() + "/" + $("#orderby-years").val() + "/" + $("#orderby-order").val();
    });
    $('input.camperlist').each(function () {
        $(this).autocomplete({
            source: "/data/camperlist",
            minLength: 3,
            autoFocus: true,
            select: function (event, ui) {
                $(this).val(ui.item.lastname + ", " + ui.item.firstname);
                $("input#" + $(this).attr("id") + "id").val(ui.item.id);
                $(this).prev().find("a.dropdown-item").each(function () {
                    $(this).attr("href", $(this).attr("href").replace(/\/c\/\d+$/, "/c/" + ui.item.id));
                });
                return false;
            }
        }).autocomplete('instance')._renderItem = function (ul, item) {
            return $("<li>").append("<div>" + item.lastname + ", " + item.firstname + "</div>").appendTo(ul);
        };
    });
</script>
@endrole
@role(['admin'])
<script type="text/javascript">
    $('tbody.editable td').on('click', function () {
        var tr = $(this).parent('tr');
        var index = tr.children().index($(this));
        var th = $(this).parents('table').find('thead th')[index];
        if (th.id !== "") {
            if (th.className === "") {
                $(this).html('<input name="' + tr.attr('id') + '-' + th.id + '" value="' + $(this).text() + '" />');
            } else if (th.className === 'select' && $("select." + th.id).length > 0) {
                var select = $("select." + th.id).first().clone();
                select.attr('id', '').attr('name', tr.attr('id') + '-' + th.id).removeClass(th.id);
                $(this).html(select);
            }
            $(this).off('click');
        }
    });
</script>
@endrole

@yield('script')

</body>
</html>
