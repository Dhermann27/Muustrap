@extends('layouts.app')

@section('content')
    <p>&nbsp;</p>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">States &amp; Churches</div>
            <div class="panel-body">
                <ul class="nav nav-tabs" role="tablist">
                    @foreach($years as $thisyear => $states)
                        <li role="presentation"{!! $loop->last ? ' class="active"' : '' !!}>
                            <a href="#{{ $thisyear }}" aria-controls="{{ $thisyear }}" role="tab"
                               data-toggle="tab">{{ $thisyear }}</a></li>
                    @endforeach
                </ul>

                <div class="tab-content">
                    @foreach($years as $thisyear => $states)
                        <div role="tabpanel" class="tab-pane fade{{ $loop->last ? ' in active' : '' }}"
                             id="{{ $thisyear }}">
                            @foreach($states as $state)
                                <div class="panel-group" id="{{ $thisyear }}-accordion" role="tablist"
                                     aria-multiselectable="true">
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab"
                                             id="heading-{{ $thisyear }}-{{ $state->code }}">
                                            <span class="pull-right">
                                                {{ $state->total }}
                                                <i class="fa fa-fire"></i>
                                            </span>
                                            <h4 class="panel-title">
                                                <a role="button" data-toggle="collapse"
                                                   data-parent="#{{ $thisyear }}-accordion"
                                                   href="#collapse-{{ $thisyear }}-{{ $state->code }}"
                                                   aria-controls="collapse-{{ $thisyear }}-{{ $state->code }}">
                                                    {{ $state->code }}
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapse-{{ $thisyear }}-{{ $state->code }}"
                                             class="panel-collapse collapse"
                                             role="tabpanel"
                                             aria-labelledby="heading-{{ $thisyear }}-{{ $state->code }}">
                                            <div class="panel-body">
                                                <table class="table table-responsive">
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
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
@endsection

