@inject('home', 'App\Http\Controllers\HomeController')
@extends('layouts.app')

@section('title')
    Staff Assignments
@endsection

@section('content')
    <div class="container">
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/tools/staffpositions') }}">
            @include('snippet.flash')

            @include('snippet.navtabs', ['tabs' => $programs, 'id'=> 'id', 'option' => 'name'])

            <div class="tab-content">
                @foreach($programs as $program)
                    <div role="tabpanel" class="tab-pane fade{{ $loop->first ? ' active show' : '' }}"
                         aria-expanded="{{ $loop->first ? 'true' : 'false' }}" id="{{ $program->id }}">
                        <p>&nbsp;</p>
                        <table class="table table-sm w-auto">
                            <thead>
                            <tr>
                                <th>Position</th>
                                <th>Name</th>
                                <th>Current Compensation</th>
                                <th>Controls</th>
                                <th>Delete?</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($program->assignments()->orderBy('staffpositionname')->orderBy('lastname')->orderBy('firstname')->get() as $assignment)
                                <tr>
                                    <td>{{ $assignment->staffpositionname }}</td>
                                    <td>{{ $assignment->lastname }}, {{ $assignment->firstname }}</td>
                                    <td>
                                        @if($assignment->compensation > 0)
                                            ${{ money_format('%.2n', $assignment->compensation) }}
                                        @else
                                            Registered but not assigned
                                        @endif
                                    </td>
                                    <td>
                                        @include('admin.controls', ['id' => 'c/' . $assignment->camperid])
                                    </td>
                                    <td class="btn-group" data-toggle="buttons">
                                        <label class="btn btn-default">
                                            <input type="checkbox"
                                                   name="{{ $assignment->camperid }}-{{ $assignment->staffpositionid }}-delete"
                                                   autocomplete="off"/> Delete
                                        </label>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="5" align="right"><strong>Total Compensation:</strong>
                                    ${{ money_format('%.2n', $program->assignments->sum('compensation')) }}</td>
                            </tr>
                            </tfoot>
                        </table>

                        @include('snippet.formgroup', ['label' => 'Add New Assignment', 'hidden' => 'id', 'class' => 'camperlist',
                            'attribs' => ['name' => $program->id . '-camper', 'placeholder' => 'Camper Name']])

                        @include('snippet.formgroup', ['type' => 'select',
                            'label' => 'Position', 'attribs' => ['name' => $program->id . '-staffpositionid'],
                            'default' => 'Choose a position', 'option' => 'name',
                            'list' => $program->staffpositions($home->year()->year)->orderBy('name')->get()])
                    </div>
                @endforeach
            </div>
            @include('snippet.formgroup', ['type' => 'submit', 'label' => '', 'attribs' => ['name' => 'Save Changes']])
        </form>
    </div>
@endsection
