<div class="progress mb-3">
    <div class="progress-bar w-{{ $width }} progress-bar-striped progress-bar-animated progress-bar-animated-progress
    {{ isset($bg) ? 'bg-' . $bg : '' }}"
         data-toggle="progress-bar-animated-progress" role="progressbar" aria-valuenow="{{ $width }}" aria-valuemin="0"
         aria-valuemax="100">
        {{ $slot }}
    </div>
</div>