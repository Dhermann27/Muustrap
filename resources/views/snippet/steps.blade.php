<ul id="littlesteps"
    class="nav nav-steps nav-steps-circles flex-column flex-lg-row justify-content-around pt-0 d-none d-lg-flex">
    <li class="nav-item">
        @if($steps->household == '1')
            <i class="far fa-check btn-success float-right"></i>
        @endif
        <a href="{{ url('/household') . (preg_match('/\/(c|f)\/\d+$/', $_SERVER['REQUEST_URI'], $matches) ? substr($_SERVER['REQUEST_URI'], -7) : '')}}"
           class="nav-link{{ preg_match('/\/household/', $_SERVER['REQUEST_URI'], $matches) ? ' active' : '' }}"
           data-toggle="tooltip" data-placement="bottom" data-container="ul#littlesteps" title="Household Information">
            <i class="far fa-home"></i>
        </a>
    </li>
    <li class="nav-item">
        @if($steps->campers == '1')
            <i class="far fa-check btn-success float-right"></i>
        @endif
        <a href="{{ url('/camper') . (preg_match('/\/(c|f)\/\d+$/', $_SERVER['REQUEST_URI'], $matches) ? substr($_SERVER['REQUEST_URI'], -7) : '') }}"
           class="nav-link{{ preg_match('/\/camper/', $_SERVER['REQUEST_URI'], $matches) ? ' active' : '' }}"
           data-toggle="tooltip" data-placement="bottom"
           data-container="ul#littlesteps" title="Camper Listing">
            <i class="far fa-users"></i>
        </a>
    </li>
    <li class="nav-item">
        @if($steps->payment == '1')
            <i class="far fa-check btn-success float-right"></i>
        @endif
        <a href="{{ url('/payment') . (preg_match('/\/(c|f)\/\d+$/', $_SERVER['REQUEST_URI'], $matches) ? substr($_SERVER['REQUEST_URI'], -7) : '') }}"
           class="nav-link{{ preg_match('/\/payment/', $_SERVER['REQUEST_URI'], $matches) ? ' active' : '' }}"
           data-toggle="tooltip" data-placement="bottom"
           data-container="ul#littlesteps" title="Statement &amp; Payment">
            <i class="far fa-usd-square"></i>
        </a>
    </li>
    <li class="nav-item">
        @if($steps->workshops == '1')
            <i class="far fa-check btn-success float-right"></i>
        @endif
        <a href="{{ url('/workshopchoice') . (preg_match('/\/(c|f)\/\d+$/', $_SERVER['REQUEST_URI'], $matches) ? substr($_SERVER['REQUEST_URI'], -7) : '') }}"
           class="nav-link{{ preg_match('/\/workshopchoice/', $_SERVER['REQUEST_URI'], $matches) ? ' active' : '' }}"
           data-toggle="tooltip" data-placement="bottom"
           data-container="ul#littlesteps" title="Workshop Preferences">
            <i class="far fa-rocket"></i>
        </a>
    </li>
    <li class="nav-item">
        @if($steps->room == '1')
            <i class="far fa-check btn-success float-right"></i>
        @endif
        <a href="{{ url('/roomselection') . (preg_match('/\/(c|f)\/\d+$/', $_SERVER['REQUEST_URI'], $matches) ? substr($_SERVER['REQUEST_URI'], -7) : '') }}"
           class="nav-link{{ preg_match('/\/roomselection/', $_SERVER['REQUEST_URI'], $matches) ? ' active' : '' }}"
           data-toggle="tooltip" data-placement="bottom"
           data-container="ul#littlesteps" title="Room Selection">
            <i class="far fa-bed"></i>
        </a>
    </li>
    <li class="nav-item">
        @if($steps->nametag == '1')
            <i class="far fa-check btn-success float-right"></i>
        @endif
        <a href="{{ url('/nametag') . (preg_match('/\/(c|f)\/\d+$/', $_SERVER['REQUEST_URI'], $matches) ? substr($_SERVER['REQUEST_URI'], -7) : '') }}"
           class="nav-link{{ preg_match('/\/nametag/', $_SERVER['REQUEST_URI'], $matches) ? ' active' : '' }}"
           data-toggle="tooltip" data-placement="bottom"
           data-container="ul#littlesteps" title="Nametag Customization">
            <i class="far fa-id-card"></i>
        </a>
    </li>
    <li class="nav-item nav-">
        @if($steps->medical == '1')
            <i class="far fa-check btn-success float-right"></i>
        @endif
        <a href="{{ url('/confirm') . (preg_match('/\/(c|f)\/\d+$/', $_SERVER['REQUEST_URI'], $matches) ? substr($_SERVER['REQUEST_URI'], -7) : '') }}"
           class="nav-link{{ preg_match('/\/confirm/', $_SERVER['REQUEST_URI'], $matches) ? ' active' : '' }}"
           data-toggle="tooltip" data-placement="bottom"
           data-container="ul#littlesteps" title="Confirmation Letter">
            <i class="far fa-envelope"></i>
        </a>
    </li>
</ul>