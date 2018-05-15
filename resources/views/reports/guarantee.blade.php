@extends('layouts.app')

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
                        Trout Lodge, Lakeview and Forestview
                        @break
                        @case(1)
                        Tent Camping
                        @break
                        @case(2)
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
    </table>
@endsection

