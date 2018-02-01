@extends('layouts.app')

@section('title')
    Volunteers
@endsection

@section('content')
    <ul class="nav nav-tabs flex-column flex-lg-row" role="tablist">
        @foreach($years as $thisyear => $volunteers)
            <li role="presentation" class="nav-item">
                <a href="#{{ $thisyear }}" aria-controls="{{ $thisyear }}" role="tab"
                   class="nav-link{{ $loop->last ? ' active' : '' }}" data-toggle="tab">{{ $thisyear }}</a></li>
        @endforeach
    </ul>

    <div class="tab-content">
        @foreach($years as $thisyear => $volunteers)
            <div role="tabpanel" class="tab-pane fade{{ $loop->last ? ' active show' : '' }}"
                 aria-expanded="{{ $loop->first ? 'true' : 'false' }}" id="{{ $thisyear }}">
                @component('snippet.accordion', ['id' => $thisyear ])
                    @foreach($positions as $position)
                        @if(count($volunteers->filter(function ($value) use ($thisyear, $position) {
                                return $value->year==$thisyear && $value->volunteerpositionid==$position->id;
                            }))>0)
                            @component('snippet.accordioncard', ['id' => $thisyear, 'loop' => $loop, 'heading' => $position->id, 'title' => $position->name])
                                @slot('badge')
                                    <span class="p-2 float-right">
                                    {{ count($volunteers->filter(function ($value) use ($thisyear, $position) {
                                        return $value->year==$thisyear && $value->volunteerpositionid==$position->id;
                                    })) }}
                                        <i class="fa fa-handshake"></i>
                                </span>
                                @endslot
                                <table class="table">
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
                            @endcomponent
                        @endif
                    @endforeach
                @endcomponent
            </div>
        @endforeach
    </div>
@endsection

