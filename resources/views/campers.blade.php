@inject('home', 'App\Http\Controllers\HomeController')
@extends('layouts.app')

@section('css')
    <link rel="stylesheet"
          href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css"/>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.min.css"/>
@endsection

@section('title')
    Camper Information
@endsection

@section('heading')
    This page can show you all individual information about the campers in your family, both attending this year and not.
@endsection

@section('content')
    <div class="container">
        <form id="camperinfo" class="form-horizontal" role="form" method="POST" action="{{ url('/camper') .
                 (isset($readonly) && $readonly === false ? '/f/' . $campers->first()->familyid : '')}}">
            @include('snippet.flash')

            <ul class="nav nav-tabs flex-column flex-lg-row" role="tablist">
                @foreach($campers as $camper)
                    @if($camper->id != '0')
                        <li role="presentation" class="nav-item">
                            <a href="#{{ $camper->id }}" aria-controls="{{ $camper->id }}" role="tab"
                               class="nav-link{!! $loop->first ? ' active' : '' !!}" data-toggle="tab">
                                {{ old('firstname.' . $loop->index, $camper->firstname) }}
                                {{ old('lastname.' . $loop->index, $camper->lastname) }}
                            </a>
                        </li>
                    @endif
                @endforeach
                @if(!isset($readonly) || $readonly === false)
                    <li>
                        <a id="newcamper" class="nav-link" href="#" role="tab">Create New Camper <i
                                    class="fa fa-plus"></i></a>
                    </li>
                @endif
            </ul>

            <div class="tab-content">
                @foreach($campers as $camper)
                    @include('snippet.camper', ['camper' => $camper, 'looper' => $loop])
                @endforeach
            </div>
            @if(!isset($readonly) || $readonly === false)
                @include('snippet.formgroup', ['type' => 'submit', 'label' => '', 'attribs' => ['name' => 'Save Changes']])
            @endif
        </form>
    </div>
    <div id="empty">
        @foreach($empties as $empty)
            @include('snippet.camper', ['camper' => $empty, 'looper' => $loop])
        @endforeach
    </div>
@endsection

@section('script')
    <script src="//code.jquery.com/ui/1.12.1/jquery-ui.min.js"
            integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous">
    </script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript">

        $(function () {

            bind($("body"));

            $('div#empty select, div#empty  input').prop('disabled', true);
            $("#newcamper").on('click', function (e) {
                e.preventDefault();
                var camperCount = $(".tab-content div.tab-pane").length;
                $(this).closest('li').before('<li role="presentation" class="nav-item"><a href="#' + camperCount + '" class="nav-link" data-toggle="tab">New Camper</a></li>');
                var emptycamper = $("div#empty .tab-pane");
                var empty = emptycamper.clone(false).attr("id", camperCount);
                empty.find("input, select").each(function () {
                    $(this).attr("id", $(this).attr("id").replace(/\d+$/, camperCount));
                    $(this).prop('disabled', false);
                });
                empty.find("label").each(function () {
                    $(this).attr("for", $(this).attr("for").replace(/\d+$/, camperCount));
                });
                $("form#camperinfo .tab-content").append(empty);
                $('.nav-tabs a[href="#' + camperCount + '"]').tab('show');
                bind(empty);
            });

            $('input:submit').on('click', function (e) {
                e.preventDefault();
                var form = $("#camperinfo");
                var fa = window.FontAwesome;
                var spin = fa.findIconDefinition({iconName: 'spinner-third'});
                $(this).html(fa.icon(spin, {classes: ['fa-spin']}).html + " Saving").removeClass("btn-primary btn-danger").prop("disabled", true);
                if (!confirm("You are registering " + form.find('select.days option[value!="0"]:selected').length + " campers for {{ $home->year()->year }}. Is this correct?")) {
                    var times = fa.findIconDefinition({iconName: 'times'});
                    $(this).html(fa.icon(times).html + " Resubmit").addClass("btn-danger").prop("disabled", false);
                    return false;
                }
                $(".has-danger").removeClass("has-danger");
                $(".is-invalid").removeClass("is-invalid");
                $(".invalid-feedback").remove();
                $("div.alert").remove();
                $.ajax({
                    url: form.attr("action"),
                    type: 'post',
                    data: form.serialize(),
                    async: false,
                    success: function (data) {
                        $(".nav-tabs").before("<div class='alert alert-success'>" + data + "</div>");
                        var check = fa.findIconDefinition({iconName: 'check'});
                        $(this).html(fa.icon(check).html + " Saved").addClass("btn-success");
                        $('html,body').animate({
                            scrollTop: 0
                        }, 700);
                    },
                    error: function (data) {
                        if (data.status === 500) {
                            $(".nav-tabs").before("<div class='alert alert-danger'>Unknown error occurred. Please use the Contact Us form to ask for assistance and include the approximate time you received this message.</div>");
                        } else {
                            var errorCount = data !== undefined ? Object.keys(data.responseJSON.errors).length : '';
                            $.each(data.responseJSON.errors, function (k, v) {
                                var group = $("#" + k.replace(".", "-")).parents(".form-group").addClass("has-danger");
                                group.find("select,input").addClass('is-invalid');
                                group.find("div:first").append("<span class=\"invalid-feedback\"><strong>" + this[0] + "</strong></span>");
                            });
                            $("span.invalid-feedback").show();
                            $(".nav-tabs").before("<div class='alert alert-danger'>You have " + errorCount + " error(s) in your form. Please adjust your entries and resubmit.</div>");
                            $('.nav-tabs a[href="#' + $("span.invalid-feedback:first").parents('div.tab-pane').attr('id') + '"]').tab('show');
                        }
                        var times = fa.findIconDefinition({iconName: 'times'});
                        $(this).html(fa.icon(times).html + " Resubmit").addClass("btn-danger").prop("disabled", false);
                        $('html,body').animate({
                            scrollTop: 0
                        }, 700);
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
            obj.find(".next").click(nextCamper);
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
                        $("form#camperinfo .tab-pane").each(function () {
                            var names = $(this).find("input.campername");
                            if (names.length === 2 && $(names[0]).val() === ui.item.firstname && $(names[1]).val() === ui.item.lastname) {
                                alert("No need to specify a family member as a roommate/sponsor.");
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