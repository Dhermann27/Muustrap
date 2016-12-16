@extends('layouts.app')

@section('content')
    <div id="fb-root"></div>
    <script>
        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = "" +
                "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
    <div class="jumbotron" style="text-align: center;">
        <h1>MUUSA</h1>
        <p>An annual intergenerational Unitarian Universalist retreat for
            fun, fellowship, and personal growth</p>
        <div class="row">
            <div class="col-md-4">
                <div>
                    <span class="fa fa-map-marker fa-4x"></span>
                </div>
                <h3>Located</h3>
                <p>at Trout Lodge in the YMCA of the Ozarks near Potosi,
                    Missouri</p>
            </div>
            <div class="col-md-4">
                <div>
                    <span class="fa fa-calendar fa-4x"></span>
                </div>
                <h3>Scheduled</h3>
                <p>Sunday, July 2nd through Saturday, July 8th 2017</p>
            </div>
            <div class="col-md-4">
                <div>
                    <span class="fa fa-fire fa-4x"></span>
                </div>
                <h3>All are welcome</h3>
                <p>regardless of age, race, ethnicity, gender, sexual
                    orientation, social class or ability</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-9" align="center">
            <h2>This page is under construction. Registration opens on
                February 1.</h2>
            <p>
                You can visit our <a href="https://www.facebook.com/Muusa2013/">Facebook
                    page</a> or email our <a href="mailto:info@muusa.org">Marketing
                    Coordinator</a> with any questions in the meantime.
            </p>
        </div>
        <div class="col-md-3">
            <div class="fb-page" data-href="https://www.facebook.com/Muusa2013/"
                 data-tabs="timeline" data-small-header="false"
                 data-adapt-container-width="true" data-hide-cover="false"
                 data-show-facepile="true">
                <blockquote cite="https://www.facebook.com/Muusa2013/"
                            class="fb-xfbml-parse-ignore">
                    <a href="https://www.facebook.com/Muusa2013/">MUUSA</a>
                </blockquote>
            </div>
            <a class="twitter-timeline" data-width="462" data-height="700"
               href="https://twitter.com/muusa1">Tweets by muusa1</a>
            <script async src="//platform.twitter.com/widgets.js"
                    charset="utf-8"></script>
        </div>
    </div>
@endsection