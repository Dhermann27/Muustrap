@extends('layouts.app')

@section('css')
    <link href="/css/summernote.css" rel="stylesheet">
@endsection

@section('content')
    <p>&nbsp;</p>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">Programs</div>
            <div class="panel-body">
                <form id="programs" class="form-horizontal" role="form" method="POST"
                      action="{{ url('/tools/programs') }}">
                    {{ csrf_field() }}
                    @if(!empty($success))
                        <div class=" alert alert-success">
                            {!! $success !!}
                        </div>
                    @endif
                    <ul class="nav nav-tabs" role="tablist">
                        @foreach($programs as $program)
                            <li role="presentation"{!! $loop->first ? ' class="active"' : '' !!}>
                                <a href="#{{ $program->id }}" aria-controls="{{ $program->id }}" role="tab"
                                   data-toggle="tab">{{ $program->name }}</a></li>
                        @endforeach
                        <li role="presentation">
                            <a href="#100" aria-controls="100" role="tab" data-toggle="tab">Google Form Instructions</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        @foreach($programs as $program)
                            <div role="tabpanel" class="tab-pane fade{{ $loop->first ? ' in active' : '' }}"
                                 id="{{ $program->id }}">
                                <p>&nbsp;</p>

                                <div class="form-group{{ $errors->has($program->id . '-blurb') ? ' has-error' : '' }}">
                                    <label for="{{ $program->id }}-blurb" class="col-md-4 control-label">Blurb for
                                        Programs Page</label>

                                    <div class="col-md-6">
                                        <div class="summernote">{!! $program->blurb !!}</div>
                                        <input type="hidden" id="{{ $program->id }}-blurb"
                                               name="{{ $program->id }}-blurb"/>

                                        @if ($errors->has($program->id . '-blurb'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first($program->id . '-blurb') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has($program->id . '-link') ? ' has-error' : '' }}">
                                    <label for="{{ $program->id }}-link" class="col-md-4 control-label">
                                        @if($program->id == '1008')
                                            Medical Form Link (for all children <18)
                                        @else
                                            Program Form Link (leave blank for no form)
                                        @endif
                                    </label>

                                    <div class="col-md-6">
                                        <input type="text" id="{{ $program->id }}-link"
                                               class="form-control" name="{{ $program->id }}-link"
                                               placeholder="https://docs.google.com/forms/.../edit"
                                               value="{{ old($program->id . '-link', $program->link) }}">

                                        @if ($errors->has($program->id . '-link'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first($program->id . '-link') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has($program->id . '-calendar') ? ' has-error' : '' }}">
                                    <label for="{{ $program->id }}-calendar" class="col-md-4 control-label">
                                        Program Event Calendar
                                    </label>

                                    <div class="col-md-6">
                                        <input type="text" id="{{ $program->id }}-calendar"
                                               class="form-control" name="{{ $program->id }}-calendar"
                                               placeholder="abcd1234@group.calendar.google.com"
                                               value="{{ old($program->id . '-calendar', $program->calendar) }}">

                                        @if ($errors->has($program->id . '-calendar'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first($program->id . '-calendar') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                @if($program->id != '1008')
                                    <div class="form-group{{ $errors->has($program->id . '-letter') ? ' has-error' : '' }}">
                                        <label for="{{ $program->id }}-letter" class="col-md-4 control-label">Text of
                                            Letter to Include for Each Camper</label>

                                        <div class="col-md-6">
                                            <div class="summernote">{!! $program->letter !!}</div>
                                            <input type="hidden" id="{{ $program->id }}-letter"
                                                   name="{{ $program->id }}-letter"/>

                                            @if ($errors->has($program->id . '-letter'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first($program->id . '-letter') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                        <div role="tabpanel" class="tab-pane fade" id="100">
                            <h3>Instructions for Creating a Google Form</h3>
                            <ul>
                                <li>Go to the <a href="https://www.google.com/forms/about/" target="_parent">Google
                                        Forms</a> site and log into any Google account.
                                </li>
                                <li>When you see the base page, click the red plus in the lower-right to create a new
                                    form.
                                </li>
                                <li>Fill out the questions you need answered as best you can. Please keep it as simple
                                    as possible.
                                </li>
                                <li>When finished, progress is automatically saved. Copy and paste the URL of the form
                                    (it should end in "/edit") into this page. Your form will automatically be imported
                                    to each relevant camper's confirmation letter in your program.
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-2 col-md-offset-8">
                            <button type="submit" class="btn btn-primary">Save Changes (slow)</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="/js/summernote.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.summernote').summernote({
                height: 150,
                minHeight: null,
                maxHeight: null,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']]
                ]
            });

            $("#programs").on("submit", function (e) {
                $('.summernote').each(function () {
                    $(this).next().next().val($(this).summernote('code'));
                });
                return true;
            });
        });
    </script>
@endsection
