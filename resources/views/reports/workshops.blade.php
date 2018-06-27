@extends('layouts.app')

@section('title')
    Workshop Attendees
@endsection

@section('content')
    <button class="btn btn-primary float-right printme" data-toggle="tooltip" title="Print Signup Sheets"><i class="far fa-print fa-2x"></i>
    </button>
    @include('snippet.navtabs', ['tabs' => $timeslots, 'id'=> 'id', 'option' => 'name'])

    <div class="tab-content">
        @foreach($timeslots as $timeslot)
            <div role="tabpanel" class="tab-pane fade{{ $loop->first ? ' active show' : '' }}"
                 aria-expanded="{{ $loop->first ? 'true' : 'false' }}" id="{{ $timeslot->id }}">
                @if($timeslot->id != '1005')
                    <h5>{{ $timeslot->start_time->format('g:i A') }}
                        - {{ $timeslot->end_time->format('g:i A') }}</h5>
                @endif
                @foreach($timeslot->workshops as $workshop)
                    <h4>{{ $workshop->name }} ({{ count($workshop->choices) }} / {{ $workshop->capacity }})</h4>
                    <table class="table">
                        <thead>
                        <tr>
                            <th width="50%">Name</th>
                            <th width="25%">Sign Up Date</th>
                            <th width="25%">Controls</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($workshop->choices()->orderBy('is_leader', 'desc')->orderBy('created_at')->get() as $choice)
                            <tr {{ $choice->is_enrolled == '0' ? ' class="table-danger"' : ''}}>
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
                        <tr class="d-print-none">
                            <td colspan="3">Distribution list: {{ $workshop->emails }}
                            </td>
                        </tr>
                        @for($i=count($workshop->choices); $i<min($workshop->capacity, count($workshop->choices)+5); $i++)
                            <tr class="d-none d-print-block">
                                <td colspan="2" style="border-bottom: 1px solid black;">&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                        @endfor
                        </tfoot>
                    </table>
                @endforeach
            </div>
        @endforeach
    </div>
@endsection

@section('script')
    <script>
        $("button.printme").on('click', function () {
            window.print();
        });
    </script>
@endsection