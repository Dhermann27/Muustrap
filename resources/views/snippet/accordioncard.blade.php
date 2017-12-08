{{--@component('snippet.accordioncard', ['id' => $year->year, 'loop' => $loop, 'heading' => $building->id, 'title' => $building->name])--}}
<div class="card-accordion" id="{{ $id }}-accordion" role="tablist" aria-multiselectable="true">
    <div class="card">
        <div role="tab" id="heading-{{ $id }}-{{ $heading }}">
            <h4 class="card-header">
                @if(isset($badge))
                    {{ $badge }}
                @endif
                <a {{ $loop->first ? 'class="show" ' : ''}}role="button" data-toggle="collapse"
                   data-parent="#{{ $id }}-accordion" href="#collapse-{{ $id }}-{{ $heading }}"
                   aria-controls="collapse-{{ $id }}-{{ $heading }}">
                    {{ $title }}
                </a>
            </h4>
        </div>
        <div id="collapse-{{ $id }}-{{ $heading }}"
             class="in collapse{{ $loop->first ? ' show' : '' }}"
             role="tabpanel" aria-labelledby="heading-{{ $id }}-{{ $heading }}">
            {{ $slot }}
        </div>
    </div>
</div>
