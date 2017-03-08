<h2>MUUSA Art Fair Form</h2>
<p>From: {{ $camper->firstname }} {{ $camper->lastname }} <{{ $camper->email }}><br/>
    {{ $camper->address1 }}<br/>
    @if($camper->address2 != '')
        {{ $camper->address2 }}<br/>
    @endif
    {{ $camper->city }}, {{ $camper->statecd }} {{ $camper->zipcd }}<br/>
    @if($camper->phonenbr != '')
        {{ $camper->formatted_phone  }}<br />
    @endif
    @if($camper->room_number != '')
        {{ $camper->buildingname }} {{ $camper->room_number }}
    @endif
</p>
<p><strong>Description of Work</strong>:</p>
<p>{{ $request->message }}</p>

<p><strong>Price Range</strong>:</p>
<p>{{ $request->pricerange }}</p>

<p><strong>Table Requirements</strong>:</p>
<p>{{ $request->table }}</p>

<p><strong>Volunteer Timeslots</strong>:</p>
<p>{{ $request->timeslots }}</p>
