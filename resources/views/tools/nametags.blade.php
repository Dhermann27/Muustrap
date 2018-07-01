<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Nametags</title>
    <link rel="stylesheet" href="/css/muustrap.css" type="text/css"/>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.1.0/css/all.css"
          integrity="sha384-87DrmpqHRiY8hPLIr7ByqhPIywuSsjuQAfMXAE0sMUpY3BM7nXjf+mLIUSvhDArs" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans|Bangers|Fredericka+the+Great|Great+Vibes|Indie+Flower|Mystery+Quest"
          rel="stylesheet">
    <style>
        body {
            width: 8.5in;
            margin: 0in .1875in;
        }

        @page {
            margin: 1in 0px 0px 0px;
        }

        .label {
            float: left;
        }

        .page-break {
            clear: left;
            display: block;
            page-break-after: always;
        }
    </style>
</head>
<body>

@php
    $backs = array();
@endphp
@foreach($campers as $camper)
    @php
        switch ($loop->index % 6) {
            case 0:
                $pointer = 1;
                break;
            case 1:
                $pointer = 0;
                break;
            case 2:
                $pointer = 3;
                break;
            case 3:
                $pointer = 2;
                break;
            case 4:
                $pointer = 5;
                break;
            case 5:
                $pointer = 4;
                break;
        }
        array_splice($backs, $pointer, 0, $camper->nametag_back);
    @endphp
    @include('snippet.nametag', ['camper' => $camper])
    @if((!$loop->first && ($loop->index+1) % 6 == 0) || $loop->last)
        <div class="page-break"></div>
        @foreach($backs as $back)
            <div class="label">
                <p>&nbsp;</p>
                <p>{!! $back !!}</p>
            </div>
        @endforeach
        @php
            $backs = array();
        @endphp
        <div class="page-break"></div>
    @endif
@endforeach
</body>
</html>