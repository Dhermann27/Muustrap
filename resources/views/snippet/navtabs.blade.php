{{--@component('snippet.navtabs', ['tabs' => $timeslots, 'id'=> 'id', 'option' => 'name'])--}}
{{--@foreach($timeslots as $timeslot)--}}
{{--<div class="tab-pane active fade{!! $loop->first ? ' show' : '' !!}" id="{{ $timeslot->id }}" role="tabpanel">--}}
<ul class="nav nav-tabs flex-column flex-lg-row" role="tablist">
    @foreach($tabs as $tab)
        <li class="nav-item{{ $loop->first ? ' pl-5' : '' }}">
            <a class="nav-link{{ $loop->first ? ' active' : '' }}" data-toggle="tab" href="#tab-{{ $tab->id }}" role="tab">
                {{ $option == 'fullname' ? $tab->firstname . ' ' . $tab->lastname : $tab->$option }}
            </a>
        </li>
    @endforeach
</ul>
<div class="tab-content p-3">
    {{ $slot }}
</div>
