@extends('layouts.app')

@section('title')
    Workshops
@endsection

@section('content')
    <div class="container">
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/tools/workshops') }}">
            @include('snippet.flash')

            @include('snippet.navtabs', ['tabs' => $timeslots, 'id'=> 'id', 'option' => 'name'])

            <div class="tab-content">
                @foreach($timeslots as $timeslot)
                    <div role="tabpanel" class="tab-pane fade{{ $loop->first ? ' active show' : '' }}"
                         aria-expanded="{{ $loop->first ? 'true' : 'false' }}" id="{{ $timeslot->id }}">
                        @if($timeslot->id != '1005')
                            <h5>{{ $timeslot->start_time->format('g:i A') }}
                                - {{ $timeslot->end_time->format('g:i A') }}</h5>
                        @endif
                        <table class="table table-bordered w-auto">
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
                            @foreach($timeslot->newworkshops()->orderBy('order')->get() as $workshop)
                                <tr id="{{ $workshop->id }}">
                                    <td class="teditable">{{ $workshop->name }}</td>
                                    <td class="teditable">{{ $workshop->led_by}}</td>
                                    <td class="teditable">{{ $workshop->room->room_number }}</td>
                                    <td class="teditable">{{ $workshop->order }}</td>
                                    <td>{{ $workshop->blurb }}</td>
                                    <td class="teditable">{{ $workshop->capacity }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <div class="well">
                            <h4>Add New Workshop</h4>
                            @include('snippet.formgroup', ['label' => 'Workshop Name',
                                'attribs' => ['name' => $timeslot->id . '-name',
                                'placeholder' => 'Brief title of workshop']])

                            @include('snippet.formgroup', ['label' => 'Workshop Leader',
                                'attribs' => ['name' => $timeslot->id . '-led_by',
                                'placeholder' => 'First and last name of the camper(s) (no \'led by\')']])

                            @include('snippet.formgroup', ['type' => 'select', 'class' => ' roomid',
                                'label' => 'Workshop Room', 'attribs' => ['name' => $timeslot->id . '-roomid'],
                                'default' => 'Choose a room', 'list' => $rooms, 'option' => 'room_number'])

                            @include('snippet.formgroup', ['label' => 'Display Order',
                                'attribs' => ['name' => $timeslot->id . '-order', 'data-number-to-fixed' => '0',
                                'placeholder' => 'Position in which to display the workshop', 'min' => '1']])

                            @include('snippet.checkbox', ['label' => 'Days', 'id' => $timeslot->id,
                                'list' => ['m' => 'Monday', 't' => 'Tuesday', 'w' => 'Wednesday',
                                'h' => 'Thursday', 'f' => 'Friday']])

                            @include('snippet.formgroup', ['label' => 'Capacity',
                                'attribs' => ['name' => $timeslot->id . '-capacity', 'min' => '1',
                                'placeholder' => '999 for unlimited', 'data-number-to-fixed' => '0']])

                            @include('snippet.formgroup', ['type' => 'text', 'label' => 'Brief Summary',
                                'attribs' => ['name' => $timeslot->id . '-blurb']])

                        </div>
                    </div>
                @endforeach
            </div>
            @include('snippet.formgroup', ['type' => 'submit', 'label' => '', 'attribs' => ['name' => 'Save Changes']])
        </form>
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