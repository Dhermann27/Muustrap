@extends('layouts.appstrap')

@section('title')
    Registration
@endsection

@section('content')
    <ul id="bigsteps"
        class="nav nav-steps nav-steps-lg nav-steps-circles flex-column flex-lg-row justify-content-lg-around">
        <li class="nav-item">
            <a href="#tab-household" class="nav-link active" data-toggle="tab" data-hover="tab">
                <i class="far fa-home fa-3x mt-3"></i>
                <span class="font-weight-bold d-block">Household</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#tab-campers" class="nav-link" data-toggle="tab" data-hover="tab">
                <i class="far fa-users fa-3x mt-3"></i>
                <span class="font-weight-bold d-block">Campers</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#tab-payment" class="nav-link" data-toggle="tab" data-hover="tab">
                <i class="far fa-usd-square fa-3x mt-3"></i>
                <span class="font-weight-bold d-block">Payment</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#tab-workshops" class="nav-link" data-toggle="tab" data-hover="tab">
                <i class="far fa-rocket fa-3x mt-3"></i>
                <span class="font-weight-bold d-block">Workshops</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#tab-roomselection" class="nav-link" data-toggle="tab" data-hover="tab">
                <i class="far fa-bed fa-3x mt-3"></i>
                <span class="font-weight-bold d-block">Room Selection</span></a>
        </li>
        <li class="nav-item">
            <a href="#tab-nametags" class="nav-link" data-toggle="tab" data-hover="tab">
                <i class="far fa-id-card fa-3x mt-3"></i>
                <span class="font-weight-bold d-block">Nametags</span></a>
        </li>
        <li class="nav-item nav-">
            <a href="#tab-confirmation" class="nav-link" data-toggle="tab" data-hover="tab">
                <i class="far fa-envelope fa-3x mt-3"></i>
                <span class="font-weight-bold d-block">Confirmation</span></a>
        </li>
    </ul>
    <div class="tab-content py-3">
        <div class="tab-pane fade active show" id="tab-household" role="tabpanel">
            Household
        </div>
        <div class="tab-pane fade" id="tab-campers" role="tabpanel">
            Campers
        </div>
        <div class="tab-pane fade" id="tab-payment" role="tabpanel">
            Payment
        </div>
        <div class="tab-pane fade" id="tab-workshops" role="tabpanel">
            Workshops
        </div>
        <div class="tab-pane fade" id="tab-roomselection" role="tabpanel">
            Room Selection
        </div>
        <div class="tab-pane fade" id="tab-nametags" role="tabpanel">
            Nametags
        </div>
        <div class="tab-pane fade" id="tab-confirmation" role="tabpanel">
            Confirmation
        </div>
    </div>
@endsection
