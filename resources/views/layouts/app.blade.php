@inject('home', 'App\Http\Controllers\HomeController')
        <!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="description"
          content="Midwest Unitarian Universalist Summer Assembly, located outside Potosi, Missouri (Formerly Lake Geneva Summer Assembly in Williams Bay, Wisconsin)">
    <meta name="author" content="Dan Hermann">
    <title>Midwest Unitarian Universalist Summer Assembly</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="/css/theme-style.min.css" rel="stylesheet">

    <link rel="stylesheet" href="/css/muustrap.css" type="text/css"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto:500"/>

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
<body class="page page-index-static navbar-layout-default" data-plugins-localpath="/assets/plugins/">
<a href="#content" id="top" class="sr-only">Skip to content</a>

<div id="header d-print-none">
    <div class="header-upper d-print-none">
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

            <div class="nav nav-icons header-block order-12">
                <a href="https://www.youtube.com/watch?v=QNWMdbrjxuE" class="nav-link">
                    <i class="fab fa-youtube fa-2x"></i> <span
                            class="sr-only">YouTube</span> </a>
                <a href="https://twitter.com/muusa1" class="nav-link"> <i class="fab fa-twitter-square fa-2x"></i> <span
                            class="sr-only">Twitter</span> </a>
                <a href="https://www.facebook.com/{{ Auth::guest() ? 'Muusa2013/' : 'groups/Muusans/'}}"
                   class="nav-link">
                    <i class="fab fa-facebook-square fa-2x"></i> <span
                            class="sr-only">Facebook</span> </a>
                @if(Auth::check())
                    <a href="{{ url('/directory') }}" class="nav-link"> <i class="far fa-address-book fa-2x"></i> <span
                                class="sr-only">Online Directory</span> </a>
                    @if($home->year()->is_live)
                        <a href="{{ url('/calendar') }}" class="nav-link"> <i class="far fa-calendar-alt fa-2x"></i>
                            <span
                                    class="sr-only">Your MUUSA Calendar</span>
                        </a>
                    @endif
                @endif
            </div>
        </div>
    </div>

    <div class="header d-print-none">
        <div class="header-inner container">
            <div class="header-brand">
                <a class="header-brand-text" href="/" title="Home">
                    <img alt="Brand" src="/images/brand.png"> <span class="hidden-md">Midwest Unitarian Universalist Summer Assembly</span>
                </a>
            </div>

            <a href="#top" class="btn btn-link btn-icon header-btn float-right d-xl-none" data-toggle="jpanel-menu"
               data-target=".navbar-main" data-direction="right"> <i class="far fa-bars"></i> </a>

            <div class="navbar navbar-expand-lg">
                <div class="navbar-main collapse">
                    <ul class="nav navbar-nav float-lg-right dropdown-effect-fade">
                        @role(['admin', 'council'])

                        @role(['admin'])
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" id="admin-drop" data-toggle="dropdown"
                               data-hover="dropdown">Administration</a>
                            <div class="dropdown-menu">
                                <a href="{{ url('/household/f/0') }}" class="dropdown-item">Create New Family</a>
                                <a href="{{ url('/admin/distlist') }}" class="dropdown-item">Distribution Lists</a>
                                <a href="{{ url('/confirm/all') }}" class="dropdown-item">Invoices (all)</a>
                                <a href="{{ url('/admin/master') }}" class="dropdown-item">Master Control Program</a>
                                <a href="{{ url('/confirm/letters') }}" class="dropdown-item">Medical/Program Letters
                                    (all)</a>
                                <a href="{{ url('/admin/positions') }}" class="dropdown-item">Staff Positions</a>
                                <a href="{{ url('/admin/roles') }}" class="dropdown-item">User Roles</a>
                            </div>
                        </li>
                        @endrole
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" id="report-drop" data-toggle="dropdown"
                               data-hover="dropdown">Reports</a>
                            <div class="dropdown-menu">
                                <a href="{{ url('/reports/deposits') }}" class="dropdown-item">Bank Deposits</a>
                                <a href="{{ url('/reports/firsttime') }}" class="dropdown-item">First-time Campers</a>
                                <a href="{{ url('/reports/guarantee') }}" class="dropdown-item">Guarantee Status</a>
                                <a href="{{ url('/reports/payments') }}" class="dropdown-item">Ledger</a>
                                <a href="{{ url('/reports/outstanding') }}" class="dropdown-item">Outstanding
                                    Balances</a>
                                <a href="{{ url('/reports/programs') }}" class="dropdown-item">Program Participants</a>
                                <a href="{{ url('/reports/rates') }}" class="dropdown-item">Rates</a>
                                <a href="{{ url('/reports/campers') }}" class="dropdown-item">Registered Campers</a>
                                <a href="{{ url('/reports/chart') }}" class="dropdown-item">Registration Chart</a>
                                <a href="{{ url('/reports/roommates') }}" class="dropdown-item">Roommates</a>
                                <a href="{{ url('/reports/rooms') }}" class="dropdown-item">Rooms</a>
                                <a href="{{ url('/reports/states') }}" class="dropdown-item">States &amp; Churches</a>
                                <a href="{{ url('/reports/volunteers') }}" class="dropdown-item">Volunteers</a>
                                <a href="{{ url('/reports/workshops') }}" class="dropdown-item">Workshop Attendees</a>
                                <a href="{{ url('/reports/conflicts') }}" class="dropdown-item">Workshop Conflicts</a>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" id="tool-drop" data-toggle="dropdown"
                               data-hover="dropdown">Tools</a>
                            <div class="dropdown-menu">
                                <a href="{{ url('/coffeehouse') }}" class="dropdown-item">Coffeehouse Schedule</a>
                                @if(count($home->pc()) > 0)
                                    @if(count($home->apc()) > 0)
                                        <a href="mailto:{{ $home->apc()->implode('email', ';') }}"
                                           class="dropdown-item">Email
                                            Adult Programming Committee</a>
                                    @endif
                                    @if(count($home->ec()) > 0)
                                        <a href="mailto:{{ $home->ec()->implode('email', ';') }}"
                                           class="dropdown-item">Email
                                            Executive Council</a>
                                    @endif
                                    <a href="mailto:{{ $home->pc()->implode('email', ';') }}"
                                       class="dropdown-item">Email
                                        Planning Council (all)</a>
                                    @if(count($home->programs()) > 0)
                                        <a href="mailto:{{ $home->programs()->implode('email', ';') }}"
                                           class="dropdown-item">Email Program Personnel</a>
                                    @endif
                                @endif
                                <a href="{{ url('/tools/nametags') }}" class="dropdown-item">Nametag Printer</a>
                                <a href="{{ url('/tools/nametags/all') }}" class="dropdown-item">Nametags (all)</a>
                                <a href="{{ url('/tools/programs') }}" class="dropdown-item">Programs</a>
                                <a href="{{ url('/roomselection/map') }}" class="dropdown-item">Room Selection Map</a>
                                <a href="{{ url('/tools/staffpositions') }}" class="dropdown-item">Staff Assignments</a>
                                <a href="{{ url('/tools/workshops') }}" class="dropdown-item">Workshops</a>
                            </div>
                        </li>
                        @endrole

                        @if(isset($actslist) && count($actslist) > 0)
                            <li class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" id="tool-drop" data-toggle="dropdown"
                                   data-hover="dropdown">Coffeehouse Schedule <i class="far fa-music"></i></a>
                                <div class="dropdown-menu">
                                    <p><i>{{ $home->year()->next_weekday->format('l F jS') }}</i></p>
                                    @if(isset($onstage))
                                        <p>Now on stage:</p>
                                        <p class="dropdown-item">
                                            <strong>{{ $onstage->name }}</strong></p>
                                        <p>Coming up:</p>
                                    @else
                                        <p>Evening's acts:</p>
                                    @endif
                                    @foreach($actslist as $item)
                                        <p class="dropdown-item">{{ $starttime->addMinutes(10)->format('g:iA') }} {{ $item->name }}
                                            @if($av && isset($item->equipment))
                                                ({{ $item->equipment }})
                                            @endif
                                        </p>
                                    @endforeach
                                </div>
                            </li>
                        @endif

                        <li class="nav-item dropdown dropdown-persist dropdown-mega-menu dropdown-mega-menu-75">
                            <a href="#" class="nav-link dropdown-toggle" id="megamenu-drop" data-toggle="dropdown"
                               data-hover="dropdown">Menu</a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <ul class="nav nav-pills nav-pills-border-bottom-inside flex-column flex-lg-row"
                                    role="tablist">
                                    @if(Auth::check() && $home->registered() && $home->year()->is_live)
                                        <li class="nav-item"><a class="nav-link p-3 active text-center font-weight-bold"
                                                                data-toggle="tab" data-target=".menu-tab-1" role="tab">
                                                {{ $home->year()->year }} Options</a></li>
                                        <li class="nav-item"><a class="nav-link p-3 text-center font-weight-bold"
                                                                data-toggle="tab" data-target=".menu-tab-2" role="tab">
                                                Special News</a></li>
                                    @endif
                                    <li class="nav-item"><a
                                                class="nav-link p-3 text-center font-weight-bold{{ Auth::guest() || !$home->registered() || !$home->year()->is_live ? ' active' : ''}}"
                                                data-toggle="tab" data-target=".menu-tab-3" role="tab">
                                            Register for {{ $home->year()->year }}</a></li>
                                    <li class="nav-item"><a class="nav-link p-3 text-center font-weight-bold"
                                                            data-toggle="tab" data-target=".menu-tab-4" role="tab">
                                            General Info</a></li>
                                    <li class="nav-item"><a class="nav-link p-3 text-center font-weight-bold"
                                                            data-toggle="tab" data-target=".menu-tab-5" role="tab">
                                            2018 Info</a></li>
                                </ul>
                                <div class="tab-content py-3">
                                    @if(Auth::check() && $home->registered() && $home->year()->is_live)
                                        <div class="tab-pane active show menu-tab-1" role="tabpanel">
                                            <div class="row text-center">
                                                <div class="col-lg-3 py-2">
                                                    <a href="{{ url('/workshopchoice') }}">
                                                        <i class="far fa-rocket fa-5x"></i>
                                                        <h5 class="mt-2">Workshops</h5>
                                                        <p>Choose workshop preferences</p>
                                                    </a>
                                                </div>
                                                <div class="col-lg-3 py-2">
                                                    <a href="{{ url('/roomselection') }}">
                                                        <i class="far fa-bed fa-5x"></i>
                                                        <h5 class="mt-2">Room Selection</h5>
                                                        <p>Choose housing option</p>
                                                    </a>
                                                </div>
                                                <div class="col-lg-3 py-2">
                                                    <a href="{{ url('/nametag') }}">
                                                        <i class="far fa-id-card fa-5x"></i>
                                                        <h5 class="mt-2">Nametags</h5>
                                                        <p>Customize displayed information</p>
                                                    </a>
                                                </div>
                                                <div class="col-lg-3 py-2">
                                                    <a href="{{ url('/confirm') }}">
                                                        <i class="far fa-envelope fa-5x"></i>
                                                        <h5 class="mt-2">Confirmation</h5>
                                                        <p>View confirmation and send medical forms</p>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane menu-tab-2" role="tabpanel">
                                            <div class="row text-center">
                                                <div class="col-lg-6 py-2">
                                                    <a href="{{ url('/volunteer') }}">
                                                        <i class="far fa-handshake fa-5x"></i>
                                                        <h5 class="mt-2">Volunteer</h5>
                                                        <p>Donate your time during MUUSA</p>
                                                    </a>
                                                </div>
                                                <div class="col-lg-6 py-2">
                                                    <a href="{{ url('/artfair') }}">
                                                        <i class="far fa-shopping-bag fa-5x"></i>
                                                        <h5 class="mt-2">Camper Art Fair</h5>
                                                        <p>Show your creations at camp</p>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="tab-pane menu-tab-3{{ Auth::guest() || !$home->registered() || !$home->year()->is_live ? ' active show' : ''}}"
                                         role="tabpanel">
                                        <div class="row text-center">
                                            <div class="col-lg-4 py-2">
                                                <a href="{{ url('/household') }}">
                                                    <i class="far fa-home fa-5x"></i>
                                                    <h5 class="mt-2">Household</h5>
                                                    <p>Update mailing information</p>
                                                </a>
                                            </div>
                                            <div class="col-lg-4 py-2">
                                                <a href="{{ url('/camper') }}">
                                                    <i class="far fa-users fa-5x"></i>
                                                    <h5 class="mt-2">Campers</h5>
                                                    <p>Update information on each individual</p>
                                                </a>
                                            </div>
                                            <div class="col-lg-4 py-2">
                                                <a href="{{ url('/payment') }}">
                                                    <i class="far fa-usd-square fa-5x"></i>
                                                    <h5 class="mt-2">Statement</h5>
                                                    <p>View and pay your bill</p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane menu-tab-4" role="tabpanel">
                                        <div class="row text-center">
                                            <div class="col-lg-3 py-2">
                                                <a href="{{ url('/programs') }}">
                                                    <i class="far fa-sitemap fa-5x"></i>
                                                    <h5 class="mt-2">Programs</h5>
                                                    <p>Fun for all ages</p>
                                                </a>
                                            </div>
                                            <div class="col-lg-3 py-2">
                                                <a href="{{ url('/housing') }}">
                                                    <i class="far fa-bath fa-5x"></i>
                                                    <h5 class="mt-2">Housing</h5>
                                                    <p>Available room types</p>
                                                </a>
                                            </div>
                                            <div class="col-lg-3 py-2">
                                                <a href="{{ url('/cost') }}">
                                                    <i class="far fa-calculator fa-5x"></i>
                                                    <h5 class="mt-2">Cost Calculator</h5>
                                                    <p>Estimate your fees</p>
                                                </a>
                                            </div>
                                            <div class="col-lg-3 py-2">
                                                <a href="{{ url('/scholarship') }}">
                                                    <i class="far fa-universal-access fa-5x"></i>
                                                    <h5 class="mt-2">Scholarship</h5>
                                                    <p>Financial assistance</p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane menu-tab-5" role="tabpanel">
                                        <div class="row text-center">
                                            <div class="col-lg-4 py-2">
                                                <a href="#">
                                                    <i class="far fa-map fa-5x"></i>
                                                    <h5 class="mt-2">Workshops</h5>
                                                    <p>Try something new</p>
                                                </a>
                                            </div>
                                            <div class="col-lg-4 py-2">
                                                <a href="#">
                                                    <i class="far fa-binoculars fa-5x"></i>
                                                    <h5 class="mt-2">Excursions</h5>
                                                    <p>Single-day adventures</p>
                                                </a>
                                            </div>
                                            <div class="col-lg-4 py-2">
                                                <a href="{{ url('/themespeaker') }}">
                                                    <i class="far fa-microphone fa-5x"></i>
                                                    <h5 class="mt-2">Theme Speaker</h5>
                                                    <p>Reverend Nic Cable</p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @role(['admin', 'council'])
    <div class="header-below d-print-none">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                @include('admin.controls', ['id' =>  (preg_match('/\/(c|f)\/\d+$/', $_SERVER['REQUEST_URI'], $matches) ? substr($_SERVER['REQUEST_URI'], -6) : 'c/0'), 'inputgroup' => 'true'])
            </div>

            <input type="text" id="camper" class="form-control camperlist"
                   placeholder="Camper Name"/>
        </div>
    </div>
    @endrole
