<div class="btn-group hidden-print">
    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
            id="controls{{ $id }}" aria-expanded="false">Details <span class="caret"></span></button>
    <ul class="dropdown-menu" role="menu" aria-labelledby="controls{{ $id }}">
        <li><a href="{{ url('/household/' . $id) }}" class="fa fa-home">Household</a></li>
        <li><a href="{{ url('/camper/' . $id) }}" class="fa fa-group"> Campers</a></li>
        <li><a href="{{ url('/payment/' . $id) }}" class="fa fa-money"> Statement</a></li>
        <li><a href="{{ url('/workshopchoice/' . $id) }}" class="fa fa-rocket"> Workshops</a></li>
        <li><a href="{{ url('/roomselection/' . $id) }}" class="fa fa-bed"> Room</a></li>
        <li><a href="{{ url('/volunteer/' . $id) }}" class="fa fa-handshake-o"> Volunteer</a></li>
        <li><a href="{{ url('/confirm/' . $id) }}" class="fa fa-envelope"> Confirmation</a></li>
        <li><a href="{{ url('/nametag/' . $id) }}" class="fa fa-id-card"> Customize Nametags</a></li>
        <li><a href="{{ url('/nametags/' . $id) }}" class="fa fa-print"> Print Nametags</a></li>
        <li><a href="{{ url('/calendar/' . $id) }}" class="fa fa-calendar"> Calendar</a></li>
    </ul>
</div>