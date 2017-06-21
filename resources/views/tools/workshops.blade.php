@extends('layouts.app')

@section('content')
    <p>&nbsp;</p>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">Workshops</div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/tools/workshops') }}">
                    {{ csrf_field() }}

                    @if(!empty($success))
                        <div class=" alert alert-success">
                            {!! $success !!}
                        </div>
                    @endif
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
                                <table class="table table-responsive">
                                    <thead>
                                    <tr>
                                        <th id="name">Name</th>
                                        <th id="led_by">Led By</th>
                                        <th id="roomid" class="select">Room</th>
                                        <th id="order">Order</th>
                                        <th>Blurb</th>
                                        <th id="capacity">Capacity</th>
                                    </tr>
                                    </thead>
                                    <tbody class="editable">
                                    @foreach($timeslot->workshops()->orderBy('order')->get() as $workshop)
                                        <tr id="{{ $workshop->id }}">
                                            <td>{{ $workshop->name }}</td>
                                            <td>{{ $workshop->led_by}}</td>
                                            <td>{{ $workshop->room->room_number }}</td>
                                            <td>{{ $workshop->order }}</td>
                                            <td>{{ $workshop->blurb }}</td>
                                            <td>{{ $workshop->capacity }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                                <div class="form-group{{ $errors->has($timeslot->id . '-name') ? ' has-error' : '' }}">
                                    <label for="{{ $timeslot->id }}-name" class="col-md-4 control-label">Add
                                        New Workshop</label>

                                    <div class="col-md-6">
                                        <input type="text" id="{{ $timeslot->id }}-name" class="form-control"
                                               name="{{ $timeslot->id }}-name" placeholder="Workshop Name">

                                        @if ($errors->has($timeslot->id . '-name'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first($timeslot->id . '-name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has($timeslot->id . '-led_by') ? ' has-error' : '' }}">
                                    <label for="{{ $timeslot->id }}-led_by" class="col-md-4 control-label">Led
                                        By</label>

                                    <div class="col-md-6">
                                        <input id="{{ $timeslot->id }}-led_by" type="text"
                                               class="form-control easycamper" name="{{ $timeslot->id }}-led_by"
                                               autocomplete="off"
                                               placeholder="First and last name of the camper (no 'led by')">

                                        @if ($errors->has($timeslot->id . '-led_by'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first($timeslot->id . '-led_by') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has($timeslot->id . '-roomid') ? ' has-error' : '' }}">
                                    <label for="{{ $timeslot->id }}-roomid" class="col-md-4 control-label">Room</label>

                                    <div class="col-md-6">
                                        <select id="{{ $timeslot->id }}-roomid" name="{{ $timeslot->id }}-roomid"
                                                class="form-control roomid">
                                            <option value="0">Choose a room</option>
                                            @foreach($rooms as $room)
                                                <option value="{{ $room->id }}">{{ $room->room_number}}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has($timeslot->id . '-roomid'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first($timeslot->id . '-roomid') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has($timeslot->id . '-order') ? ' has-error' : '' }}">
                                    <label for="{{ $timeslot->id }}-order" class="col-md-4 control-label">Display
                                        Order</label>

                                    <div class="col-md-6">
                                        <input type="number" id="{{ $timeslot->id }}-order" class="form-control"
                                               name="{{ $timeslot->id }}-order" data-number-to-fixed="0" min="1">

                                        @if ($errors->has($timeslot->id . '-order'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first($timeslot->id . '-order') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="days" class="col-md-4 control-label">Days</label>
                                    <div class="col-md-6 btn-group" data-toggle="buttons">
                                        <label class="btn btn-default">
                                            <input type="checkbox" name="{{ $timeslot->id }}-m" autocomplete="off"/>
                                            Monday
                                        </label>

                                        <label class="btn btn-default">
                                            <input type="checkbox" name="{{ $timeslot->id }}-t" autocomplete="off"/>
                                            Tuesday
                                        </label>

                                        <label class="btn btn-default">
                                            <input type="checkbox" name="{{ $timeslot->id }}-w" autocomplete="off"/>
                                            Wednesday
                                        </label>

                                        <label class="btn btn-default">
                                            <input type="checkbox" name="{{ $timeslot->id }}-th" autocomplete="off"/>
                                            Thursday
                                        </label>

                                        <label class="btn btn-default">
                                            <input type="checkbox" name="{{ $timeslot->id }}-f" autocomplete="off"/>
                                            Friday
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has($timeslot->id . '-capacity') ? ' has-error' : '' }}">
                                    <label for="{{ $timeslot->id }}-capacity" class="col-md-4 control-label">Capacity
                                        (999 for unlimited)</label>

                                    <div class="col-md-6">
                                        <input type="number" id="{{ $timeslot->id }}-capacity" class="form-control"
                                               name="{{ $timeslot->id }}-capacity" data-number-to-fixed="0" min="1">

                                        @if ($errors->has($timeslot->id . '-capacity'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first($timeslot->id . '-capacity') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has($timeslot->id . '-blurb') ? ' has-error' : '' }}">
                                    <label for="{{ $timeslot->id }}-blurb" class="col-md-4 control-label">Blurb</label>

                                    <div class="col-md-6">
                                    <textarea id="{{ $timeslot->id }}-blurb" class="form-control"
                                              name="{{ $timeslot->id }}-blurb"></textarea>

                                        @if ($errors->has($timeslot->id . '-blurb'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first($timeslot->id . '-blurb') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="form-group">
                        <div class="col-md-2 col-md-offset-8">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(".easycamper").each(function () {
            $(this).autocomplete({
                source: "/data/camperlist",
                minLength: 3,
                autoFocus: true,
                select: function (event, ui) {
                    $(this).val(ui.item.firstname + " " + ui.item.lastname);
                    return false;
                }
            }).autocomplete('instance')._renderItem = function (ul, item) {
                return $("<li>").append("<div>" + item.lastname + ", " + item.firstname + "</div>").appendTo(ul);
            };
        });
    </script>
@endsection