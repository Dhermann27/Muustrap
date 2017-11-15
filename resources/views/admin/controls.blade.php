@if(!isset($inputgroup))
    <div class="dropdown d-print-none">
        @endif
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                id="controls{{ $id }}" aria-expanded="false">Details <span class="caret"></span></button>
        <div class="dropdown-menu" aria-labelledby="controls{{ $id }}">
            <a class="dropdown-item" href="{{ url('/household/' . $id) }}"><i class="fa fa-home"></i> Household</a>
            <a class="dropdown-item" href="{{ url('/camper/' . $id) }}"><i class="fa fa-users"></i> Campers</a>
            <a class="dropdown-item" href="{{ url('/payment/' . $id) }}"><i class="fa fa-usd-circle"></i> Statement</a>
            <a class="dropdown-item" href="{{ url('/workshopchoice/' . $id) }}"><i class="fa fa-rocket"></i>
                Workshops</a>
            <a class="dropdown-item" href="{{ url('/roomselection/' . $id) }}"><i class="fa fa-bed"></i> Room</a>
            <a class="dropdown-item" href="{{ url('/volunteer/' . $id) }}"><i class="fa fa-handshake"></i> Volunteer</a>
            <a class="dropdown-item" href="{{ url('/confirm/' . $id) }}"><i class="fa fa-envelope"></i> Confirmation</a>
            <a class="dropdown-item" href="{{ url('/nametag/' . $id) }}"><i class="fa fa-id-card"></i> Customize
                Nametags</a>
            <a class="dropdown-item" href="{{ url('/nametags/' . $id) }}"><i class="fa fa-print"></i> Print Nametags</a>
            <a class="dropdown-item" href="{{ url('/calendar/' . $id) }}"><i class="fa fa-calendar"></i> Calendar</a>
        </div>
        @if(!isset($inputgroup))
    </div>
@endif