@extends('layouts.appstrap')

@section('title')
    User Role Assignment
@endsection

@section('content')
    <div class="container">
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/roles') }}">
            @include('snippet.flash')

            @component('snippet.navtabs', ['tabs' => $roles, 'id'=> 'id', 'option' => 'display_name'])
                @foreach($roles as $role)
                    <div class="tab-content" id="{{ $role->id }}">
                        <p>&nbsp;</p>
                        <h4>{{ $role->description }}</h4>
                        <table class="table">
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
                                    <td>
                                        @include('snippet.delete', ['id' => $user->id . '-' . $role->id])
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
            @endcomponent
            @include('snippet.formgroup', ['type' => 'submit', 'label' => '', 'attribs' => ['name' => 'Save Changes']])
        </form>
    </div>
@endsection
