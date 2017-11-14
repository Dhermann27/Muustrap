@extends('layouts.app')

@section('title')
    Assign Room
@endsection

@section('content')
    <div class="container">
        <form class="form-horizontal" role="form" method="POST"
              action="{{ url('/roomselection/f/' . $campers->first()->familyid) }}">
            @include('snippet.flash')

            @foreach($campers as $camper)
                <div class="form-group row{{ $errors->has($camper->id . '-roomid') ? ' has-danger' : '' }}">
                    <label for="{{ $camper->id }}-roomid" class="col-md-4 control-label">
                        <a id="quickcopy" href="#" class="p-2 float-right" data-toggle="tooltip"
                           title="Assign entire family to this room"><i class="fa fa-copy"></i></a>
                        {{ $camper->firstname }} {{ $camper->lastname }}
                    </label>

                    @if($readonly === false)
                        <div class="col-md-4">
                            <select id="{{ $camper->id }}-roomid"
                                    class="form-control roomlist{{ $errors->has($camper->id . '-roomid') ? ' is-invalid' : '' }}"
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
                            @if ($errors->has($camper->id . '-roomid'))
                                <span class="invalid-feedback">
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
            @if($readonly === false)
                @include('snippet.formgroup', ['type' => 'submit', 'label' => '', 'attribs' => ['name' => 'Save Changes']])
            @endif
        </form>
    </div>
@endsection

@section('script')
    <script>
        $('a#quickcopy').on('click', function (e) {
            e.preventDefault();
            var val = $(this).parent().next().find("select.roomlist").val();
            $("select.roomlist").val(val);
        })
    </script>
@endsection
