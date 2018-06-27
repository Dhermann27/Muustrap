@if(!isset($inputgroup))
    <div class="dropdown d-print-none">
        @endif
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                id="controls-{{ $id }}" aria-expanded="false">Details <span class="caret"></span></button>
        <div class="dropdown-menu" aria-labelledby="controls{{ $id }}">
            <a class="dropdown-item" href="{{ url('/household/' . $id) }}"><i class="far fa-home"></i> Household</a>
            <a class="dropdown-item" href="{{ url('/camper/' . $id) }}"><i class="far fa-users"></i> Campers</a>
            <a class="dropdown-item" href="{{ url('/payment/' . $id) }}"><i class="far fa-usd-circle"></i> Statement</a>
            <a class="dropdown-item" href="{{ url('/workshopchoice/' . $id) }}"><i class="far fa-rocket"></i>
                Workshops</a>
            <a class="dropdown-item" href="{{ url('/roomselection/' . $id) }}"><i class="far fa-bed"></i> Room</a>
            <a class="dropdown-item" href="{{ url('/volunteer/' . $id) }}"><i class="far fa-handshake"></i> Volunteer</a>
            <a class="dropdown-item" href="{{ url('/confirm/' . $id) }}"><i class="far fa-envelope"></i> Confirmation</a>
            <a class="dropdown-item" href="{{ url('/nametag/' . $id) }}"><i class="far fa-id-card"></i> Customize
                Nametags</a>
            <a class="dropdown-item" href="{{ url('/nametags/' . $id) }}"><i class="far fa-print"></i> Print Nametags</a>
            <a class="dropdown-item" href="{{ url('/calendar/' . $id) }}"><i class="far fa-calendar"></i> Calendar</a>
        </div>
        @if(!isset($inputgroup))
    </div>
@endif