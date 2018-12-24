<!DOCTYPE html>
<html lang="en">
<head>
    <title>Landing Page Homepage | AppStrap Bootstrap Theme by Themelize.me</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>

    <meta name="description"
          content="Midwest Unitarian Universalist Summer Assembly, located outside Potosi, Missouri (Formerly Lake Geneva Summer Assembly in Williams Bay, Wisconsin)">
    <meta name="author" content="Dan Hermann">
    <title>Midwest Unitarian Universalist Summer Assembly</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.5.0/css/all.css"
          integrity="sha384-j8y0ITrvFafF4EkV1mPW0BKm6dp3c+J9Fky22Man50Ofxo2wNe5pT1oZejDH9/Dt" crossorigin="anonymous">

    <link href="/assets/css/theme-style.min.css" rel="stylesheet">
    <link href="/assets/css/colour-slate.min.css" rel="stylesheet">

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png?v=bOMnaKo3RO"/>
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png?v=bOMnaKo3RO"/>
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png?v=bOMnaKo3RO"/>
    <link rel="manifest" href="/site.webmanifest?v=bOMnaKo3RO"/>
    <link rel="mask-icon" href="/safari-pinned-tab.svg?v=bOMnaKo3RO" color="#5bbad5"/>
    <link rel="shortcut icon" href="/favicon.ico?v=bOMnaKo3RO"/>
    <meta name="apple-mobile-web-app-title" content="MUUSA"/>
    <meta name="application-name" content="MUUSA"/>
    <meta name="msapplication-TileColor" content="#da532c"/>
    <meta name="theme-color" content="#ffffff"/>

    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,300' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Rambla:400,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Calligraffitti' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto+Slab:400,700' rel='stylesheet' type='text/css'>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/retina.js/1.3.0/retina.min.js"></script>

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

<body class="page page-index navbar-layout-default">

<a id="#top" href="#content" class="sr-only">Skip to content</a>

