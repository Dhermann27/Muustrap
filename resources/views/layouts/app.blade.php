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
    <div class="header-upper">
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
        <div class="header header-dark bg-dark bg-op-1 border-primary border-op-4 sticky-bg-dark sticky-bg-op-9">
            <div class="header-inner container">
                <div class="header-brand">
                    <a class="header-brand-text" href="/" title="Home">
                        <img src="/images/print_logo.png" class="logo"
                             alt="Midwest Unitarian Universalist Summer Assembly">
                    </a>
                    <div class="header-divider d-none d-lg-block"></div>
                    <div class="header-slogan d-none d-lg-block">MUUSA</div>
                </div>

                <div class="header-block d-flex order-12 align-items-center">
                    <!-- mobile collapse menu button - data-toggle="collapse" = default BS menu - data-toggle="off-canvas" = Off-cavnas Menu - data-toggle="overlay" = Overlay Menu -->
                    <a href="#top" class="btn btn-icon btn-white ml-2 order-12 d-lg-none" data-toggle="off-canvas"
                       data-target=".navbar-main"
                       data-settings='{"cloneTarget":true, "targetClassExtras": "navbar-offcanvas"}'> <i
                                class="fa fa-bars"></i> </a>
                    <a href="{{ url('/registration') }}" data-toggle="scroll-link"
                       class="btn btn-primary btn-sm text-uppercase font-weight-bold px-lg-3 py-lg-2 ml-lg-3">Register
                        <span class="d-none d-lg-inline-block">Now</span></a>
                </div>

                <div class="navbar navbar-expand-md navbar-static-top">
                    <!--everything within this div is collapsed on mobile-->
                    <div class="navbar-main collapse ">
                        <!--main navigation-->
                        <ul class="nav navbar-nav navbar-nav-stretch float-lg-right dropdown-effect-fade">

                            @role(['admin', 'council'])
                            <li class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" id="admin-drop" data-toggle="dropdown"
                                   data-hover="dropdown">Admin</a>

                                @role(['admin'])
                                <div class="dropdown-menu">
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
                                </div>
                                @endrole

                                <div class="dropdown-menu">
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
                                    <a href="{{ url('/cost') }}" class="dropdown-item">
                                        <i class="far fa-calculator fa-fw"></i> Cost Calculator</a>
                                    <a href="{{ url('/excursions') }}" class="dropdown-item">
                                        <i class="far fa-binoculars fa-fw"></i> Excursions</a>
                                    <a href="{{ url('/housing') }}" class="dropdown-item">
                                        <i class="far fa-bath fa-fw"></i> Housing Options</a>
                                    <a href="{{ url('/programs') }}" class="dropdown-item">
                                        <i class="far fa-sitemap fa-fw"></i> Programs</a>
                                    <a href="{{ url('/themespeaker') }}" class="dropdown-item">
                                        <i class="far fa-microphone fa-fw"></i> Theme Speakers</a>
                                    <a href="{{ url('/workshops') }}" class="dropdown-item">
                                        <i class="far fa-map fa-fw"></i> Workshop List</a>
                                </div>
                            </li>

                            <li class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" id="details-drop" data-toggle="dropdown"
                                   data-hover="dropdown">Your Details</a>
                                <div class="dropdown-menu">
                                    @if (Auth::guest())
                                        <a href="{{ url('/login') }}" class="dropdown-item">Login</a>
                                    @else
                                        @if($year->is_artfair)
                                            <a href="{{ url('/artfair') }}" class="dropdown-item">
                                                <i class="far fa-shopping-bag fa-fw"></i> Art Fair Submission</a>
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
                                        <a href="{{ url('/volunteer') }}" class="dropdown-item">
                                            <i class="far fa-handshake fa-fw"></i> Volunteer Opportunities</a>
                                        @if($year->is_live)
                                            <a href="{{ url('/brochure') }}" class="dropdown-item">
                                                <i class="far fa-desktop fa-fw"></i> Web Brochure</a>
                                        @endif
                                        @if($year->is_workshop_proposal)
                                            <a href="{{ url('/proposal') }}" class="dropdown-item">
                                                <i class="fal fa-chalkboard-teacher fa-fw"></i> Workshop Proposal
                                            </a>
                                        @endif
                                    @endif
                                </div>
                            </li>

                            <li class="nav-item"><a href="{{ url('/contact') }}" class="nav-link">Contact Us</a></li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{--@role(['admin', 'council'])--}}
{{--<div class="input-group p-0 m-0">--}}
    {{--<div class="input-group-prepend">--}}
        {{--@include('admin.controls', ['id' =>  (preg_match('/\/(c|f)\/\d+$/', $_SERVER['REQUEST_URI'], $matches) ? substr($_SERVER['REQUEST_URI'], -6) : 'c/0'), 'inputgroup' => 'true'])--}}
    {{--</div>--}}

    {{--<input type="text" id="camper" class="form-control camperlist" placeholder="Camper Name"/>--}}
{{--</div>--}}
{{--@endrole--}}
{{--</header>--}}

{{--<main class="js-reveal">--}}

    {{--@hassection('title')--}}
        {{--<section id="hero" class="light-bg img-bg-bottom img-bg-softer"--}}
                 {{--style="background-image: url(/images/jumbotron.jpg);">--}}
            {{--<div class="container inner">--}}
                {{--<div class="row">--}}
                    {{--<div class="col-lg-8 col-md-9 aos-init aos-animate" data-aos="fade-up">--}}
                        {{--<header>--}}
                            {{--<h1>--}}
                                {{--@yield('title')--}}
                            {{--</h1>--}}
                            {{--@hassection('heading')--}}
                                {{--<h3>--}}
                                    {{--@yield('heading')--}}
                                {{--</h3>--}}
                            {{--@endif--}}
                        {{--</header>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</section>--}}
    {{--@endif--}}

    {{--@hassection('multisection')--}}
        {{--@yield('multisection')--}}
    {{--@else--}}
        {{--<section>--}}
            {{--<div class="inner-top inner-left-sm aos-init aos-animate p-5" data-aos="fade-up">--}}
                {{--@yield('content')--}}
            {{--</div>--}}
        {{--</section>--}}
    {{--@endif--}}
{{--</main>--}}

{{--<footer class="dark-bg">--}}
    {{--<div class="container inner">--}}
        {{--<div class="row">--}}

            {{--<div class="col-lg-4 col-md-6 inner">--}}

            {{--</div>--}}

            {{--<div class="col-lg-4 col-md-6 inner">--}}
            {{--</div>--}}

            {{--<div class="col-lg-4 col-md-6 inner">--}}

            {{--</div>--}}

        {{--</div>--}}
    {{--</div>--}}

    {{--<div class="footer-bottom">--}}
        {{--<div class="container inner clearfix">--}}
            {{--<p class="float-left">&copy; {{ $year->year }} Midwest Unitarian Universalist Summer Assembly.--}}
                {{--All rights--}}
                {{--reserved.</p>--}}
            {{--<ul class="footer-menu float-right">--}}
                {{--<li><a href="/">Home</a></li>--}}
                {{--<li><a href="{{ url('/registration') }}">Register</a></li>--}}
                {{--<li><a href="{{ url('/information') }}">Information</a></li>--}}
                {{--<li><a href="{{ url('/contact') }}">Contact</a></li>--}}
            {{--</ul>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</footer>--}}


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
