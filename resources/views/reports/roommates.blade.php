@extends('layouts.app')

@section('content')
    <p>&nbsp;</p>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">Roommates Report</div>
            <div class="panel-body">
                <table class="table table-responsive">
                    <thead>
                    <tr>
                        <th>Camper Name</th>
                        <th>Roommate Preference</th>
                        <th>Current Assignment</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($campers as $camper)
                        <tr>
                            <td>{{ $camper->lastname }}, {{ $camper->firstname }}</td>
                            <td>{{ $camper->roommate }}</td>
                            <td>{{ !empty($camper->roomid) ? $camper->yearattending->room->room_number : 'Unassigned' }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

