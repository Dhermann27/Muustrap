<div class="btn-group hidden-print">
    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
            id="controls{{ $id }}" aria-expanded="false">Details <span class="caret"></span></button>
    <ul class="dropdown-menu camperdetails" role="menu" aria-labelledby="controls{{ $id }}">
        <li><a href="{{ url('/household/' . $id) }}"><i class="fa fa-home"></i> Household</a></li>
        <li><a href="{{ url('/camper/' . $id) }}"><i class="fa fa-group"></i> Campers</a></li>
        <li><a href="{{ url('/payment/' . $id) }}"><i class="fa fa-money"></i> Statement</a></li>
        <li><a href="{{ url('/workshopchoice/' . $id) }}"><i class="fa fa-rocket"></i> Workshops</a></li>
        <li><a href="{{ url('/roomselection/' . $id) }}"><i class="fa fa-bed"></i> Room</a></li>
        <li><a href="{{ url('/volunteer/' . $id) }}"><i class="fa fa-handshake-o"></i> Volunteer</a></li>
        <li><a href="{{ url('/confirm/' . $id) }}"><i class="fa fa-envelope"></i> Confirmation</a></li>
        <li><a href="{{ url('/nametag/' . $id) }}"><i class="fa fa-id-card"></i> Customize Nametags</a></li>
        <li><a href="{{ url('/nametags/' . $id) }}"><i class="fa fa-print"></i> Print Nametags</a></li>
        <li><a href="{{ url('/calendar/' . $id) }}"><i class="fa fa-calendar"></i> Calendar</a></li>
    </ul>
</div>