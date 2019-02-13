@extends('layouts.appstrap')

@section('title')
    Cognoscenti
@endsection

@section('content')
    @foreach($staff as $pctype => $types)
        @component('snippet.accordion', ['id' => 'unique'])
            @component('snippet.accordioncard', ['id' => $pctype, 'loop' => $loop, 'heading' => '', 'title' => $pctype == 1 ? 'Adult Programming Committee' : ($pctype == 2 ? 'Executive Council' : 'Program Staff')])
                <table class="table">
                    <thead>
                    <tr>
                        <th>Camper Name</th>
                        <th>Position</th>
                        <th>Phone Number</th>
                        <th>Email</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($types as $member)
                        <tr>
                            <td>{{ $member->firstname }} {{ $member->lastname }}</td>
                            <td>{{ $member->staffpositionname }}</td>
                            <td>
                                <a href="tel:+1{{ $member->camper->phonenbr }}">{{ $member->camper->formatted_phone }}</a>
                            </td>
                            <td><a href="mailto:{{ $member->camper->email }}">{{ $member->camper->email }}</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="4" align="right">
                            <a href="mailto:{{ $types->implode('email', ';') }}">
                                <i class="fas fa-envelope"></i>
                                Email {{ $pctype == 1 ? 'APC' : ($pctype == 2 ? 'XC' : 'Programs') }}
                            </a>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            @endcomponent
        @endcomponent
    @endforeach
@endsection

