@extends('layouts.app')

@section('content')
    <p>&nbsp;</p>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">User Roles</div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/roles') }}">
                    {{ csrf_field() }}

                    @if(!empty($error))
                        <div class="alert alert-danger">
                            {!! $error !!}
                        </div>
                    @elseif(!empty($success))
                        <div class=" alert alert-success">
                            {!! $success !!}
                        </div>
                    @endif
                    <ul class="nav nav-tabs" role="tablist">
                        @foreach($roles as $role)
                            <li role="presentation"{!! $loop->first ? ' class="active"' : '' !!}>
                                <a href="#{{ $role->id }}" aria-controls="{{ $role->id }}" role="tab"
                                   data-toggle="tab">{{ $role->display_name }}</a></li>
                        @endforeach
                    </ul>

                    <div class="tab-content">
                        @foreach($roles as $role)
                            <div role="tabpanel" class="tab-pane fade{{ $loop->first ? ' in active' : '' }}"
                                 id="{{ $role->id }}">
                                <p>&nbsp;</p>
                                <h4>{{ $role->description }}</h4>
                                <table class="table table-responsive table-condensed">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Birthdate</th>
                                        <th>Controls</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($role->users()->get() as $user)
                                        <tr>
                                            <td>{{ $user->camper->firstname }} {{ $user->camper->lastname }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->camper->birthdate }}</td>
                                            <td>
                                                @include('admin.controls', ['id' => 'c/' . $user->camper->id])
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                                <div class="form-group{{ $errors->has($role->id . '-camper') ? ' has-error' : '' }}">
                                    <label for="{{ $role->id }}-camper" class="col-md-4 control-label">Add
                                        New {{ $role->display_name }}</label>

                                    <div class="col-md-6">
                                        <input type="text" id="{{ $role->id }}-camper" class="form-control camperlist"
                                               placeholder="Camper Name">
                                        <input id="{{ $role->id }}-camperid" name="{{ $role->id }}-camperid"
                                               type="hidden">

                                        @if ($errors->has($role->id . '-camperid'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first($role->id . '-camperid') }}</strong>
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
