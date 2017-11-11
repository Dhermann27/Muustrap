@inject('home', 'App\Http\Controllers\HomeController')
@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css"/>
    <link rel="stylesheet" href="/css/bootstrap-datepicker.min.css"/>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.min.css"/>
@endsection

@section('title')
    Camper Information
@endsection

@section('heading')
    This page can show you all individual information about the campers in your family, both attending this year and not.
@endsection

@section('content')
    <form id="camperinfo" class="form-horizontal" role="form" method="POST" action="{{ url('/camper') .
                 (isset($readonly) && $readonly === false ? '/f/' . $campers->first()->familyid : '')}}">
        @include('snippet.flash')

        @if(count($errors))
            <div class="alert alert-danger">
                Changes were not saved. Please review each camper and
                correct the errors outlined in red. {{ $errors->first() }}
            </div>
        @endif
        <ul class="nav nav-tabs" role="tablist">
            @foreach($campers as $camper)
                @if($camper->id != '0')
                    <li role="presentation"{!! $loop->first ? ' class="active"' : '' !!}>
                        <a href="#{{ $camper->id }}" aria-controls="{{ $camper->id }}" role="tab"
                           data-toggle="tab">{{ old('firstname.' . $loop->index, $camper->firstname) }}
                            {{ old('lastname.' . $loop->index, $camper->lastname) }}
                        </a>
                    </li>
                @endif
            @endforeach
            @if(!isset($readonly) || $readonly === false)
                <li>
                    <a id="newcamper" href="#" role="tab">Create New Camper <i class="fa fa-plus"></i></a>
                </li>
            @endif
        </ul>

        <div class="tab-content">
            @foreach($campers as $camper)
                @include('snippet.camper', ['camper' => $camper, 'looper' => $loop])
            @endforeach
        </div>
        @if(!isset($readonly) || $readonly === false)
            <div class="col-md-2 col-md-offset-8">
                <button id="submit" type="button" class="btn btn-primary">Save Changes</button>
            </div>
        @endif
    </form>
    <div id="empty" class="hidden">
        @foreach($empties as $empty)
            @include('snippet.camper', ['camper' => $empty, 'looper' => $loop])
        @endforeach
    </div>
@endsection

