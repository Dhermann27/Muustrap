@extends('layouts.appstrap')

@section('title')
    {{ $title }}
@endsection

@section('content')
    <div class="container">
        @if(isset($years))
            @include('snippet.orderby', ['years' => $years, 'url' => url('/reports/campers'), 'orders' => ['name', 'date']])
        @endif
        <table class="table">
            <thead>
            <tr align="right">
                <td colspan="4"><strong>Total Campers
                        Attending: </strong> {{ $families->sum('count') }}</td>
            </tr>
            <tr>
                <th>Family</th>
                <th>Location</th>
                <th>Registration Date</th>
            </tr>
            </thead>
            @foreach($families as $family)
                <tr>
                    <td>{{ $family->name }}</td>
                    <td>{{ $family->city }}, {{ $family->statecd }}
                        @if($family->is_scholar == '1')
                            <i class="far fa-universal-access" data-toggle="tooltip"
                               title="This family has indicated that they are applying for a scholarship."></i>
                        @endif
                    </td>
                    <td>
                        @if(isset($buildings))
                            <button type="button" id="save-{{ $family->id }}" class="btn btn-info float-right roomsave"
                                    data-familyid="{{ $family->id }}" title="Save Changes">
                                <i class="far fa-save"></i>
                            </button>
                        @endif
                        {{ $family->created_at->toDateString() }}
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <form id="roomchange-{{ $family->id }}" class="form-horizontal" role="form" method="POST"
                              action="{{ url('/admin/massassign') . '/f/' . $family->id}}">
                            {{ csrf_field() }}
                            <input type="hidden" name="familyid" value="{{ $family->id }}"/>
                            <table class="table table-sm">
                                @foreach($campers->get($family->id) as $camper)
                                    <tr>
                                        <td width="25%">{{ $camper->lastname }}, {{ $camper->firstname }}
                                            @if(isset($camper->email))
                                                <a href="mailto:{{ $camper->email }}" class="px-2 float-right"><i
                                                            class="far fa-envelope"></i></a>
                                            @endif
                                        </td>
                                        <td width="15%">{{ $camper->birthdate }}</td>
                                        <td width="20%">{{ $camper->programname }}</td>
                                        <td width="30%">
                                            @if(isset($buildings))
                                                <label for="{{ $camper->yearattendingid }}-roomid"
                                                       class="sr-only">{{ $camper->yearattendingid }}</label>
                                                <select id="{{ $camper->yearattendingid }}-roomid"
                                                        data-familyid="{{ $family->id }}" class="form-control roomlist"
                                                        name="{{ $camper->yearattendingid }}-roomid">
                                                    <option value="0">No Room Selected</option>
                                                    @foreach($buildings as $building)
                                                        <optgroup label="{{ $building->name }}">
                                                            @foreach($building->rooms as $room)
                                                                <option value="{{ $room->id }}"{{ $camper->roomid == $room->id ? ' selected' : '' }}>
                                                                    {{ $room->room_number }} {{ $room->is_handicap == '1' ? ' - HC' : '' }}
                                                                    {{'(' . count($room->occupants) . '/' . $room->capacity . ')'}}
                                                                </option>
                                                            @endforeach
                                                        </optgroup>
                                                    @endforeach
                                                </select>
                                            @else
                                                {{ empty($camper->room_number) ? 'Unassigned' : $camper->room_number }}
                                            @endif
                                        </td>
                                        <td width="10%">
                                            @include('admin.controls', ['id' => 'c/' . $camper->id])
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </form>
                    </td>
                </tr>
            @endforeach
            <tfoot>
            <tr>
                <td colspan="4" align="right"><strong>Total Campers
                        Attending: </strong> {{ $families->sum('count') }}</td>
            </tr>
            </tfoot>
        </table>
    </div>
@endsection

@section('script')
    <script type="text/javascript">

        $(function () {
            $("select.roomlist").on('change', function () {
                $("button#save-" + $(this).attr("data-familyid")).addClass("btn-primary").removeClass("btn-info btn-success btn-danger");
            });

            $("button.roomsave").on('click', function (e) {
                e.preventDefault();
                var form = $("form#roomchange-" + $(this).attr("data-familyid"));
                $(this).removeClass("btn-primary btn-danger").prop("disabled", true);
                $.ajax({
                    url: form.attr("action"),
                    type: 'post',
                    data: form.serialize(),
                    success: function (data) {
                        $("button#save-" + data).addClass("btn-success").prop("disabled", false);
                    },
                    error: function () {
                        $("button:disabled").addClass("btn-danger").prop("disabled", false);
                    }
                });
            });
        });
    </script>
@endsection