</div>
<div id="content" class="p-0">
    @hassection('title')
        <p>&nbsp;</p>
        <h2 class="text-center text-uppercase font-weight-bold my-0 d-print-none">
            @yield('title')
        </h2>
        <hr class="hr-lg mt-0 mb-3 w-10 mx-auto hr-primary"/>
    @endif
    @hassection('heading')
        <h5 class="text-center font-weight-light mt-2 mb-0 text-muted d-print-none">
            @yield('heading')
        </h5>
        <hr class="mb-5 w-50 mx-auto d-print-none"/>
    @endif
    @yield('content')
</div>

<footer id="footer" class="p-0 d-print-none">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <p class="mb-0">Site template by <a href="http://appstraptheme.com/" class="footer-link">AppStrap</a> |
                    Copyright {{ $home->year()->year }} © Midwest Unitarian Universalist Summmer Assembly</p>
            </div>
        </div>
        <a href="#top" class="btn btn-icon btn-inverse pos-fixed pos-b pos-r mr-3 mb-3 scroll-state-active"
           title="Back to top" data-scroll="scroll-state"><i class="far fa-chevron-up"></i></a>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
<script defer src="https://pro.fontawesome.com/releases/v5.1.0/js/all.js"
        integrity="sha384-E5SpgaZcbSJx0Iabb3Jr2AfTRiFnrdOw1mhO19DzzrT9L+wCpDyHUG2q07aQdO6E"
        crossorigin="anonymous"></script>
<script src="/js/custom-script.js"></script>
<script src="/js/script.min.js"></script>

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
    @role(['admin'])
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
    @endrole
</script>
@endrole

@yield('script')

</body>
</html>