<div id="header">

    <div class="header-upper">
        <div class="header-inner container">
            <div class="header-block-flex order-1 mr-auto">
                <nav class="nav nav-sm header-block-flex">
                    @if (Auth::guest())
                        <a href="{{ url('/login') }}" class="nav-link text-s text-uppercase">Login</a>
                        <a href="{{ url('/register') }}" class="nav-link text-s text-uppercase">Create
                            Account</a>
                    @else
                        <a href="{{ url('/logout') }}" class="nav-link text-s text-uppercase"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            Logout
                        </a>

                        <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                              style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    @endif
                    @if($year->next_muse !== false)
                        <div class="header-divider header-divider-sm"></div>
                        <a href="{{ url('/themuse') }}"
                           class="nav-link text-s text-uppercase d-md-block">{{ $home->year()->next_muse }}</a>
                    @endif
                </nav>
            </div>
            <div class="nav nav-icons header-block order-12">
                <a href="https://www.facebook.com/{{ Auth::guest() ? 'Muusa2013/' : 'groups/Muusans/'}}"
                   class="nav-link"> <i class="fab fa-facebook-square icon-1x"></i> <span
                            class="sr-only">Facebook</span> </a>
                <a href="https://twitter.com/muusa1" class="nav-link"> <i class="fab fa-twitter-square icon-1x"></i>
                    <span class="sr-only">Twitter</span> </a>
                <a href="https://www.youtube.com/watch?v=QNWMdbrjxuE" class="nav-link"> <i
                            class="fab fa-youtube-square icon-1x"></i> <span class="sr-only">YouTube</span> </a>
            </div>
        </div>
    </div>
    <div data-toggle="sticky">

        <!--Header & Branding region-->
        <div class="header">
            <!-- all direct children of the .header-inner element will be vertically aligned with each other you can override all the behaviours using the flexbox utilities (flexbox.html) All elements with .header-brand & .header-block-flex wrappers will automatically be aligned inline & vertically using flexbox, this can be overridden using the flexbox utilities (flexbox.htm) Use .header-block to stack elements within on small screen & "float" on larger screens use .order-first or/and .order-last classes to make an element show first or last within .header-inner or .headr-block elements -->
            <div class="header-inner container">
                <!--branding/logo -->
                <div class="header-brand">
                    <a class="header-brand-text" href="/" title="Home">
                        <img src="/images/brand35.png" class="logo"
                             alt="Midwest Unitarian Universalist Summer Assembly">
                    </a>
                    <div class="header-divider d-none d-lg-block"></div>
                    <div class="header-slogan d-none d-lg-block">Midwest Unitarian Universalist Summer Assembly</div>
                </div>
                <!-- other header content -->
                <div class="header-block order-12">

                    <!-- mobile collapse menu button - data-toggle="collapse" = default BS menu - data-toggle="off-canvas" = Off-cavnas Menu - data-toggle="overlay" = Overlay Menu -->
                    <a href="#top" class="btn btn-link btn-icon header-btn float-right d-lg-none"
                       data-toggle="off-canvas" data-target=".navbar-main"
                       data-settings='{"cloneTarget":true, "targetClassExtras": "navbar-offcanvas"}'> <i
                                class="fa fa-bars"></i> </a>
                    <!--Show/hide trigger for #offcanvas-sidebar -->
                    <a href="#" title="Click me you'll get a surprise"
                       class="btn btn-icon btn-link header-btn float-right order-last" data-toggle="off-canvas"
                       data-target="#offcanvas-sidebar" data-settings='{"cloneTarget":false}'> <i
                                class="ion-android-more-vertical"></i> </a>
                </div>

                <div class="navbar navbar-expand-md navbar-static-top">
                    <!--everything within this div is collapsed on mobile-->
                    <div class="navbar-main collapse">
                        <!--main navigation-->
                        <ul class="nav navbar-nav navbar-nav-stretch float-lg-right dropdown-effect-fade">

                            <!-- Pages -->
                            @role(['admin', 'council'])
                            <li class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" id="admin-drop" data-toggle="dropdown"
                                   data-hover="dropdown">Admin</a>
                                <!-- Menu -->
                                <div class="dropdown-menu">

                                    @role(['admin'])
                                    <div class="dropdown dropdown-submenu">
                                        <a href="#" class="dropdown-item dropdown-toggle" id="func-drop"
                                           data-toggle="dropdown" data-hover="dropdown" data-close-others="false">
                                            Administrator Functions</a>
                                        <div class="dropdown-menu" role="menu" aria-labelledby="func-drop">
                                            <a href="{{ url('/household/f/0') }}" class="dropdown-item">Create New
                                                Family</a>
                                            <a href="{{ url('/admin/distlist') }}" class="dropdown-item">Distribution
                                                Lists</a>
                                            <a href="{{ url('/confirm/all') }}" class="dropdown-item">Invoices (all)</a>
                                            <a href="{{ url('/admin/master') }}" class="dropdown-item">Master Control
                                                Program</a>
                                            <a href="{{ url('/confirm/letters') }}" class="dropdown-item">Medical/Program
                                                Letters (all)</a>
                                            <a href="{{ url('/admin/positions') }}" class="dropdown-item">Staff
                                                Positions</a>
                                            <a href="{{ url('/admin/roles') }}" class="dropdown-item">User Roles</a>
                                        </div>
                                    </div>
                                    @endrole

                                    <div class="dropdown dropdown-submenu">
                                        <a href="#" class="dropdown-item dropdown-toggle" id="report-drop"
                                           data-toggle="dropdown" data-hover="dropdown" data-close-others="false">
                                            Reports</a>
                                        <div class="dropdown-menu" role="menu" aria-labelledby="func-drop">
                                            <a href="{{ url('/reports/deposits') }}" class="dropdown-item">Bank
                                                Deposits</a>
                                            <a href="{{ url('/reports/firsttime') }}" class="dropdown-item">First-time
                                                Campers</a>

                                            <a href="{{ url('/reports/guarantee') }}" class="dropdown-item">Guarantee
                                                Status</a>
                                            <a href="{{ url('/reports/payments') }}" class="dropdown-item">Ledger</a>
                                            <a href="{{ url('/reports/outstanding') }}" class="dropdown-item">Outstanding
                                                Balances</a>

                                            <a href="{{ url('/reports/programs') }}" class="dropdown-item">Program
                                                Participants</a>

                                            <a href="{{ url('/reports/rates') }}" class="dropdown-item">Rates</a>
                                            <a href="{{ url('/reports/campers') }}" class="dropdown-item">Registered
                                                Campers</a>
                                            <a href="{{ url('/reports/chart') }}" class="dropdown-item">Registration
                                                Chart</a>
                                            <a href="{{ url('/reports/roommates') }}"
                                               class="dropdown-item">Roommates</a>
                                            <a href="{{ url('/reports/rooms') }}" class="dropdown-item">Rooms</a>
                                            <a href="{{ url('/reports/states') }}" class="dropdown-item">States &amp;
                                                Churches</a>

                                            <a href="{{ url('/reports/volunteers') }}"
                                               class="dropdown-item">Volunteers</a>
                                            <a href="{{ url('/reports/workshops') }}" class="dropdown-item">Workshop
                                                Attendees</a>

                                            <a href="{{ url('/reports/conflicts') }}" class="dropdown-item">Workshop
                                                Conflicts</a>
                                        </div>
                                    </div>

                                    <div class="dropdown dropdown-submenu">
                                        <a href="#" class="dropdown-item dropdown-toggle" id="report-drop"
                                           data-toggle="dropdown" data-hover="dropdown" data-close-others="false">
                                            Tools</a>
                                        <div class="dropdown-menu" role="menu" aria-labelledby="func-drop">
                                            <a href="{{ url('/coffeehouse') }}" class="dropdown-item">Coffeehouse
                                                Schedule</a>
                                            <a href="{{ url('/tools/cognoscenti') }}" class="dropdown-item">Cognoscenti
                                                (Planning
                                                Council)</a>

                                            <a href="{{ url('/tools/nametags') }}" class="dropdown-item">Nametag
                                                Printer</a>
                                            <a href="{{ url('/tools/nametags/all') }}" class="dropdown-item">Nametags
                                                (all)</a>
                                            <a href="{{ url('/tools/programs') }}" class="dropdown-item">Programs</a>
                                            <a href="{{ url('/roomselection/map') }}" class="dropdown-item">Room
                                                Selection
                                                Map</a>

                                            <a href="{{ url('/tools/staffpositions') }}" class="dropdown-item">Staff
                                                Assignments</a>

                                            <a href="{{ url('/tools/workshops') }}" class="dropdown-item">Workshops</a>
                                        </div>

                                    </div>

                                </div>
                            </li>
                            @endrole

                            <li class="nav-item dropdown">
                                <a href="{{ url('/registration') }}" class="nav-link dropdown-toggle" id="pages-drop"
                                   data-toggle="dropdown" data-hover="dropdown">Register</a>

                                <div class="dropdown-menu">
                                    @if (Auth::guest())
                                        <a href="{{ url('/login') }}" class="dropdown-item">Login</a>
                                        <a href="{{ url('/register') }}" class="dropdown-item">Create Account</a>
                                    @elseif(true)
                                        <a href="{{ url('/registration') }}" class="dropdown-item">
                                            <i class="far fa-chevron-right fa-fw"></i> Start Registration</a>
                                    @else
                                        <a href="{{ url('/household') }}" class="dropdown-item">
                                            <i class="far fa-home fa-fw"></i> Household</a>
                                        <a href="{{ url('/camper') }}" class="dropdown-item">
                                            <i class="far fa-users fa-fw"></i> Campers</a>
                                        <a href="{{ url('/payment') }}" class="dropdown-item">
                                            <i class="far fa-usd-square fa-fw"></i> Payment</a>
                                        <a href="{{ url('/workshopchoice') }}" class="dropdown-item">
                                            <i class="far fa-rocket fa-fw"></i> Workshops</a>
                                        <a href="{{ url('/roomselection') }}" class="dropdown-item">
                                            <i class="far fa-bed fa-fw"></i> Room Selection</a>
                                        <a href="{{ url('/nametag') }}" class="dropdown-item">
                                            <i class="far fa-id-card fa-fw"></i> Nametags</a>
                                        <a href="{{ url('/confirm') }}" class="dropdown-item">
                                            <i class="far fa-envelope fa-fw"></i> Confirmation</a>
                                    @endif
                                </div>
                            </li>

                            <li class="nav-item dropdown">
                                <a href="{{ url('/information') }}" class="nav-link dropdown-toggle" id="info-drop"
                                   data-toggle="dropdown" data-hover="dropdown">Information</a>
                                <div class="dropdown-menu">
                                    <a href="{{ url('/housing') }}" class="dropdown-item">
                                        <i class="far fa-bath fa-fw"></i> Housing Options</a>
                                    <a href="{{ url('/programs') }}" class="dropdown-item">
                                        <i class="far fa-sitemap fa-fw"></i> Programs</a>
                                    <a href="{{ url('/workshops') }}" class="dropdown-item">
                                        <i class="far fa-map fa-fw"></i> Workshop List</a>
                                    <a href="{{ url('/themespeaker') }}" class="dropdown-item">
                                        <i class="far fa-microphone fa-fw"></i> Theme Speakers</a>
                                    <a href="{{ url('/cost') }}" class="dropdown-item">
                                        <i class="far fa-calculator fa-fw"></i> Cost Calculator</a>
                                    <a href="{{ url('/excursions') }}" class="dropdown-item">
                                        <i class="far fa-binoculars fa-fw"></i> Excursions</a>
                                </div>
                            </li>

                            @if (Auth::check())
                                <li class="nav-item dropdown">
                                    <a href="#" class="nav-link dropdown-toggle" id="details-drop"
                                       data-toggle="dropdown"
                                       data-hover="dropdown">Your Details</a>
                                    <div class="dropdown-menu">
                                        @if($year->is_live)
                                            <a href="{{ url('/brochure') }}" class="dropdown-item">
                                                <i class="far fa-desktop fa-fw"></i> Web Brochure</a>
                                        @endif
                                        @if($year->is_calendar)
                                            <a href="{{ url('/calendar') }}" class="dropdown-item">
                                                <i class="far fa-calendar-alt fa-fw"></i> Daily Schedule</a>
                                        @endif
                                        @if($year->next_muse !== false)
                                            <a href="{{ url('/themuse') }}" class="dropdown-item">
                                                <i class="fal fa-newspaper fa-fw"></i> {{ $year->next_muse }}</a>
                                        @endif
                                        <a href="{{ url('/directory') }}" class="dropdown-item">
                                            <i class="far fa-address-book fa-fw"></i> Online Directory</a>
                                        @if($year->is_artfair)
                                            <a href="{{ url('/artfair') }}" class="dropdown-item">
                                                <i class="far fa-shopping-bag fa-fw"></i> Art Fair Submission</a>
                                        @endif
                                        <a href="{{ url('/volunteer') }}" class="dropdown-item">
                                            <i class="far fa-handshake fa-fw"></i> Volunteer Opportunities</a>
                                        @if($year->is_workshop_proposal)
                                            <a href="{{ url('/proposal') }}" class="dropdown-item">
                                                <i class="fal fa-chalkboard-teacher fa-fw"></i> Workshop Proposal
                                            </a>
                                        @endif
                                    </div>
                                </li>
                            @endif

                            <li class="nav-item"><a href="{{ url('/contact') }}" class="nav-link">Contact Us</a></li>
                        </ul>
                    </div>
                    <!--/.navbar-collapse -->
                </div>
            </div>


            {{--@role(['admin', 'council'])--}}
            <div class="input-group p-0 m-0">
                <div class="input-group-prepend">
                    @include('admin.controls', ['id' =>  (preg_match('/\/(c|f)\/\d+$/', $_SERVER['REQUEST_URI'], $matches) ? substr($_SERVER['REQUEST_URI'], -6) : 'c/0'), 'inputgroup' => 'true'])
                </div>

                <input type="text" id="camper" class="form-control camperlist" placeholder="Camper Name"/>
            </div>
            {{--@endrole--}}
        </div>
    </div>
