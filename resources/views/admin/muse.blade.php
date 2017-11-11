@extends('layouts.app')

@section('title')
    Muse Upload
@endsection

@section('content')
    @if(Auth::check())
        <form id="muse" class="form-horizontal" role="form" method="POST"
              action="{{ url('/museupload') }}" enctype="multipart/form-data">
            @include('snippet.flash')

            <div class="form-group{{ $errors->has('date') ? ' has-error' : '' }}">
                <label for="date" class="col-md-4 control-label">Muse Date (yyyy-mm-dd)</label>
                <div class="col-md-6">
                    <div class="input-group date" data-provide="datepicker"
                         data-date-format="yyyy-mm-dd" data-date-autoclose="true">
                        <input id="date" type="text" class="form-control" name="date"
                               value="{{ old('date') }}" required>
                        <div class="input-group-addon">
                            <span class="fa fa-calendar"></span>
                        </div>
                    </div>
                    @if ($errors->has('date'))
                        <span class="help-block">
                                                <strong>{{ $errors->first('date') }}</strong>
                                            </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('images') ? ' has-error' : '' }}">
                <label for="images" class="col-md-4 control-label">Muse PDF</label>

                <div class="col-md-6">
                    <input type="file" name="pdf"/>

                    @if ($errors->has('pdf'))
                        <span class="help-block">
                                                <strong>{{ $errors->first('pdf') }}</strong>
                                            </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                <div class="col-md-6 col-md-offset-4">
                    {!! app('captcha')->display() !!}

                    @if ($errors->has('g-recaptcha-response'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <button type="submit" class="btn btn-primary">Upload Muse</button>
                </div>
            </div>
        </form>
    @endif
@endsection

@section('script')
    <script src="/js/bootstrap-datepicker.min.js"></script>
@endsection