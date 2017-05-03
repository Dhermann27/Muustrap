@extends('layouts.app')

@section('content')
    <p>&nbsp;</p>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">Outstanding Balances</div>
            <div class="panel-body">
                @if(!empty($success))
                    <div class="alert alert-success">
                        {!! $success !!}
                    </div>
                @endif
                <table class="table table-responsive table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Family Name</th>
                        <th>Amount</th>
                        @if($readonly === false)
                            <th>Chargetype</th>
                            <th>Payment Amount</th>
                            <th>Memo</th>
                            <th>&nbsp;</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($charges as $charge)
                        <form id="outstanding" class="form-horizontal" role="form" method="POST"
                              action="{{ url('/reports/outstanding/' . $charge->camperid) }}">
                            {{ csrf_field() }}
                            <tr>
                                <td>{{ $charge->family->name }}</td>
                                <td align="right">{{ money_format('%.2n', $charge->amount) }}</td>
                                @if($readonly === false)
                                    <td>
                                        <label for="chargetype-{{ $charge->familyid }}" class="hidden">Memo</label>
                                        <select class="form-control" id="chargetype-{{ $charge->familyid }}"
                                                name="chargetypeid">
                                            @foreach($chargetypes as $chargetype)
                                                <option value="{{ $chargetype->id }}"
                                                        {{ $chargetype->id == old('chargetypeid') ? ' selected' : '' }}>
                                                    {{ $chargetype->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="form-group{{ $errors->has('amount-' . $charge->familyid) ? ' has-error' : '' }}">
                                        <div class="input-group">
                                            <label for="amount-{{ $charge->familyid }}" class="hidden">Amount</label>
                                            <span class="input-group-addon">$</span>
                                            <input type="number" id="amount-{{ $charge->familyid }}"
                                                   class="form-control" step="any" name="amount"
                                                   data-number-to-fixed="2" value="{{ old('amount') }}"/>
                                        </div>
                                    </td>
                                    <td class="form-group">
                                        <label for="memo-{{ $charge->familyid }}" class="hidden">Memo</label>
                                        <input id="memo-{{ $charge->familyid }}" class="form-control" name="memo"
                                               value="{{ old('memo') }}">
                                    </td>
                                    <td class="form-group">
                                        <button type="submit" class="btn btn-primary">
                                            Submit
                                        </button>
                                    </td>
                                @endif
                            </tr>
                        </form>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="{{ $readonly === false ? '6' : '2' }}" align="right">Total Outstanding:
                            ${{ money_format('%.2n', $charges->sum('amount')) }}
                        </td>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
