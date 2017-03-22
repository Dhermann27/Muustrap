@extends('layouts.app')

@section('content')
    <p>&nbsp;</p>
    <div class="container">
        <div class="row">
            <h2>Workshop Attendees</h2>
        </div>
        <div>
            <ul class="nav nav-tabs" role="tablist">
                @foreach($timeslots as $timeslot)
                    <li role="presentation"{!! $loop->first ? ' class="active"' : '' !!}>
                        <a href="#{{ $timeslot->id }}" aria-controls="{{ $timeslot->id }}" role="tab"
                           data-toggle="tab">{{ $timeslot->name }}</a></li>
                @endforeach
            </ul>

            <div class="tab-content">
                @foreach($timeslots as $timeslot)
                    <div role="tabpanel" class="tab-pane fade{{ $loop->first ? ' in active' : '' }}"
                         id="{{ $timeslot->id }}">
                        @if($timeslot->id != '1005')
                            <h5>{{ $timeslot->start_time->format('g:i A') }}
                                - {{ $timeslot->end_time->format('g:i A') }}</h5>
                        @endif
                        @foreach($timeslot->workshops as $workshop)
                            <h4>{{ $workshop->name }} ({{ count($workshop->choices) }} / {{ $workshop->capacity }})</h4>
                            <table class="table table-responsive table-condensed">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Sign Up Date</th>
                                    <th>Controls</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($workshop->choices()->orderBy('is_leader', 'desc')->orderBy('created_at')->get() as $choice)
                                    <tr
                                            @if($loop->index == 20)
                                            style="border-top: 2px dashed indianred;"
                                            @endif
                                    >
                                        <td>{{ $choice->yearattending->camper->lastname }}
                                            , {{ $choice->yearattending->camper->firstname }}</td>
                                        <td>
                                            @if($choice->is_leader == '1')
                                                <strong>Leader</strong>
                                            @else
                                                {{ $choice->created_at }}
                                            @endif
                                        </td>
                                        <td>
                                            @include('admin.controls', ['id' => 'c/' . $choice->yearattending->camper->id])
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="3">Distribution list: {{ $workshop->emails }}
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection