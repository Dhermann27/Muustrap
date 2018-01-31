{{--@component('snippet.accordioncard', ['id' => $year->year, 'loop' => $loop, 'heading' => $building->id, 'title' => $building->name])--}}
<div class="card">
    <h4 class="card-header p-0" role="tab" id="heading-{{ $id }}-{{ $heading }}">
        <a data-toggle="collapse" data-parent="#{{ $id }}-accordion" href="#collapse-{{ $id }}-{{ $heading }}"
           aria-expanded="{{ !isset($closed) && $loop->first ? 'true' : 'false' }}"
           aria-controls="collapse-{{ $id }}-{{ $heading }}">
            {{ $title }}
            @if(isset($badge))
                {{ $badge }}
            @endif
        </a>
    </h4>
    <div id="collapse-{{ $id }}-{{ $heading }}" role="tabpanel"
         class="collapse d-print-block{{ !isset($closed) && $loop->first ? ' show' : '' }}"
         aria-labelledby="heading-{{ $id }}-{{ $heading }}">
        <div class="card-body">{{ $slot }}</div>
    </div>
</div>