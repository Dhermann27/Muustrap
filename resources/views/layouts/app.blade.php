@inject('home', 'App\Http\Controllers\HomeController')

        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Midwest Unitarian Universalist Summer Assembly</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="/css/bootstrap.min.css" type="text/css"/>
    <link rel="stylesheet" href="/css/muustrap.css" type="text/css"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto:500"/>
    <script src="//use.fontawesome.com/9364904132.js"></script>

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
<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#myNavbar">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">
                <h4>
                    <img alt="Brand" src="/images/brand.png"> <span class="hidden-xs">Midwest Unitarian
                        Universalist Summer Assembly</span>
                </h4>
            </a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-right">
                @if(isset($muse))
                    <li><a href="{{ url('/themuse') }}">Latest MUUSA Muse</a></li>
                @elseif($home->year()->isLive())
                    <li><a href="{{ url('MUUSA_2017_Brochure.pdf') }}">Web Brochure</a></li>
                @endif
                <li><a href="{{ url('/contact') }}">Contact Us</a></li>
                @if (Auth::guest())
                    <li><a href="{{ url('/login') }}">Login</a></li>
                    <li><a href="{{ url('/register') }}">Create Account</a></li>
                @else
                    <li><a href="{{ url('/logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            Logout
                        </a>

                        <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                              style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
@role(['admin', 'council'])
<ul class="nav nav-pills">
    <div class="col-lg-3" style="padding-top: 5px;">
        <div class="input-group">
            <input type="text" id="camper" class="form-control camperlist" placeholder="Camper Name"/>
            <div class="input-group-btn">
                @include('admin.controls', ['id' =>  (preg_match('/\/(c|f)\/\d+$/', $_SERVER['REQUEST_URI'], $matches) ? substr($_SERVER['REQUEST_URI'], -6) : 'c/0')])
            </div>
        </div>
    </div>
    @role(['admin'])
    <li role="presentation" class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
           aria-expanded="false">
            Administration <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            <li><a href="{{ url('/admin/distlist') }}">Distribution Lists</a></li>
            <li><a href="{{ url('/confirm/all') }}">Invoices (full)</a></li>
            <li><a href="{{ url('/admin/positions') }}">Staff Positions</a></li>
            <li><a href="{{ url('/admin/roles') }}">User Roles</a></li>
        </ul>
    </li>
    @endrole
    <li role="presentation" class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
           aria-expanded="false">
            Reports <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            <li><a href="{{ url('/reports/deposits') }}">Bank Deposits</a></li>
            <li><a href="{{ url('/reports/firsttime') }}">First-time Campers</a></li>
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
        </ul>
    </li>
    <li role="presentation" class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
           aria-expanded="false">
            Tools <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            <li><a href="{{ url('/tools/nametags') }}">Nametags (all)</a></li>
            <li><a href="{{ url('/tools/programs') }}">Programs</a></li>
            <li><a href="{{ url('/roomselection/map') }}">Room Selection Map</a></li>
            <li><a href="{{ url('/tools/staffpositions') }}">Staff Assignments</a></li>
            <li><a href="{{ url('/tools/workshops') }}">Workshops</a></li>
        </ul>
    </li>
</ul>
@endrole

@yield('content')

<script
        src="//code.jquery.com/jquery-3.1.1.min.js"
        integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
        crossorigin="anonymous"></script>
<script src="/js/bootstrap.min.js"></script>

@role(['admin', 'council'])
<script
        src="//code.jquery.com/ui/1.12.1/jquery-ui.min.js"
        integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
        crossorigin="anonymous"></script>
<script type="text/javascript">
    $('[data-toggle="tooltip"]').tooltip();
    $("#orderby-submit").on('click', function (e) {
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
                $(this).next().find(".camperdetails a").each(function () {
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
                $(this).html('<input type="text" name="' + tr.attr('id') + '-' + th.id + '" value="' + $(this).text() + '" />');
            } else if (th.className === 'select' && $("select." + th.id).length > 0) {
                var select = $(this).parents("div.tab-pane").find("select." + th.id).clone();
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
