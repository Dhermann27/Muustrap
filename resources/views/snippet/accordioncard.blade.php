{{--<div id="{{ $id }}-accordion" role="tablist">--}}
{{--@component('snippet.accordioncard', ['id' => $year->year, 'loop' => $loop, 'heading' => $building->id, 'title' => $building->name])--}}
<div class="card">
    <div class="card-header" role="tab" id="heading-{{ $id }}-{{ $heading }}">
        <h5 class="mb-0">
            @if(isset($badge))
                {{ $badge }}
            @endif
            <a data-toggle="collapse" href="#collapse-{{ $id }}-{{ $heading }}"
               aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
               aria-controls="collapse-{{ $id }}-{{ $heading }}">
                {{ $title }}
            </a>
        </h5>
    </div>
    <div id="collapse-{{ $id }}-{{ $heading }}" data-parent="#{{ $id }}-accordion"
         class="collapse d-print-block{{ !isset($closed) && $loop->first ? ' show' : '' }}"
         role="tabpanel" aria-labelledby="heading-{{ $id }}-{{ $heading }}">
        <div class="card-body">{{ $slot }}</div>
    </div>
</div>
{{--</div>--}}
