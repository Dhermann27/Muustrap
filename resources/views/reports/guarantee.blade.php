@extends('layouts.appstrap')

@section('title')
    Guarantee Status
@endsection

@section('content')
    <table class="table">
        <thead>
        <tr>
            <th>Area</th>
            <th>Ages</th>
            <th>Count</th>
        </tr>
        </thead>
        <tbody>
        @foreach($groups as $group)
            <tr>
                <td>
                    @switch($group->side)
                        @case(0)
                        Unassigned
                        @break
                        @case(1)
                        Trout Lodge, Lakeview and Forestview
                        @break
                        @case(2)
                        Tent Camping
                        @break
                        @case(3)
                        Lakewood Side
                        @break
                    @endswitch
                </td>
                <td>@switch($group->agegroup)
                        @case(0)
                        13 and older
                        @break
                        @case(1)
                        6-12
                        @break
                        @case(2)
                        Less than 6
                        @break
                    @endswitch
                </td>
                <td>{{ $group->count }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td colspan="3" align="right"><strong>Total Campers
                    Attending: </strong> {{ $groups->sum('count') }}</td>
        </tr>
        </tfoot>
    </table>
@endsection

