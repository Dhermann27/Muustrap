@extends('layouts.app')

@section('css')
    <link href="/css/summernote.css" rel="stylesheet">
@endsection

@section('title')
    Programs
@endsection


@section('content')
    <form id="programs" class="form-horizontal" role="form" method="POST" action="{{ url('/tools/programs') }}">
        @include('snippet.flash')

        @include('snippet.navtabs', ['tabs' => $programs, 'id'=> 'id', 'option' => 'name'])

        <div class="tab-content">
            @foreach($programs as $program)
                <div role="tabpanel" class="tab-pane fade{{ $loop->first ? ' active show' : '' }}"
                     aria-expanded="{{ $loop->first ? 'true' : 'false' }}" id="{{ $program->id }}">

                    <div class="form-group row{{ $errors->has($program->id . '-blurb') ? ' has-danger' : '' }}">
                        <label for="{{ $program->id }}-blurb" class="col-md-4 control-label">Blurb for
                            Programs Page</label>

                        <div class="col-md-6">
                            <div class="summernote">{!! $program->blurb !!}</div>
                            <input type="hidden" id="{{ $program->id }}-blurb" name="{{ $program->id }}-blurb"/>

                            @if ($errors->has($program->id . '-blurb'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first($program->id . '-blurb') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    @include('snippet.formgroup', ['label' => $program->id == '1008' ? 'Medical Form Link (for all children <18)' :
                        'Program Form Link (leave blank for no form)', 'attribs' => ['name' => $program->id . '-link',
                        'placeholder' => 'https://docs.google.com/forms/.../edit', 'formobject' => $program]])

                    @include('snippet.formgroup', ['label' => 'Program Event Calendar',
                        'attribs' => ['name' => $program->id . '-calendar',
                        'placeholder' => 'abcd1234@group.calendar.google.com', 'formobject' => $program]])

                    @if($program->id != '1008')
                        <div class="form-group row{{ $errors->has($program->id . '-letter') ? ' has-danger' : '' }}">
                            <label for="{{ $program->id }}-letter" class="col-md-4 control-label">Text of
                                Letter to Include for Each Camper</label>

                            <div class="col-md-6">
                                <div class="summernote">{!! $program->letter !!}</div>
                                <input type="hidden" id="{{ $program->id }}-letter"
                                       name="{{ $program->id }}-letter"/>

                                @if ($errors->has($program->id . '-letter'))
                                    <span class="invalid-feedback">
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
        @include('snippet.formgroup', ['type' => 'submit', 'label' => '', 'attribs' => ['name' => 'Save Changes (slow)']])
    </form>
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
