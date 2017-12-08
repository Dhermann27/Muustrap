    @foreach($timeslot->workshops as $workshop)
        <button type="button" data-content="{{ $workshop->id }}" data-toggle="tooltip"
                id="{{ $camperid }}-{{ $workshop->id }}"
                @if($workshop->enrolled >= $workshop->capacity)
                class="list-group-item list-group-item-action disabled"
                title="Workshop Full">
            <i class="fa fa-times fa-pull-right"></i>
            @elseif($workshop->enrolled >= ($workshop->capacity * .75))
                class="list-group-item list-group-item-action"
                title="Filling fast!">
                <i class="fa fa-exclamation-triangle fa-pull-right"></i>
            @else
                class="list-group-item list-group-item-action">
            @endif
            {{ $workshop->name }}
            ({{ $workshop->display_days }})
        </button>
    @endforeach
