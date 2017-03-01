
<h2>MUUSA Art Fair Form</h2>
<p>From: {{ $camper->firstname }} {{ $camper->lastname }} <{{ $camper->email }}><br />
    {{ $camper->family->address1 }}<br />
@if($camper->family->address2 != '')
    {{ $camper->family->address2 }}<br />
    @endif
    {{ $camper->family->city }}, {{ $camper->family->statecd }} {{ $camper->family->zipcd }}<br />
    {{ $camper->formatted_phone }}
</p>
<p><strong>Message</strong>:</p>
<p>{{ $request->message }}</p>

<p><strong>Price Range</strong>:</p>
<p>{{ $request->pricerange }}</p>

<p><strong>Volunteer Timeslots</strong>:</p>
<p>{{ $request->timeslots }}</p>
