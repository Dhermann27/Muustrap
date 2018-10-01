@extends('layouts.app')

@section('title')
    Camp Cost Calculator
@endsection

@section('heading')
    Use this tool to easily estimate the cost of your fees this year.
@endsection

@section('content')
    <div class="alert alert-warning">
        Warning: this calculator only provides an estimate of your camp cost and your actual fees
        may vary.
    </div>
    <div class="container">
        <div class="form-group row">
            <label for="adults" class="col-md-3 control-label">Adults Attending</label>

            <div class="col-md-3 number-spinner">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <button class="btn btn-default" data-dir="up"><i class="far fa-plus"></i></button>
                    </div>
                    <input id="adults" class="form-control" name="adults" value="0"/>

                    <div class="input-group-append">
                        <button class="btn btn-default" data-dir="dwn"><i class="far fa-minus"></i></button>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <label for="adults-housing" class="control-label sr-only">Housing Arrangements</label>
                <select id="adults-housing" class="form-control">
                    <option value="0" selected>Choose Housing Arrangements</option>
                    <option value="1">Guestroom, Cabin, or Loft</option>
                    <option value="3">Camp Lakewood Cabin (dorm style)</option>
                    <option value="4">Tent Camping</option>
                </select>
                <div id="adult-choose" style="display: none;">Please choose a housing type to see the cost.
                </div>
            </div>
            <div class="col-md-2 text-right" id="adults-fee">$0.00</div>
        </div>
        <div id="single-alert" class="row alert alert-warning" style="display: none;">
            Due to limited space, single occupancy rooms are offered only a premium price. It is
            strongly suggested that single campers seek out at least one roommate to reduce costs and
            allow as many campers as possible to attend. Two adults rooming together will each pay
            double occupancy with a $150.00 deposit due at registration.
        </div>
        <div class="form-group row">
            <label for="yas" class="col-md-3 control-label">Young Adults (18-20) Attending</label>

            <div class="col-md-3 number-spinner">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <button class="btn btn-default" data-dir="up"><i class="far fa-plus"></i></button>
                    </div>
                    <input id="yas" class="form-control" name="yas" value="0"/>
                    <div class="input-group-append">
                        <button class="btn btn-default" data-dir="dwn"><i class="far fa-minus"></i></button>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <label for="yas-housing" class="control-label sr-only">Housing Arrangements</label>
                <select id="yas-housing" class="form-control">
                    <option value="0" selected>Choose Housing Arrangements</option>
                    <option value="1">YA Cabin</option>
                    <option value="2">Tent Camping</option>
                </select>
                <div id="ya-choose" style="display: none;">Please choose a housing type to see the cost.
                </div>
            </div>
            <div class="col-md-2 text-right" id="yas-fee">$0.00</div>
        </div>
        <div class="form-group row">
            <label for="jrsrs" class="col-md-3 control-label">Jr./Sr. High Schoolers Attending</label>

            <div class="col-md-3 number-spinner">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <button class="btn btn-default" data-dir="up"><i class="far fa-plus"></i></button>
                    </div>
                    <input id="jrsrs" class="form-control" name="yas" value="0"/>
                    <div class="input-group-append">
                        <button class="btn btn-default" data-dir="dwn"><i class="far fa-minus"></i></button>
                    </div>
                </div>
            </div>

            <div class="col-md-4">Burt/Meyer Community Cabins
            </div>
            <div class="col-md-2 text-right" id="jrsrs-fee">$0.00</div>
        </div>
        <div class="form-group row">
            <label for="children" class="col-md-3 control-label">Children (6 years old or older) Attending</label>

            <div class="col-md-3 number-spinner">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <button class="btn btn-default" data-dir="up"><i class="far fa-plus"></i></button>
                    </div>
                    <input id="children" class="form-control" name="yas" value="0"/>
                    <div class="input-group-append">
                        <button class="btn btn-default" data-dir="dwn"><i class="far fa-minus"></i></button>
                    </div>
                </div>
            </div>

            <div class="col-md-4">Must room with parents</div>
            <div class="col-md-2 text-right" id="children-fee">$0.00</div>
        </div>
        <div class="form-group row">
            <label for="babies" class="col-md-3 control-label">Children (Up to 5 years old) Attending</label>

            <div class="col-md-3 number-spinner">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <button class="btn btn-default" data-dir="up"><i class="far fa-plus"></i></button>
                    </div>
                    <input id="babies" class="form-control" name="yas" value="0"/>
                    <div class="input-group-append">
                        <button class="btn btn-default" data-dir="dwn"><i class="far fa-minus"></i></button>
                    </div>
                </div>
            </div>

            <div class="col-md-4">Must room with parents</div>
            <div class="col-md-2 text-right" id="babies-fee">$0.00</div>
        </div>
        <div class="row">
            <div class="col-md-12 text-md-right">
                <p>Amount Due Upon Registration: <span id="deposit">$0.00</span><br/>
                    Amount Due Upon Arrival: <span id="arrival">$0.00</span><br/>
                    <strong>Total Camp Cost</strong>: <span id="total">$0.00</span></p>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        // Adult (1-4), Burt, Cratty, Lumens, Meyer, YA, YA 18-20
        var guestsuite = [{{ $year->rates()->where('buildingid', '1000')->get()->implode('rate', ',') }}];
        var tentcamp = [{{ $year->rates()->where('buildingid', '1007')->get()->implode('rate', ',') }}];
        var lakewood = [{{ $year->rates()->where('buildingid', '1017')->get()->implode('rate', ',') }}];
    </script>
    <script src="/js/campcost.js" type="text/javascript"></script>
@endsection