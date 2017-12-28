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
                <div id="{{ $thisyear }}-accordion" role="tablist">
                    @foreach($states as $state)
                        @component('snippet.accordioncard', ['id' => $thisyear, 'loop' => $loop, 'heading' => $state->code, 'title' => $state->code])
                            @slot('badge')
                                <span class="p-2 float-right">{{ $state->total }} <i class="fa fa-male"></i></span>
                            @endslot
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
                        @endcomponent
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
@endsection

