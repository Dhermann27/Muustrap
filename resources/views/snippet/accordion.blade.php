{{--@component('snippet.accordion', ['id' => $chargetype->id])--}}
<div id="{{ $id }}-accordion" class="card-accordion" data-accordion-focus role="tablist" aria-multiselectable="false">
    {{ $slot }}
</div>