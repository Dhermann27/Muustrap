<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Nametags</title>
    <link rel="stylesheet" href="/css/muustrap.css" type="text/css"/>
    <script src="//use.fontawesome.com/9364904132.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans|Bangers|Fredericka+the+Great|Great+Vibes|Indie+Flower|Mystery+Quest"
          rel="stylesheet">
    <style>
        body {
            width: 8.5in;
            margin: 0in;
        }

        @page {
            margin: 1in 0px 0px 0px;
        }

        .label {
            width: 3.65in;
            height: 2.875in;
            padding: .125in .3in 0;
            margin-right: 0in;
            float: left;
            overflow: hidden;
        }

        .page-break {
            clear: left;
            display: block;
            page-break-after: always;
        }
    </style>
</head>
<body>

@foreach($campers as $camper)
    <div class="label">
        <div class="{{ $camper->yearattending->fontapply == '2' ? ' ' . $camper->yearattending->font_value : '' }}">
            <div class="pronoun">{{ $camper->yearattending->pronoun_value }}</div>
            <div class="name {{ $camper->yearattending->font_value }}"
                 style="font-size: {{ $camper->yearattending->namesize+1 }}em;">{{ $camper->yearattending->name_value }}</div>
            <div class="surname">{{ $camper->yearattending->surname_value  }}</div>
            <div class="line1">{{ $camper->yearattending->line1_value }}</div>
            <div class="line2">{{ $camper->yearattending->line2_value }}</div>
            <div class="line3">{{ $camper->yearattending->line3_value }}</div>
            <div class="line4">{{ $camper->yearattending->line4_value }}</div>
            @if($camper->age<18)
                <div class="parent">{!! $camper->parent !!}</div>
            @endif
        </div>
    </div>
    @if(!$loop->first && ($loop->index+1) % 6 == 0)
        <div class="page-break"></div>
    @endif
@endforeach
</body>
</html>