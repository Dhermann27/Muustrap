{{--<section id="blog" class="light-bg">--}}
    <div class="container inner-top-sm inner-bottom classic-blog no-sidebar">
        <div class="row">
            <div class="col-lg-9 mx-auto">
                <div class="posts sidemeta">
                    <div class="post format-gallery">
                        {{ $slot }}

                        {{--@foreach($programs as $program)--}}
                        {{--<div class="post-content">--}}
                        {{--<h3 class="post-title">{{ $program->name }}</h3>--}}
                        {{--<p>{!! $program->blurb !!}</p>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
{{--</section>--}}