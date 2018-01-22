@extends('layouts.app')

@section('title')
    Household Information
@endsection

@section('heading')
    This page will show all communal information relating to your entire family.
@endsection

@section('content')
    <div class="container">
        <form id="payment" class="form-horizontal" role="form" method="POST" action="{{ url('/household') .
                (isset($readonly) && $readonly === false ? '/f/' . $formobject->id : '') }}">

            @include('snippet.flash')

            @include('snippet.formgroup', ['label' => 'Family Name', 'title' => 'familyname',
                'attribs' => ['name' => 'name']])

            @include('snippet.formgroup', ['label' => 'Address Line #1', 'attribs' => ['name' => 'address1']])

            @include('snippet.formgroup', ['label' => 'Address Line #2', 'attribs' => ['name' => 'address2']])

            @include('snippet.formgroup', ['label' => 'City', 'attribs' => ['name' => 'city']])

            @include('snippet.formgroup', ['type' => 'select', 'label' => 'State',
                'attribs' => ['name' => 'statecd'], 'default' => 'Choose a state', 'list' => $statecodes,
                'option' => 'name'])

            @include('snippet.formgroup', ['label' => 'ZIP Code', 'attribs' => ['name' => 'zipcd',
                'maxlength' => '5', 'placeholder' => '5-digit ZIP Code']])

            @include('snippet.formgroup', ['label' => 'Country', 'attribs' => ['name' => 'country',
                'placeholder' => 'USA']])

            @if(isset($readonly))
                @include('snippet.question', ['name' => 'is_address_current',
                    'label' => 'Please indicate if the address we have is current.',
                    'list' => [['id' => '1', 'option' => 'Yes, mail to this address'],
                            ['id' => '0', 'option' => 'No, do not use this address until it is updated']]])
            @endif

            @include('snippet.question', ['name' => 'is_ecomm',
                'label' => 'Please indicate if you would like to receive a paper brochure in the mail.',
                'list' => [['id' => '0', 'option' => 'Yes, please mail me a brochure'],
                    ['id' => '1', 'option' => 'No, do not mail me anything']]])

            @include('snippet.question', ['name' => 'is_scholar',
                'label' => 'Please indicate if you will be applying for a scholarship this year.',
                'list' => [['id' => '0', 'option' => 'No'],
                        ['id' => '1', 'option' => 'Yes, I will be completing the separate process']]])

            @if(!isset($readonly) || $readonly === false)
                @include('snippet.formgroup', ['type' => 'submit', 'label' => '', 'attribs' => ['name' => 'Save Changes']])
            @endif
        </form>
    </div>
@endsection