@extends('layouts.app')

@section('content')
    <p>&nbsp;</p>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Camp Cost Calculator</div>
                    <div class="panel-body">
                        <div class="alert alert-info">
                            These numbers are approximations and can change based on several
                            other factors, such as additional excursion costs and volunteer
                            credits. You should <strong>not</strong> use this page to precisely
                            determine your camp costs.
                        </div>
                        <div class="form-group row">
                            <label for="adults" class="col-md-3 control-label">Adults Attending</label>

                            <div class="col-md-3 number-spinner">
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" data-dir="up"><i
                                                    class="fa fa-plus"></i></button>
                                    </span>
                                    <input id="adults" class="form-control" name="adults"
                                           value="0"/>
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" data-dir="dwn"><i
                                                    class="fa fa-minus"></i></button>
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label for="adults-housing" class="control-label hidden">Housing
                                    Arrangements</label>
                                <select id="adults-housing" class="form-control">
                                    <option value="0" selected>Choose Housing Arrangements</option>
                                    <option value="1">Guestroom, Cabin, or Loft</option>
                                    <option value="3">Camp Lakewood Cabin (dorm style)</option>
                                    <option value="4">Tent Camping</option>
                                </select></div>
                            <div class="col-md-2 text-right" id="adults-fee">$0.00</div>
                        </div>
                        <div id="single-alert" class="row alert alert-warning" style="display: none;">
                            Due to limited space, single occupancy rooms are offered only a premium price. It is
                            strongly suggested that single campers seek out at least one roommate to reduce costs and
                            allow as many campers as possible to attend. Two adults rooming together will each pay
                            $760.00 with a $150.00 deposit due at registration.
                        </div>
                        <div class="form-group row">
                            <label for="yas" class="col-md-3 control-label">Young Adults (18-20) Attending</label>

                            <div class="col-md-3 number-spinner">
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" data-dir="up"><i
                                                    class="fa fa-plus"></i></button>
                                    </span>
                                    <input id="yas" class="form-control" name="yas"
                                           value="0"/>
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" data-dir="dwn"><i
                                                    class="fa fa-minus"></i></button>
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label for="yas-housing" class="control-label hidden">Housing
                                    Arrangements</label>
                                <select id="yas-housing" class="form-control">
                                    <option value="0" selected>Choose Housing Arrangements</option>
                                    <option value="1">YA Cabin</option>
                                    <option value="2">Tent Camping</option>
                                </select></div>
                            <div class="col-md-2 text-right" id="yas-fee">$0.00</div>
                        </div>
                        <div class="form-group row">
                            <label for="jrsrs" class="col-md-3 control-label">Jr./Sr. High Schoolers Attending</label>

                            <div class="col-md-3 number-spinner">
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" data-dir="up"><i
                                                    class="fa fa-plus"></i></button>
                                    </span>
                                    <input id="jrsrs" class="form-control" name="yas"
                                           value="0"/>
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" data-dir="dwn"><i
                                                    class="fa fa-minus"></i></button>
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-4">Burt/Meyer Community Cabins
                            </div>
                            <div class="col-md-2 text-right" id="jrsrs-fee">$0.00</div>
                        </div>
                        <div class="form-group row">
                            <label for="children" class="col-md-3 control-label">Children (6 years old or older)
                                Attending</label>

                            <div class="col-md-3 number-spinner">
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" data-dir="up"><i
                                                    class="fa fa-plus"></i></button>
                                    </span>
                                    <input id="children" class="form-control" name="yas"
                                           value="0"/>
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" data-dir="dwn"><i
                                                    class="fa fa-minus"></i></button>
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-4">Must room with parents
                            </div>
                            <div class="col-md-2 text-right" id="children-fee">$0.00</div>
                        </div>
                        <div class="form-group row">
                            <label for="babies" class="col-md-3 control-label">Children (Up to 5 years old)
                                Attending</label>

                            <div class="col-md-3 number-spinner">
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" data-dir="up"><i
                                                    class="fa fa-plus"></i></button>
                                    </span>
                                    <input id="babies" class="form-control" name="yas"
                                           value="0"/>
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" data-dir="dwn"><i
                                                    class="fa fa-minus"></i></button>
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-4">Must room with parents
                            </div>
                            <div class="col-md-2 text-right" id="babies-fee">$0.00</div>
                        </div>
                        <div class="row">
                            <div class="col-md-5 col-md-offset-6 text-right">Amount Due Upon Registration: <span
                                        id="deposit">$0.00</span></div>
                        </div>
                        <div class="row">
                            <div class="col-md-5 col-md-offset-6 text-right">Amount Due Upon Arrival: <span
                                        id="arrival">$0.00</span></div>
                        </div>
                        <div class="row">
                            <div class="col-md-5 col-md-offset-6 text-right"><strong>Total Camp Cost</strong>: <span
                                        id="total">$0.00</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/js/campcost.js" type="text/javascript"></script>
@endsection