@extends('layouts.app')

@section('content')
    <p>&nbsp;</p>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">Staff Assignments</div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/tools/staffpositions') }}">
                    {{ csrf_field() }}
                    @if(!empty($success))
                        <div class=" alert alert-success">
                            {!! $success !!}
                        </div>
                    @endif
                    <ul class="nav nav-tabs" role="tablist">
                        @foreach($programs as $program)
                            <li role="presentation"{!! $loop->first ? ' class="active"' : '' !!}>
                                <a href="#{{ $program->id }}" aria-controls="{{ $program->id }}" role="tab"
                                   data-toggle="tab">{{ $program->name }}</a></li>
                        @endforeach
                    </ul>

                    <div class="tab-content">
                        @foreach($programs as $program)
                            <div role="tabpanel" class="tab-pane fade{{ $loop->first ? ' in active' : '' }}"
                                 id="{{ $program->id }}">
                                <p>&nbsp;</p>
                                <table class="table table-responsive table-condensed">
                                    <thead>
                                    <tr>
                                        <th>Position</th>
                                        <th>Name</th>
                                        <th>Current Compensation</th>
                                        <th>Controls</th>
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
                                                @include('admin.controls', ['id' => 'c/' . $assignment->id])
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="3" align="right"><strong>Total Compensation:</strong>
                                            ${{ money_format('%.2n', $program->assignments->sum('compensation')) }}</td>
                                    </tr>
                                    </tfoot>
                                </table>

                                <div class="form-group{{ $errors->has($program->id . '-camperid') ? ' has-error' : '' }}">
                                    <label for="{{ $program->id }}-camper" class="col-md-4 control-label">Add
                                        New Assignment</label>

                                    <div class="col-md-6">
                                        <input type="text" id="{{ $program->id }}-camper"
                                               class="form-control camperlist"
                                               placeholder="Camper Name">
                                        <input id="{{ $program->id }}-camperid" name="{{ $program->id }}-camperid"
                                               type="hidden">

                                        @if ($errors->has($program->id . '-camperid'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first($program->id . '-camperid') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has($program->id . '-staffpositionid') ? ' has-error' : '' }}">
                                    <label for="{{ $program->id }}-staffpositionid" class="col-md-4 control-label">Position</label>

                                    <div class="col-md-6">
                                        <select id="{{ $program->id }}-staffpositionid"
                                                name="{{ $program->id }}-staffpositionid" class="form-control">
                                            <option value="0">Choose a position</option>
                                            @foreach($program->staffpositions()->orderBy('name')->get() as $staffposition)
                                                <option value="{{ $staffposition->id }}">{{ $staffposition->name }}
                                                    ({{ $staffposition->compensationlevel->name }})
                                                </option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has($program->id . '-staffpositionid'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first($program->id . '-staffpositionid') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="form-group">
                        <div class="col-md-2 col-md-offset-8">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
