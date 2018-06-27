@extends('layouts.app')

@section('title')
    Program Participants
@endsection

@section('content')
    @include('snippet.navtabs', ['tabs' => $programs, 'id'=> 'id', 'option' => 'name'])

    <div class="tab-content">
        @foreach($programs as $program)
            @if(count($program->participants) > 0)
                <div role="tabpanel" class="tab-pane fade{{ $loop->first ? ' active show' : '' }}"
                     aria-expanded="{{ $loop->first ? 'true' : 'false' }}" id="{{ $program->id }}">
                    <div class="panel-group" id="{{ $program->id }}" role="tablist">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Pronoun</th>
                                <th>Name</th>
                                <th>Age</th>
                                @if($program->participants->first()->age<18)
                                    <th>Parent/Sponsor</th>
                                    <th>Room</th>
                                    <th>Phone Number</th>
                                @endif
                                <th class="d-print-none">Controls</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($program->participants as $participant)
                                <tr>
                                    <td>{{ $participant->pronounname }}</td>
                                    <td>
                                        {{ $participant->lastname }}, {{ $participant->firstname }}
                                        @if(isset($participant->email))
                                            <a href="mailto:{{ $participant->email }}" class="d-print-none">
                                                <i class="far fa-envelope"></i>
                                            </a>
                                        @endif
                                    </td>
                                    <td>{{ $participant->age }}
                                        @if(isset($participant->medicalresponse))
                                            <i class="far fa-pencil-alt"
                                               title="This camper has submitted their medical response."></i>
                                        @endif
                                    </td>
                                    @if($program->participants->first()->age<18)
                                        <td>{!! $participant->parent !!}</td>
                                        <td>{{ $participant->parent_room }}</td>
                                        <td>{{ $participant->parent_phone }}</td>
                                    @endif
                                    <td class="d-print-none">
                                        @include('admin.controls', ['id' => 'c/' . $participant->id])
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="{{ $program->participants->first()->age<18 ? '8' : '4' }}" align="right">
                                    <strong>Total Campers: </strong> {{ count($program->participants) }}
                                </td>
                            </tr>
                            <tr class="d-print-none">
                                <td colspan="{{ $program->participants->first()->age<18 ? '8' : '4' }}">
                                    Distribution list: {{ $program->emails }}
                                </td>
                            </tr>
                            @if($program->participants->first()->age<18)
                                <tr class="d-print-none">
                                    <td colspan="8">
                                        Parent Distribution list:
                                        @foreach($program->participants as $participant)
                                            @foreach($participant->parents as $parent)
                                                @if(!empty($parent->email))
                                                    {{ $parent->email }};
                                                @endif
                                            @endforeach
                                        @endforeach
                                    </td>
                                </tr>
                            @endif
                            </tfoot>
                        </table>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
@endsection

