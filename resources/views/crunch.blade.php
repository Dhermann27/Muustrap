@inject('home', 'App\Http\Controllers\HomeController')
@extends('layouts.app')

@section('content')
    <div class="jumbotron">
        <div class="container py-4 py-lg-6">
            <h2 class="text-center text-uppercase font-weight-bold my-0" data-animate="fadeIn" data-animate-delay="0.3">
                Time for MUUSA!
            </h2>
            <div class="row">
                <div class="col-md-4" data-animate="fadeIn" data-animate-delay="1.2">
                    <i class="far fa-envelope fa-3x"></i>
                    <p>Confirmation</p>
                    <p>
                        <a href="{{ url('/confirm') }}" class="btn btn-primary btn-rounded">Read Letter</a>
                    </p>
                </div>
                <div class="col-md-4" data-animate="fadeIn" data-animate-delay="1.2">
                    <i class="far fa-clock fa-3x"></i>
                    <p>Check-In</p>
                    <p>Sunday July 1st, 2:00 PM</p>
                </div>
                <div class="col-md-4" data-animate="fadeIn" data-animate-delay="1.4">
                    <i class="far fa-map-marker-alt fa-4x"></i>
                    <p><strong>Directions</strong></p>
                    <p>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3146.3009632033245!2d-90.93029498484199!3d37.946758110019154!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x87d99fbc697e2a85%3A0xd139b64a63794a2f!2sYMCA+Trout+Lodge!5e0!3m2!1sen!2sus!4v1497890802008"
                                width="400" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection