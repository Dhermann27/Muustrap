@extends('layouts.app')

@section('title')
    User Role Assignment
@endsection

@section('content')
    <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/roles') }}">
        @include('snippet.flash')

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
                            <th>Controls</th>
                            <th>Delete?</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($role->users()->orderBy('email')->get() as $user)
                            <tr>
                                <td>{{ $user->camper->lastname }}, {{ $user->camper->firstname }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @include('admin.controls', ['id' => 'c/' . $user->camper->id])
                                </td>
                                <td class="btn-group" data-toggle="buttons">
                                    <label class="btn btn-default">
                                        <input type="checkbox" name="{{ $user->id }}-{{ $role->id }}-delete"
                                               autocomplete="off"/> Delete
                                    </label>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="well">
                        <h4>Add New {{ $role->display_name }} User</h4>
                        @include('snippet.formgroup', ['class' => ' camperlist', 'hidden' => 'id',
                            'label' => 'Role Assignee', 'attribs' => ['name' => $role->id . '-camper',
                            'placeholder' => 'Camper Name']])
                    </div>

                </div>
            @endforeach
        </div>
        <div class="form-group">
            <div class="col-md-2 col-md-offset-8">
                <button class="btn btn-primary">Save Changes</button>
            </div>
        </div>
    </form>
@endsection
