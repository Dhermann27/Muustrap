Thank you for submitting your registration! We are looking forward to seeing you "next week".

You have successfully registered the following campers for MUUSA {{ $year->year }}:
@foreach($campers as $camper)
    @if($camper->yearattendingid != 0)
        {{ $camper->firstname }} {{ $camper->lastname }}
    @endif
@endforeach

Please don't forget to remit payment, sign up for workshops, and check out room selection at muusa.org.

Midwest Unitarian Universalist Summer Assembly