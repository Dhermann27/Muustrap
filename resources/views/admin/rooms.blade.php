@extends('layouts.app')

@section('content')
    <p>&nbsp;</p>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">Assign Room</div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST"
                      action="{{ url('/roomselection/' . $campers->first()[0]->familyid) }}">
                    {{ csrf_field() }}

                    @if(!empty($success))
                        <div class=" alert alert-success">
                            {!! $success !!}
                        </div>
                    @endif
                    <div class="tab-content">
                        @foreach($campers as $id => $years)
                            <div class="form-group{{ $errors->has($id . '-roomid') ? ' has-error' : '' }}">
                                <label for="{{ $id }}-roomid" class="col-md-4 control-label">
                                    {{ $years[0]->firstname }} {{ $years[0]->lastname }}
                                </label>

                                @if($readonly === false)
                                    <div class="col-md-4">
                                        <select id="{{ $id }}-roomid" class="form-control roomlist"
                                                name="{{ $id }}-roomid">
                                            <option value="0">No Room Selected</option>
                                            @foreach($buildings as $building)
                                                <optgroup label="{{ $building->name }}">
                                                    @foreach($building->rooms as $room)
                                                        <option value="{{ $room->id }}"{{ $years->where('year', $currentyear)->first() && $years->where('year', $currentyear)->first()->roomid == $room->id ? ' selected' : '' }}>
                                                            {{ $room->room_number }}
                                                            ({{ $room->occupant_count }}/{{ $room->capacity }})
                                                        </option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                        <button id="quickme" class="pull-right fa fa-bolt" data-toggle="tooltip"
                                                title="Assign entire family to this room"></button>
                                        @if ($errors->has($id . '-roomid'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first($role->id . '-camperid') }}</strong>
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
                                    @foreach($years as $year)
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
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('button#quickme').on('click', function (e) {
            e.preventDefault();
            $("select.roomlist").val($(this).prev("select.roomlist").val());
        })
    </script>
@endsection
