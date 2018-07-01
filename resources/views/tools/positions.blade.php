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
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Position</th>
                                <th>Name</th>
                                <th>Maximum Compensation</th>
                                <th>Controls</th>
                                <th>Delete?</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($program->assignments()->orderBy('staffpositionname')->orderBy('lastname')->orderBy('firstname')->get() as $assignment)
                                <tr>
                                    <td>{{ $assignment->staffpositionname }}</td>
                                    <td>{{ $assignment->lastname }}, {{ $assignment->firstname }}</td>
                                    <td>${{ money_format('%.2n', $assignment->max_compensation) }}</td>
                                    <td>
                                        @include('admin.controls', ['id' => 'c/' . $assignment->camperid])
                                    </td>
                                    <td>
                                        @include('snippet.delete', ['id' => $assignment->camperid . '-' . $assignment->staffpositionid])
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="5" align="right"><strong>Maximum Compensation:</strong>
                                    ${{ money_format('%.2n', $program->assignments->sum('max_compensation')) }}</td>
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
