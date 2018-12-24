@extends('layouts.appstrap')

@section('title')
    Muse Upload
@endsection

@section('css')
    <link rel="stylesheet"
          href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css"/>
@endsection

@section('content')
    @if(Auth::check())
        <div class="container">
            <form id="muse" class="form-horizontal" role="form" method="POST"
                  action="{{ url('/museupload') }}" enctype="multipart/form-data">
                @include('snippet.flash')

                <div class="form-group row{{ $errors->has('date') ? ' has-danger' : '' }}">
                    <label for="date" class="col-md-4 control-label">Muse Date (yyyy-mm-dd)</label>
                    <div class="col-md-6">
                        <div class="input-group date" data-provide="datepicker"
                             data-date-format="yyyy-mm-dd" data-date-autoclose="true">
                            <input id="date" type="text" class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }}"
                                   name="date" value="{{ old('date') }}" required>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="far fa-calendar"></i></span>
                            </div>
                            <div class="input-group-addon">
                            </div>
                        </div>
                        @if ($errors->has('date'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('date') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('images') ? ' has-danger' : '' }}">
                    <label for="images" class="col-md-4 control-label">Muse PDF</label>

                    <div class="col-md-6">
                        <input type="file" name="pdf"/>

                        @if ($errors->has('pdf'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('pdf') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                @include('snippet.formgroup', ['type' => 'captcha', 'label' => 'CAPTCHA Test',
                    'attribs' => ['name' => 'g-recaptcha-response']])

                @include('snippet.formgroup', ['type' => 'submit', 'label' => '', 'attribs' => ['name' => 'Upload Muse']])
            </form>
        </div>
    @endif
@endsection

@section('script')
    {!! NoCaptcha::renderJs() !!}
    <script src="/js/bootstrap-datepicker.min.js"></script>
@endsection