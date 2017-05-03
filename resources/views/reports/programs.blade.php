@extends('layouts.app')

@section('content')
    <p>&nbsp;</p>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">Program Participants</div>
            <div class="panel-body">
                <ul class="nav nav-tabs" role="tablist">
                    @foreach($programs as $program)
                        <li role="presentation"{!! $loop->first ? ' class="active"' : '' !!}>
                            <a href="#{{ $program->id }}" aria-controls="{{ $program->id }}" role="tab"
                               data-toggle="tab">{{ $program->name }}</a></li>
                    @endforeach
                </ul>

                <div class="tab-content">
                    @foreach($programs as $program)
                        @if(count($program->participants) > 0)
                            <div role="tabpanel" class="tab-pane fade{{ $loop->first ? ' in active' : '' }}"
                                 id="{{ $program->id }}">
                                <div class="panel-group" id="{{ $program->id }}-accordion" role="tablist"
                                     aria-multiselectable="true">
                                    <table class="table table-responsive">
                                        <thead>
                                        <tr>
                                            <th>Pronoun</th>
                                            <th>Name</th>
                                            <th>Age</th>
                                            @if($program->participants->first()->age<18)
                                                <th>Grade</th>
                                                <th>Parent/Sponsor</th>
                                            @endif
                                            <th>Controls</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($program->participants as $participant)
                                            <tr>
                                                <td>{{ $participant->pronounname }}</td>
                                                <td>
                                                    {{ $participant->lastname }}, {{ $participant->firstname }}
                                                    @if(isset($participant->email))
                                                        <a href="mailto:{{ $participant->email }}"
                                                           class="fa fa-envelope"></a>
                                                    @endif
                                                </td>
                                                <td>{{ $participant->age }}</td>
                                                @if($program->participants->first()->age<18)
                                                    <td>{{ max($participant->grade, 0) }}</td>
                                                    <td>{!! $participant->parent !!}</td>
                                                @endif
                                                <td>
                                                    @include('admin.controls', ['id' => 'c/' . $participant->id])
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td colspan="{{ $program->participants->first()->age<18 ? '6' : '4' }}"
                                                align="right"><strong>Total
                                                    Campers: </strong> {{ count($program->participants) }}</td>
                                        </tr>
                                        <tr class="hidden-print">
                                            <td colspan="{{ $program->participants->first()->age<18 ? '6' : '4' }}">
                                                Distribution list: {{ $program->emails }}
                                            </td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

