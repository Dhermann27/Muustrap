@extends('layouts.app')

@section('title')
    Assign Room
@endsection

@section('content')
    <form class="form-horizontal" role="form" method="POST"
          action="{{ url('/roomselection/f/' . $campers->first()->familyid) }}">
        @include('snippet.flash')

        <div class="tab-content">
            @foreach($campers as $camper)
                <div class="form-group{{ $errors->has($camper->id . '-roomid') ? ' has-error' : '' }}">
                    <label for="{{ $camper->id }}-roomid" class="col-md-4 control-label">
                        {{ $camper->firstname }} {{ $camper->lastname }}
                    </label>

                    @if($readonly === false)
                        <div class="col-md-4">
                            <select id="{{ $camper->id }}-roomid" class="form-control roomlist"
                                    name="{{ $camper->id }}-roomid">
                                <option value="0">No Room Selected</option>
                                @foreach($buildings as $building)
                                    <optgroup label="{{ $building->name }}">
                                        @foreach($building->rooms as $room)
                                            <option value="{{ $room->id }}"{{ $camper->roomid == $room->id ? ' selected' : '' }}>
                                                {{ $room->room_number }} {{ $room->is_handicap == '1' ? ' - HC' : '' }}
                                                ({{ $room->occupant_count }}/{{ $room->capacity }})
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                            <button id="quickme" class="pull-right fa fa-bolt" data-toggle="tooltip"
                                    title="Assign entire family to this room"></button>
                            @if ($errors->has($camper->id . '-roomid'))
                                <span class="help-block">
                                                <strong>{{ $errors->first($camper->id . '-camperid') }}</strong>
                                            </span>
                            @endif
                        </div>
                    @endif

                    <table class="table table-responsive table-condensed">
                        <thead>
                        <tr>
                            <th>Year</th>
                            <th>Building</th>
                            <th>Room Number</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($camper->history() as $year)
                            <tr>
                                <td>{{ $year->year }}</td>
                                <td>{{ $year->buildingname }}</td>
                                <td>{{ $year->room_number }}</td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach
        </div>
        @if($readonly === false)
            <div class="form-group">
                <div class="col-md-2 col-md-offset-8">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        @endif
    </form>
@endsection

@section('script')
    <script>
        $('button#quickme').on('click', function (e) {
            e.preventDefault();
            $("select.roomlist").val($(this).prev("select.roomlist").val());
        })
    </script>
@endsection