@section('script')
    <script src="//code.jquery.com/ui/1.12.1/jquery-ui.min.js"
            integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous">
    </script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js"></script>
    <script src="/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript">

        $(function () {
            @if(count($errors))
            $('.nav-tabs a[href="#' + $("span.help-block").first().parents('div.tab-pane').attr('id') + '"]').trigger('click');
            @endif

            bind($("body"));

            $('div#empty select, div#empty  input').prop('disabled', true);
            $("#newcamper").on('click', function (e) {
                e.preventDefault();
                var camperCount = $(".tab-content div.tab-pane").length;
                $(this).closest('li').before('<li role="presentation"><a href="#' + camperCount + '" aria-controls="' + camperCount + '" role="tab" data-toggle="tab">New Camper</a></li>');
                var emptycamper = $("div#empty .tab-pane");
                var empty = emptycamper.clone(false).attr("id", camperCount);
                empty.find("input, select").each(function () {
                    $(this).attr("id", $(this).attr("id").replace(/\d+$/, camperCount));
                    $(this).prop('disabled', false);
                });
                empty.find("label").each(function () {
                    $(this).attr("for", $(this).attr("for").replace(/\d+$/, camperCount));
                });
                $(".tab-content").append(empty);
                $('.nav-tabs a[href="#' + camperCount + '"]').trigger('click');
                bind(empty);
            });

            $('button#submit').on('click', function (e) {
                var form = $("#camperinfo");
                if (!confirm("You are registering " + form.find('select.days option[value!="0"]:selected').length + " campers for {{ $home->year()->year }}. Is this correct?")) {
                    return false;
                }
                var button = $("button#submit").html("<i class='fa fa-spinner fa-spin'></i> Saving...")
                    .removeClass("btn-labeled btn-danger").prop("disabled", true);
                $(".has-error").removeClass("has-error").find(".help-block").remove();
                $("div.alert").remove();
                $.ajax({
                    url: form.attr("action"),
                    type: 'post',
                    data: form.serialize(),
                    async: false,
                    success: function (data) {
                        $(".nav-tabs").before("<div class='alert alert-success'>" + data + "</div>");
                        button.html("<span class='btn-label'><i class='fa fa-check'></i></span> Saved")
                            .addClass("btn-labeled btn-success");
                        $('html,body').animate({
                            scrollTop: 0
                        }, 700);
                    },
                    error: function (data) {
                        if (data.status === 500) {
                            $(".nav-tabs").before("<div class='alert alert-danger'>Unknown error occurred. Please use the Contact Us form to ask for assistance and include the approximate time you received this message.</div>");
                        } else {
                            var errorCount = data !== undefined ? Object.keys(data.responseJSON).length : '';
                            $.each(data.responseJSON, function (k, v) {
                                $("#" + k.replace(".", "-")).parents(".form-group").addClass("has-error").find("div:first")
                                    .append("<span class=\"help-block\"><strong>" + v + "</strong></span>");
                            });
                            $(".nav-tabs").before("<div class='alert alert-danger'>You have " + errorCount + " error(s) in your form. Please adjust your entries and resubmit.</div>");
                            $('.nav-tabs a[href="#' + $("span.help-block:first").parents('div.tab-pane').attr('id') + '"]').trigger('click');
                        }
                        $('html,body').animate({
                            scrollTop: 0
                        }, 700);
                        button.html("<span class='btn-label'><i class='fa fa-times'></i></span> Resubmit")
                            .addClass("btn-labeled btn-danger").prop("disabled", false);
                    }
                });
            });

            @if(isset($readonly) && $readonly === true)
            $("input:not(#camper), select").prop("disabled", "true");
            @endif
        });

        function bind(obj) {
            obj.find("[data-toggle='tooltip']").tooltip({
                content: function () {
                    return this.getAttribute("title");
                }
            });
            obj.find("button#quickme").on("click", function (e) {
                e.preventDefault();
                $("select.days").val('6');
            });
            obj.find(".next").click(function () {
                var next = $('.nav-tabs > .active').next('li').find('a');
                if (next.attr("id") !== 'newcamper') {
                    next.trigger('click');
                    $('html,body').animate({
                        scrollTop: 0
                    }, 700);
                } else {
                    $('button#submit').trigger("focus");
                    $('html,body').animate({
                        scrollTop: 9999
                    }, 700);
                }
            });
            obj.find(".campername").on("change", function () {
                var tab = $(this).parents('div.tab-pane');
                var name = tab.find("input.campername");
                if (name.length === 2) {
                    $('a[href="#' + tab.attr('id') + '"]').text(name[0].value + " " + name[1].value);
                }
            });
            obj.find(".easycamper").each(function () {
                $(this).autocomplete({
                    source: "/data/camperlist",
                    minLength: 3,
                    autoFocus: true,
                    select: function (event, ui) {
                        $(".nav-pane").each(function () {
                            var names = $(this).find("input.campername");
                            if (names.length === 2 && names[0].val() === ui.item.lastname && names[1].val() === ui.item.firstname) {
                                alert("No need to specify a family member as a roommate/sponsor.");
                                return false;
                            }
                        });
                        $(this).val(ui.item.firstname + " " + ui.item.lastname);
                        return false;
                    }
                }).autocomplete('instance')._renderItem = function (ul, item) {
                    return $("<li>").append("<div>" + item.lastname + ", " + item.firstname + "</div>").appendTo(ul);
                }
            });
            obj.find(".churchlist").each(function () {
                $(this).autocomplete({
                    source: "/data/churchlist",
                    minLength: 3,
                    autoFocus: true,
                    select: function (event, ui) {
                        $(this).val(ui.item.name);
                        $(this).next("input").val(ui.item.id);
                        return false;
                    }
                }).autocomplete('instance')._renderItem = function (ul, item) {
                    return $("<li>")
                        .append("<div>" + item.name + " (" + item.city + ", " + item.statecd + ")</div>")
                        .appendTo(ul);
                };
            });
        }
    </script>
@endsection