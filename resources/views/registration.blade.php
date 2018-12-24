@extends('layouts.appstrap')

@section('title')
    Home
@endsection

@section('heading')
    You are logged in!
@endsection

@section('multisection')
    <section id="circle-tabs">
        <div class="container inner">
            <div class="row">
                <div class="col-12">
                    <div class="tabs tabs-services tabs-circle-top tab-container">

                        <ul class="etabs text-center">
                            <li class="tab"><a href="{{ url('/household') }}">
                                    <div><i class="far fa-home"></i></div>
                                    Household</a>
                            </li>
                            <li class="tab"><a href="{{ url('/camper') }}">
                                    <div><i class="far fa-users"></i></div>
                                    Campers</a>
                            </li>
                            <li class="tab active">
                                <a href="{{ url('/payment') }}">
                                    <div><i class="far fa-usd-square"></i></div>
                                    Payment</a>
                            </li>
                            <li class="tab">
                                <a href="{{ url('/workshopchoice') }}">
                                    <div><i class="far fa-rocket"></i></div>
                                    Workshops</a>
                            </li>
                            <li class="tab">
                                <a href="{{ url('/roomselection') }}">
                                    <div><i class="far fa-bed"></i></div>
                                    Room
                                    Selection</a>
                            </li>
                            <li class="tab"><a href="{{ url('/nametag') }}">
                                    <div><i class="far fa-id-card"></i></div>
                                    Nametags</a>
                            </li>
                            <li class="tab">
                                <a href="{{ url('/confirm') }}">
                                    <div><i class="far fa-envelope"></i></div>
                                    Confirm Letter</a>
                            </li>
                        </ul>

                        <div class="panel-container">
                            <div class="row">
                                <div class="col-md-8 mx-auto text-center">
                                    <h3>Marketing</h3>
                                    <p>Magnis modipsae que lib voloratati andigen daepedor quiate ut reporemni aut
                                        labor. Laceaque sitiorem ut restibusaes es tumquam core posae volor remped
                                        modis volor. Doloreiur qui commolu ptatemp dolupta orem retibusam emnis et
                                        consent accullignis lomnus.</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-5 col-md-6 col-8 inner-top-xs mx-auto text-center">
                                    <figure><img src="assets/images/art/humans01.jpg" alt=""></figure>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
