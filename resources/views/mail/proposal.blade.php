<h2>MUUSA Workshop Proposal</h2>
<p>From: {{ $camper->firstname }} {{ $camper->lastname }} &lt;{{ $camper->email }}&gt;<br/>
    {{ $camper->family->address1 }}<br/>
    @if($camper->family->address2 != '')
        {{ $camper->family->address2 }}<br/>
    @endif
    {{ $camper->family->city }}, {{ $camper->family->statecd }} {{ $camper->family->zipcd }}<br/>
    @if($camper->phonenbr != '')
        {{ $camper->formatted_phone  }}<br />
    @endif
</p>
<p><strong>Type of Event</strong>: {{ $request->type }}</p>

<p><strong>Proposed Title</strong>: {{ $request->name }}</p>

<p><strong>Synopsis</strong>:</p>
<p>{{ $request->message }}</p>

<p><strong>Qualifications</strong>:</p>
<p>{{ $request->qualifications }}</p>

<p><strong>Offered at MUUSA</strong>: {{ $request->atmuusa }}</p>

<p><strong>Offered elsewhere</strong>: {{ $request->atelse }}</p>

<p><strong>Appropriate Ages</strong>: {{ $request->ages }}</p>

<p><strong>Preferred Days of Week</strong>: {{ $request->days }}</p>

<p><strong>Preferred Timeslot</strong>: {{ $request->timeslot }} <br />
    Details: {{ $request->timeslotpref }}</p>

<p><strong>Room Requirements</strong>: {{ $request->room }}</p>

<p><strong>Equipment Requirements</strong>: {{ $request->equip }}</p>

<p><strong>Participant Fee</strong>: {{ $request->fee }}</p>

<p><strong>Maximum Number of Participants</strong>: {{ $request->capacity }}</p>

<p><strong>Waive Credit</strong>: {{ $request->waive}}</p>

<p><strong>Additional Details</strong>: {{ $request->details }}</p>


