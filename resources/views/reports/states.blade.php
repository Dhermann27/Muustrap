@extends('layouts.app')

@section('title')
    States &amp; Churches
@endsection

@section('content')

    <ul class="nav nav-tabs flex-column flex-lg-row" role="tablist">
        @foreach($years as $thisyear => $states)
            <li role="presentation" class="nav-item">
                <a href="#{{ $thisyear }}" aria-controls="{{ $thisyear }}" role="tab"
                   class="nav-link{!! $loop->first ? ' active' : '' !!}" data-toggle="tab">{{ $thisyear }}</a>
            </li>
        @endforeach
    </ul>

    <div class="tab-content">
        @foreach($years as $thisyear => $states)
            <div role="tabpanel" class="tab-pane fade{{ $loop->first ? ' active show' : '' }}"
                 aria-expanded="{{ $loop->first ? 'true' : 'false' }}" id="{{ $thisyear }}">
                @foreach($states as $state)
                    <div class="card-accordion" id="{{ $thisyear }}-accordion" role="tablist"
                         aria-multiselectable="true">
                        <div class="card">
                            <div class="card-header" role="tab"
                                 id="heading-{{ $thisyear }}-{{ $state->code }}">
                                <h4 class="panel-title">
                                    <span class="p-2 float-right">
                                        {{ $state->total }}
                                        <i class="fa fa-male"></i>
                                    </span>
                                    <a {{ $loop->last ? 'class="show" ' : '' }}role="button" data-toggle="collapse"
                                       data-parent="#{{ $thisyear }}-accordion"
                                       href="#collapse-{{ $thisyear }}-{{ $state->code }}"
                                       aria-controls="collapse-{{ $thisyear }}-{{ $state->code }}">
                                        {{ $state->code }}
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse-{{ $thisyear }}-{{ $state->code }}"
                                 class="in collapse{{ $loop->first ? ' show' : '' }}" role="tabpanel"
                                 aria-labelledby="heading-{{ $thisyear }}-{{ $state->code }}">
                                <table class="table w-auto">
                                    <thead>
                                    <tr>
                                        <th width="50%">Church Name</th>
                                        <th width="25%">City, State</th>
                                        <th width="25%">Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($churches->filter(function ($value) use ($thisyear, $state) {
                                        return $value->year==$thisyear && $value->churchstatecd==$state->code;
                                    }) as $church)
                                        <tr>
                                            <td>{{ $church->churchname }}</td>
                                            <td>{{ $church->churchcity }}, {{ $church->churchstatecd }}</td>
                                            <td>{{ $church->total }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
@endsection

