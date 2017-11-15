{{--@include('snippet.navtabs', ['tabs' => $programs, 'name' => 'option'])--}}

{{--<div class="tab-content">--}}
{{--@foreach($programs as $program)--}}
{{--<div role="tabpanel" class="tab-pane fade{{ $loop->first ? ' active show' : '' }}"--}}
{{--aria-expanded="{{ $loop->first ? 'true' : 'false' }}" id="{{ $program->id }}">--}}

<ul class="nav nav-tabs flex-column flex-lg-row" role="tablist">
    @foreach($tabs as $tab)
        <li role="presentation" class="nav-item">
            <a href="#{{ $tab->id }}" aria-controls="{{ $tab->id }}" role="tab"
               class="nav-link{!! $loop->first ? ' active' : '' !!}" data-toggle="tab">{{ $tab->$option }}</a>
        </li>
    @endforeach
</ul>
