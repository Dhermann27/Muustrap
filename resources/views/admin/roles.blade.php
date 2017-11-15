@extends('layouts.app')

@section('title')
    User Role Assignment
@endsection

@section('content')
    <div class="container">
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/roles') }}">
            @include('snippet.flash')

            @include('snippet.navtabs', ['tabs' => $roles, 'id'=> 'id', 'option' => 'display_name'])

            <div class="tab-content">
                @foreach($roles as $role)
                    <div role="tabpanel" class="tab-pane fade{{ $loop->first ? ' active show' : '' }}"
                         id="{{ $role->id }}">
                        <p>&nbsp;</p>
                        <h4>{{ $role->description }}</h4>
                        <table class="table table-sm .w-auto">
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

                        @include('snippet.formgroup', ['class' => ' camperlist', 'hidden' => 'id',
                            'label' => 'Add New ' . $role->display_name,
                            'attribs' => ['name' => $role->id . '-camper', 'placeholder' => 'Camper Name']])

                    </div>
                @endforeach
            </div>
            @include('snippet.formgroup', ['type' => 'submit', 'label' => '', 'attribs' => ['name' => 'Save Changes']])
        </form>
    </div>
@endsection
