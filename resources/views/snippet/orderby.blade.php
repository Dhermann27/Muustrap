@inject('home', 'App\Http\Controllers\HomeController')
<div class="row float-right pb-2">
    <a href="{{ $url }}.xls" class="btn btn-info" data-toggle="tooltip" title="Download Excel"><i
                class="fa fa-download"></i></a>
    @if(count($years) > 1)
        <div class="dropdown px-2">
            <a class="btn btn-info dropdown-toggle" href="#" role="button" id="orderByYearLink" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
                {{ !empty($thisyear) ? $thisyear : $home->year()->year }}
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="orderByYearLink">
                @foreach($years as $year)
                    <a class="dropdown-item" href="{{ $url }}/{{ $year->year }}/{{ !empty($order) ? $order : 'name'}}">Filter
                        by {{ $year->year }}</a>
                @endforeach
            </div>
        </div>
    @endif
    @if(count($orders) > 1)
        <div class="dropdown">
            <a class="btn btn-info dropdown-toggle" href="#" role="button" id="orderByOrderLink" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
                Order By {{ !empty($order) ? ucwords($order) : 'Name' }}
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="orderByOrderLink">
                @foreach($orders as $order)
                    <a class="dropdown-item"
                       href="{{ $url }}/{{ !empty($thisyear) ? $thisyear : $home->year()->year }}/{{ $order }}">Order
                        by {{ ucwords($order) }}</a>
                @endforeach
            </div>
        </div>
    @endif
</div>