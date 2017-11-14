<ul class="nav nav-tabs flex-column flex-lg-row" role="tablist">
    @foreach($tabs as $tab)
        <li role="presentation" class="nav-item">
            <a href="#{{ $tab->id }}" aria-controls="{{ $tab->id }}" role="tab"
               class="nav-link{!! $loop->first ? ' active' : '' !!}" data-toggle="tab">{{ $tab->name }}</a>
        </li>
    @endforeach
</ul>
