@extends('layouts.appstrap')

@section('title')
    Master Control Program
@endsection

@section('css')
    <link rel="stylesheet"
          href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css"/>
@endsection

@section('content')
    <div class="container">
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/master') }}">
            @include('snippet.flash')

            <table class="table">
                <thead>
                <tr>
                    <th>Year</th>
                    <th>Start Date</th>
                    <th>Brochure Date</th>
                    <th>Options</th>
                </tr>
                </thead>
                <tbody>
                @foreach($years as $year)
                    @if($year->is_current == 0)
                        <tr>
                            <td>{{ $year->year}}</td>
                            <td>{{ $year->start_date }}</td>
                            <td>{{ $year->start_open }}</td>
                            <td>
                                <div class="mb-1 btn-group" data-toggle="buttons">
                                    <label class="btn btn-primary">
                                        <input type="checkbox" name="{{ $year->id }}-is_current" autocomplete="off"/> Make
                                        Current Year
                                    </label>
                                </div>
                            </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>

            <div class="well">
                <h4>{{ $year->year }} Options</h4>

                <div class="alert alert-warning p-0 m-0">
                    @if($year->hasBrochure())
                        A Web Brochure exists on the server for this year.
                    @else
                        The Web Brochure is missing for this year.
                    @endif
                </div>

                <div class="form-group row{{ $errors->has($year->id . '-start_date') ? ' has-danger' : '' }}">
                    <label for="date" class="col-md-4 control-label">Start Date (yyyy-mm-dd)
                        <a href="#" class="p-2 float-right" data-toggle="tooltip" data-html="true"
                           title="First day of camp"><i class="far fa-info"></i></a>
                    </label>
                    <div class="col-md-6">
                        <div class="input-group date" data-provide="datepicker"
                             data-date-format="yyyy-mm-dd" data-date-autoclose="true">
                            <input id="date" type="text"
                                   class="form-control{{ $errors->has($year->id . '-start_date') ? ' is-invalid' : '' }}"
                                   name="{{ $year->id }}-start_date" value="{{ old($year->id . '-start_date', $year->start_date) }}"
                                   required>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="far fa-calendar"></i></span>
                            </div>
                            <div class="input-group-addon">
                            </div>
                        </div>
                        @if ($errors->has($year->id . '-start_date'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first($year->id . '-start_date') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row{{ $errors->has($year->id . '-start_open') ? ' has-danger' : '' }}">
                    <label for="date" class="col-md-4 control-label">Open Date (yyyy-mm-dd)
                        <a href="#" class="p-2 float-right" data-toggle="tooltip" data-html="true"
                           title="Expected date of brochure mailing"><i class="far fa-info"></i></a>
                    </label>
                    <div class="col-md-6">
                        <div class="input-group date" data-provide="datepicker"
                             data-date-format="yyyy-mm-dd" data-date-autoclose="true">
                            <input id="date" type="text"
                                   class="form-control{{ $errors->has($year->id . '-start_open') ? ' is-invalid' : '' }}"
                                   name="{{ $year->id }}-start_open" value="{{ old($year->id . '-start_open', $year->start_open) }}"
                                   required>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="far fa-calendar"></i></span>
                            </div>
                            <div class="input-group-addon">
                            </div>
                        </div>
                        @if ($errors->has($year->id . '-start_open'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first($year->id . '-start_open') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                @include('snippet.formgroup', ['type' => 'select', 'label' => 'Show ' . $year->year . ' Information',
                    'attribs' => ['name' => $year->id . '-is_live'], 'formobject' => $year,
                    'list' => [['id' => '0', 'name' => 'No'], ['id' => '1', 'name' => 'Yes']], 'option' => 'name'])

                @include('snippet.formgroup', ['type' => 'select', 'label' => 'Home Page',
                    'attribs' => ['name' => $year->id . '-is_crunch'], 'formobject' => $year,
                    'list' => [['id' => '0', 'name' => 'Normal'], ['id' => '1', 'name' => 'Crunch Mode']], 'option' => 'name'])

                @include('snippet.formgroup', ['type' => 'select', 'label' => 'Accept PayPal Payments',
                    'attribs' => ['name' => $year->id . '-is_accept_paypal'], 'formobject' => $year,
                    'list' => [['id' => '0', 'name' => 'No'], ['id' => '1', 'name' => 'Yes']], 'option' => 'name'])

                @include('snippet.formgroup', ['type' => 'select', 'label' => 'Show Personalized Calendars',
                    'attribs' => ['name' => $year->id . '-is_calendar'], 'formobject' => $year,
                    'list' => [['id' => '0', 'name' => 'No'], ['id' => '1', 'name' => 'Yes']], 'option' => 'name'])

                @include('snippet.formgroup', ['type' => 'select', 'label' => 'Allow Room Selection',
                    'attribs' => ['name' => $year->id . '-is_room_select'], 'formobject' => $year,
                    'list' => [['id' => '0', 'name' => 'No'], ['id' => '1', 'name' => 'Yes']], 'option' => 'name'])

                @include('snippet.formgroup', ['type' => 'select', 'label' => 'Accept Workshop Proposals',
                    'attribs' => ['name' => $year->id . '-is_workshop_proposal'], 'formobject' => $year,
                    'list' => [['id' => '0', 'name' => 'No'], ['id' => '1', 'name' => 'Yes']], 'option' => 'name'])

                @include('snippet.formgroup', ['type' => 'select', 'label' => 'Accept Art Fair Submissions',
                    'attribs' => ['name' => $year->id . '-is_artfair'], 'formobject' => $year,
                    'list' => [['id' => '0', 'name' => 'No'], ['id' => '1', 'name' => 'Yes']], 'option' => 'name'])

                @include('snippet.formgroup', ['type' => 'select', 'label' => 'Show Coffeehouse Now Playing',
                    'attribs' => ['name' => $year->id . '-is_coffeehouse'], 'formobject' => $year,
                    'list' => [['id' => '0', 'name' => 'No'], ['id' => '1', 'name' => 'Yes']], 'option' => 'name'])

                @include('snippet.formgroup', ['type' => 'submit', 'label' => '', 'attribs' => ['name' => 'Save Changes']])
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script src="/js/bootstrap-datepicker.min.js"></script>
@endsection
