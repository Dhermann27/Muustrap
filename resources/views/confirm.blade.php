@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="/css/print.css" type="text/css" media="print"/>
@endsection

@section('content')
    <p>&nbsp;</p>
    @foreach($families as $family)
        <div class="container">
            <div class="row" align="center"><img src="/images/print_logo.png"
                                                 alt="Welcome to MUUSA {{ $year->year }}!"/>
            </div>
            <p>&nbsp;</p>
            <h3>{{ $family->family_name }}<br/>
                {{ $family->address1 }}<br/>
                @if(!empty($family->address2))
                    {{ $family->address2 }}<br/>
                @endif
                {{ $family->city }}, {{ $family->state_code }} {{ $family->zipcd }}</h3>
            <p>&nbsp;</p>
            <table class="table table-responsive table-bordered">
                <caption>Camper Information</caption>
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Preferred Pronoun</th>
                    <th>Email Address</th>
                    <th>Phone Number</th>
                    <th>Birthdate</th>
                    <th>Program</th>
                    <th>Church</th>
                    <th>Assigned Room</th>
                </tr>
                </thead>
                <tbody>
                @foreach($family->campers()->orderBy('birthdate')->get() as $camper)
                    <tr>
                        <td>{{ $camper->firstname }} {{ $camper->lastname }}</td>
                        <td>{{ $camper->pronounname }}</td>
                        <td>{{ !empty($camper->email) ? $camper->email : '&nbsp;' }}</td>
                        <td>{{ !empty($camper->phonenbr) ? $camper->formatted_phone : '&nbsp;' }}</td>
                        <td>{{ $camper->birthday }}</td>
                        <td>{{ $camper->programname }}</td>
                        <td>{{ $camper->churchname }}</td>
                        <td>{{ $camper->buildingname }} {{ $camper->roomid != '1170' ? $camper->room_number : ''}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <p>&nbsp;</p>
            <table class="table table-responsive table-bordered">
                <caption>Statement</caption>
                <thead>
                <tr>
                    <th>Charge Type</th>
                    <th align="right">Amount</th>
                    <th align="center">Date</th>
                    <th>Memo</th>
                </tr>
                </thead>
                <tbody>
                @foreach($family->charges()->orderBy('timestamp')->get() as $charge)
                    <tr>
                        <td>{{ $charge->chargetypename }}</td>
                        <td class="amount" align="right">${{ money_format('%.2n', $charge->amount) }}</td>
                        <td align="center">{{ $charge->timestamp }}</td>
                        <td>{{ $charge->memo }}</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="3" align="right"><strong>Amount Due:</strong></td>
                    <td>${{ money_format('%.2n', $family->charges->sum('amount')) }}</td>
                </tr>
                </tfoot>
            </table>
            <p>&nbsp;</p>
            @if(count($families) == 1)
                <table class="table table-responsive table-bordered">
                    <caption>Workshop Signups</caption>
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Workshop</th>
                        <th>Timeslot</th>
                        <th>Days</th>
                        <th>Location</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($family->campers()->orderBy('birthdate')->get() as $camper)
                        @foreach($camper->yearattending->workshops()->get() as $signup)
                            <tr>
                                <td>{{ $camper->firstname }} {{ $camper->lastname }}</td>
                                <td>{{ $signup->workshop->name }}</td>
                                <td>{{ $signup->workshop->timeslot->name }}</td>
                                <td>{{ $signup->workshop->display_days }}</td>
                                <td>{{ $signup->workshop->room->room_number }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        <footer align="center"><h4>See you next week!</h4></footer>
    @endforeach
@endsection

