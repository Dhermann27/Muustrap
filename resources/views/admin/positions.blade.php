@extends('layouts.appstrap')

@section('title')
    Positions
@endsection

@section('content')
    <div class="container">
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/positions') }}">
            @include('snippet.flash')

            @component('snippet.navtabs', ['tabs' => $programs, 'id'=> 'id', 'option' => 'name'])
                @foreach($programs as $program)
                    <div class="tab-content" id="{{ $program->id }}">
                        <p>&nbsp;</p>
                        <table class="table">
                            <thead>
                            <tr>
                                <th id="programid" class="select">Program</th>
                                <th id="name">Name</th>
                                <th id="compensationlevelid" class="select">Compensation Level</th>
                                <th id="pctype" class="select">Position Type</th>
                                <th>Maximum Compensation</th>
                                <th>Delete?</th>
                            </tr>
                            </thead>
                            <tbody class="editable">
                            @foreach($program->staffpositions()->orderBy('name')->get()->load('compensationlevel') as $position)
                                <tr id="{{ $position->id }}">
                                    <td class="teditable">{{ $position->program->name }}</td>
                                    <td class="teditable">{{ $position->name }}</td>
                                    <td class="teditable">{{ $position->compensationlevel->name }}</td>
                                    <td class="teditable">
                                        @if($position->pctype == 1)
                                            APC
                                        @elseif($position->pctype == 2)
                                            XC
                                        @elseif($position->pctype == 3)
                                            Programs
                                        @elseif($position->pctype == 4)
                                            Consultants
                                        @endif
                                    </td>
                                    <td>
                                        ${{ money_format('%.2n', $position->compensationlevel->max_compensation) }}
                                    </td>
                                    <td>
                                        @include('snippet.delete', ['id' => $position->id])
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach
            @endcomponent

            <div class="well">
                <h4>Add New Position</h4>
                @include('snippet.formgroup', ['type' => 'select', 'class' => ' programid',
                    'label' => 'Associated Program', 'attribs' => ['name' => 'programid'],
                    'default' => 'Choose a program', 'list' => $programs, 'option' => 'name'])

                @include('snippet.formgroup', ['label' => 'Position Name',
                    'attribs' => ['name' => 'name', 'placeholder' => 'Position Name']])

                @include('snippet.formgroup', ['type' => 'select', 'class' => ' compensationlevelid',
                    'label' => 'Compensation Level', 'attribs' => ['name' => 'compensationlevelid'],
                    'default' => 'Choose a compensation level', 'list' => $levels, 'option' => 'name'])

                @include('snippet.formgroup', ['type' => 'select', 'label' => 'PC Type', 'attribs' => ['name' => 'pctype'],
                    'list' => [['id' => '0', 'name' => 'None'], ['id' => '1', 'name' => 'APC'],
                    ['id' => '2', 'name' => 'XC'], ['id' => '3', 'name' => 'Program Staff'],
                    ['id' => '4', 'name' => 'Consultants']], 'option' => 'name'])

                @include('snippet.formgroup', ['type' => 'submit', 'label' => '', 'attribs' => ['name' => 'Save Changes']])
            </div>
        </form>
    </div>
@endsection

