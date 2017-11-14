@inject('home', 'App\Http\Controllers\HomeController')
<form class="form-inline">
    @if(count($years) > 1)
        <div class="col-sm-2">
            <label for="orderby-years" class="sr-only">Filter By Year</label>
            <select id="orderby-years" class="form-control">
                @foreach($years as $year)
                    <option value="{{ $year->year }}"
                            {{ (strpos($_SERVER['REQUEST_URI'], '/' . $year->year . '/') !== false) ? 'selected' : '' }}>
                        Filter by {{ $year->year }}
                    </option>
                @endforeach
            </select>
        </div>
    @else
        <div class="col-sm-2">
            <input type="hidden" id="orderby-years" value="{{ $home->year()->year }}"/>
        </div>
    @endif
    @if(count($orders) > 1)
        <div class="col-sm-2">
            <label for="orderby-order" class="sr-only">Order By</label>
            <select id="orderby-order" class="form-control">
                @foreach($orders as $order)
                    <option value="{{ $order }}"
                            {{ (strpos($_SERVER['REQUEST_URI'], '/' . $order) !== false) ? 'selected' : '' }}>
                        Order By {{ ucwords($order) }}
                    </option>
                @endforeach
            </select>
        </div>
    @else
        <div class="col-sm-2">
            <input type="hidden" id="orderby-order" value="name"/>
        </div>
    @endif
    <button id="orderby-submit" type="button" class="btn btn-primary col-sm-1">Go</button>
</form>