</div>

<!-- ======== @Region: #content ======== -->
<div id="content" class="p-0">
    <!-- Video background MDR -->
    <div class="p-3 p-lg-5 bg-light text-center overlay overlay-dark overlay-op-5"
         data-bg-video="assets/videos/bubbles.mp4" data-animate="fadeIn">
        <div class="container">
            <h2 class="text-white display-4 text-shadow">
                Add some <span class="font-italic font-weight-bold">fizz</span> to your next website!
            </h2>
            <a href="https://wrapbootstrap.com/theme/appstrap-responsive-website-template-WB0C6D0H4?ref=tme"
               class="btn btn-xlg btn-rounded btn-primary mt-4">Get AppStrap!</a>

        </div>
    </div>
</div>

<footer id="footer" class="p-0">
    <div class="container pt-6 pb-5">
        <div class="row">
            <div class="col-md-4">
                <h4 class="text-uppercase text-white">Important Dates</h4>
                <ul>
                    <li><strong>February 1</strong>: Workshop registration and scholarship applications
                        open. Housing
                        selection and changes open to all campers who have paid their deposit.
                    </li>
                    <li><strong>April 15</strong>: Scholarship applications due.</li>
                    <li><strong>May 15</strong>: Scholarships granted and applicants notified of awards.
                    </li>
                    <li><strong>May 31</strong>: Deadline for cancellations. Deposits will not be refunded
                        for
                        cancellations after May 31.
                    </li>
                </ul>
            </div>

            <div class="col-md-4">
                <h4 class="text-uppercase text-white">
                    Get In Touch</h4>
                <p>Mail checks to the address below, or email our Registrar with questions.</p>
                <address>
                    <p><abbr title="Address"><i class="far fa-money-check-alt fa-fw"></i> 423 N Waiola Avenue<br/>
                            La Grange Park, IL 60526</abbr></p>
                    <p><abbr title="Email">
                            <a href="mailto:registrar@muusa.org">
                                <i class="far fa-envelope fa-fw"></i>registrar@muusa.org
                            </a>
                        </abbr></p>
                </address>

            </div>

            <div class="col-md-4">
                <h4 class="text-uppercase text-white">
                    Mailing List</h4>
                <p>Interested in receiving our web brochure when it is published in February?</p>
                <form id="mailinglist" role="form" method="POST"
                      action="{{ url('/mailinglist') }}">
                    <div class="input-group">
                        <label class="sr-only" for="email-field">Email</label>
                        <input type="text" class="form-control" id="email-field" placeholder="Enter your email address">
                        <span class="input-group-append">
                  <button class="btn btn-primary" type="button">Signup</button>
                </span>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <hr class="my-0 hr-blank op-2"/>
    <div class="bg-inverse-dark text-sm py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <p class="mb-0">Site template by <a href="http://themelize.me/" class="footer-link">AppStrap</a> |
                        Copyright {{ $year->year }} &copy; Midwest Unitarian Universalist Summer Assembly</p>
                </div>
                <div class="col-md-4">
                    <ul class="list-inline footer-links float-md-right mb-0">
                        <li class="list-inline-item"><a href="/">Home</a></li>
                        <li class="list-inline-item"><a href="{{ url('/registration') }}">Register</a></li>
                        <li class="list-inline-item"><a href="{{ url('/information') }}">Information</a></li>
                        <li class="list-inline-item"><a href="{{ url('/contact') }}">Contact</a></li>
                    </ul>
                </div>
            </div>
            <a href="#top" class="btn btn-icon btn-dark pos-fixed pos-b pos-r mr-3 mb-3 scroll-state-hidden"
               title="Back to top" data-scroll="scroll-state"><i class="fa fa-chevron-up"></i></a>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>

<script src="assets/js/custom-script.js"></script>
<script src="assets/js/script.min.js"></script>

@yield('script')

</body>
</html>