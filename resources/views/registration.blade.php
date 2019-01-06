@extends('layouts.appstrap')

@section('title')
    Registration
@endsection

@section('content')
    <ul class="nav nav-steps nav-steps-circles nav-steps-lg flex-column flex-lg-row justify-content-around">
        <li class="nav-item">
            <a href="#tab-household" class="nav-link active" data-toggle="tab">
                <i class="far fa-home fa-2x"></i>
                <span class="font-weight-bold d-block">Household</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#tab-campers" class="nav-link" data-toggle="tab">
                <i class="far fa-users fa-2x"></i>
                <span class="font-weight-bold d-block">Campers</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#tab-payment" class="nav-link" data-toggle="tab">
                <i class="far fa-usd-square fa-2x"></i>
                <span class="font-weight-bold d-block">Payment</span>
            </a>
        </li>
        @if($year->is_live)
            <li class="nav-item">
                <a href="#tab-workshops" class="nav-link" data-toggle="tab">
                    <i class="far fa-rocket fa-2x"></i>
                    <span class="font-weight-bold d-block">Workshops</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#tab-roomselection" class="nav-link" data-toggle="tab">
                    <i class="far fa-bed fa-2x"></i>
                    <span class="font-weight-bold d-block">Room Selection</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#tab-nametags" class="nav-link" data-toggle="tab">
                    <i class="far fa-id-card fa-2x"></i>
                    <span class="font-weight-bold d-block">Nametags</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#tab-confirmation" class="nav-link" data-toggle="tab">
                    <i class="far fa-envelope fa-2x"></i>
                    <span class="font-weight-bold d-block">Confirmation</span>
                </a>
            </li>
        @else
            <li class="nav-item border">
                <a href="#tab-workshops" class="nav-link">
                    <i class="far fa-rocket fa-2x"></i>
                    <span class="d-block">Workshops</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#tab-roomselection" class="nav-link">
                    <i class="far fa-bed fa-2x"></i>
                    <span class="d-block">Room Selection</span></a>
            </li>
            <li class="nav-item">
                <a href="#tab-nametags" class="nav-link">
                    <i class="far fa-id-card fa-2x"></i>
                    <span class="d-block">Nametags</span></a>
            </li>
            <li class="nav-item nav-">
                <a href="#tab-confirmation" class="nav-link">
                    <i class="far fa-envelope fa-2x"></i>
                    <span class="d-block">Confirmation</span></a>
            </li>
        @endif
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
