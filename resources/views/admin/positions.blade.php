@extends('layouts.app')

@section('title')
    Positions
@endsection

@section('content')
    <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/positions') }}">
        @include('snippet.flash')

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
                            <th id="name">Name</th>
                            <th id="compensationlevelid" class="select">Compensation Level</th>
                            <th>Maximum Compensation</th>
                            <th>Delete?</th>
                        </tr>
                        </thead>
                        <tbody class="editable">
                        @foreach($program->staffpositions()->orderBy('name')->get()->load('compensationlevel') as $position)
                            <tr id="{{ $position->id }}">
                                <td>{{ $position->name }}</td>
                                <td>{{ $position->compensationlevel->name }}</td>
                                <td>
                                    ${{ money_format('%.2n', $position->compensationlevel->max_compensation) }}
                                </td>
                                <td class="btn-group" data-toggle="buttons">
                                    <label class="btn btn-default">
                                        <input type="checkbox" name="{{ $position->id }}-delete" autocomplete="off"/>
                                        Delete
                                    </label>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="form-group{{ $errors->has($program->id . '-position') ? ' has-error' : '' }}">
                        <label for="{{ $program->id }}-position" class="col-md-4 control-label">Add
                            New Position</label>

                        <div class="col-md-6">
                            <input type="text" id="{{ $program->id }}-position" class="form-control"
                                   name="{{ $program->id }}-position" placeholder="Position Name">

                            @if ($errors->has($program->id . '-position'))
                                <span class="help-block">
                                                <strong>{{ $errors->first($program->id . '-position') }}</strong>
                                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has($program->id . '-compensationlevel') ? ' has-error' : '' }}">
                        <label for="{{ $program->id }}-compensationlevel" class="col-md-4 control-label">Compensation
                            Level</label>

                        <div class="col-md-6">
                            <select id="{{ $program->id }}-compensationlevel"
                                    name="{{ $program->id }}-compensationlevel"
                                    class="form-control compensationlevelid">
                                <option value="0">Choose a compensation level</option>
                                @foreach($levels as $level)
                                    <option value="{{ $level->id }}">{{ $level->name }}</option>
                                @endforeach
                            </select>

                            @if ($errors->has($program->id . '-compensationlevel'))
                                <span class="help-block">
                                                <strong>{{ $errors->first($program->id . '-position') }}</strong>
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
@endsection

