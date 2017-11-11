@extends('layouts.app')

@section('title')
    Distribution Lists
@endsection


@section('content')
    <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/distlist') }}">
        @include('snippet.flash')

        @if(!empty($rows))
            <h4>Count: {{ count($rows) }}</h4>
            <table class="table table-responsive">
                <thead>
                <tr>
                    @foreach($columns as $column)
                        <th>{{ $column }}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @foreach($rows as $row)
                    <tr>
                        @foreach($columns as $column)
                            <td>{{ $row->{$column} }}</td>
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif

        <div class="form-group{{ $errors->has('campers') ? ' has-error' : '' }}">
            <label for="campers" class="col-md-4 control-label">Base Camper List</label>

            <div class="col-md-6">
                <select id="campers" name="campers" class="form-control">
                    <option value="all"{{ old('campers', $request->input('campers')) == 'all' ? ' selected' : '' }}>
                        All campers
                    </option>
                    <option value="reg"{{ old('campers', $request->input('campers')) == 'reg' ? ' selected' : '' }}>
                        All registered campers
                    </option>
                    <option value="unp"{{ old('campers', $request->input('campers')) == 'unp' ? ' selected' : '' }}>
                        All registered campers with unpaid deposits
                    </option>
                    <option value="oneyear"{{ old('campers', $request->input('campers')) == 'oneyear' ? ' selected' : '' }}>
                        All campers from last year
                    </option>
                    <option value="lost"{{ old('campers', $request->input('campers')) == 'lost' ? ' selected' : '' }}>
                        All campers from last year who have not registered for this year
                    </option>
                    <option value="threeyears"{{ old('campers', $request->input('campers')) == 'threeyears' ? ' selected' : '' }}>
                        All campers from the last 3 years
                    </option>
                </select>

                @if ($errors->has('campers'))
                    <span class="help-block">
                                    <strong>{{ $errors->first('campers') }}</strong>
                                </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label for="email" class="col-md-4 control-label">Restrict to campers with email
                addresses?</label>

            <div class="col-md-6">
                <select id="email" name="email" class="form-control">
                    <option value="1">Show campers with email addresses only</option>
                    <option value="0"{{ old('email', $request->input('email')) == '0' ? ' selected' : '' }}>
                        Show all campers
                    </option>
                </select>

                @if ($errors->has('email'))
                    <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('ecomm') ? ' has-error' : '' }}">
            <label for="ecomm" class="col-md-4 control-label">Restrict to campers that want snail
                mail?</label>

            <div class="col-md-6">
                <select id="ecomm" name="ecomm" class="form-control">
                    <option value="0">Show campers that do not want snail mail</option>
                    <option value="1"{{ old('ecomm', $request->input('ecomm')) == '1' ? ' selected' : '' }}>
                        Show campers that want to receive paper snail mail
                    </option>
                </select>

                @if ($errors->has('ecomm'))
                    <span class="help-block">
                                    <strong>{{ $errors->first('ecomm') }}</strong>
                                </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('current') ? ' has-error' : '' }}">
            <label for="current" class="col-md-4 control-label">Restrict to Campers with current snailmail
                addresses?</label>

            <div class="col-md-6">
                <select id="current" name="current" class="form-control">
                    <option value="1">Yes</option>
                    <option value="0"{{ old('current', $request->input('current')) == '0' ? ' selected' : '' }}>
                        No, show all
                    </option>
                </select>

                @if ($errors->has('current'))
                    <span class="help-block">
                                    <strong>{{ $errors->first('current') }}</strong>
                                </span>
                @endif
            </div>
        </div>

        <div class="form-group">
            <label for="programs" class="col-md-4 control-label">Programs (all off by default)</label>
            <div class="col-md-6 btn-group" data-toggle="buttons">
                @foreach($programs as $program)
                    <label class="btn btn-default {{ old('program-' . $program->id, $request->input('program-' . $program->id)) == 'on' ? 'active' : '' }}">
                        <input type="checkbox" name="program-{{ $program->id }}" data-toggle="switch"
                                {{ old('program-' . $program->id, $request->input('program-' . $program->id)) == 'on' ? ' checked="checked"' : '' }}/>
                        {{ $program->name }}
                    </label>
                @endforeach
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-2 col-md-offset-8">
                <button type="submit" class="btn btn-primary">Download Data</button>
            </div>
        </div>
    </form>
@endsection