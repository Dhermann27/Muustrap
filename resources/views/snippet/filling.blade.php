@inject('home', 'App\Http\Controllers\HomeController')
@if($home->year()->isLive())
    @if($workshop->capacity == 999)
        <span class="alert alert-success badge">Unlimited Enrollment</span>
    @elseif($workshop->enrolled >= $workshop->capacity)
        <span class="alert alert-danger badge">Waitlist Available</span>
    @elseif($workshop->enrolled >= ($workshop->capacity * .75))
        <span class="alert alert-warning badge">Filling Fast!</span>
    @else
        <span class="alert alert-info badge">Open For Enrollment</span>
    @endif
@endif