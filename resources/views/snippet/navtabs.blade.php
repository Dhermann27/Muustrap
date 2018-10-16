{{--@component('snippet.navtabs', ['tabs' => $timeslots, 'id'=> 'id', 'option' => 'name'])--}}
{{--@foreach($timeslots as $timeslot)--}}
{{--<div class="tab-content" id="{{ $timeslot->id }}">--}}

<div class="row">
    <div class="col-12 inner-top">
        <div class="tabs tabs-top tab-container">
            <ul class="etabs text-center">
                @foreach($tabs as $tab)
                    <li class="tab">
                        <a href="#{{ $tab->$id }}">
                            {{ $option == 'fullname' ? $tab->firstname . ' ' . $tab->lastname : $tab->$option }}
                        </a>
                    </li>
                @endforeach
            </ul>

            <div class="panel-container">
                {{ $slot }}
            </div>

        </div>
    </div>
</div>