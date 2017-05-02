@extends('layouts.app')

@section('content')
    <p>&nbsp;</p>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">Volunteers</div>
            <div class="panel-body">
                <ul class="nav nav-tabs" role="tablist">
                    @foreach($years as $thisyear => $volunteers)
                        <li role="presentation"{!! $loop->last ? ' class="active"' : '' !!}>
                            <a href="#{{ $thisyear }}" aria-controls="{{ $thisyear }}" role="tab"
                               data-toggle="tab">{{ $thisyear }}</a></li>
                    @endforeach
                </ul>

                <div class="tab-content">
                    @foreach($years as $thisyear => $volunteers)
                        <div role="tabpanel" class="tab-pane fade{{ $loop->last ? ' in active' : '' }}"
                             id="{{ $thisyear }}">
                            @foreach($positions as $position)
                                @if(count($volunteers->filter(function ($value) use ($thisyear, $position) {
                                                        return $value->year==$thisyear && $value->volunteerpositionid==$position->id;
                                                    }))>0)
                                    <div class="panel-group" id="{{ $thisyear }}-accordion" role="tablist"
                                         aria-multiselectable="true">
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab"
                                                 id="heading-{{ $thisyear }}-{{ $position->id }}">
                                            <span class="pull-right">
                                                {{ count($volunteers->filter(function ($value) use ($thisyear, $position) {
                                                        return $value->year==$thisyear && $value->volunteerpositionid==$position->id;
                                                    })) }}
                                                <i class="fa fa-handshake-o"></i>
                                            </span>
                                                <h4 class="panel-title">
                                                    <a role="button" data-toggle="collapse"
                                                       data-parent="#{{ $thisyear }}-accordion"
                                                       href="#collapse-{{ $thisyear }}-{{ $position->id }}"
                                                       aria-controls="collapse-{{ $thisyear }}-{{ $position->id }}">
                                                        {{ $position->name }}
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapse-{{ $thisyear }}-{{ $position->id }}"
                                                 class="panel-collapse collapse"
                                                 role="tabpanel"
                                                 aria-labelledby="heading-{{ $thisyear }}-{{ $position->id }}">
                                                <div class="panel-body">
                                                    <table class="table table-responsive">
                                                        <thead>
                                                        <tr>
                                                            <th width="50%">Camper Name</th>
                                                            <th width="50%">Controls</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($volunteers->filter(function ($value) use ($thisyear, $position) {
                                                            return $value->year==$thisyear && $value->volunteerpositionid==$position->id;
                                                        }) as $volunteer)
                                                            <tr>
                                                                <td>{{ $volunteer->lastname }}, {{ $volunteer->firstname }}</td>
                                                                <td>
                                                                    @include('admin.controls', ['id' => 'c/' . $volunteer->id])
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

