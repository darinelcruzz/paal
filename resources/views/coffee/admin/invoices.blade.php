@extends('coffee.root')

@push('pageTitle', 'Facturas')

@section('content')

    <div class="row">
        
        <div class="col-md-9">

            <solid-box title="{{ strtoupper(fdate($date, 'l d \d\e F', 'Y-m-d')) }}" color="danger">
                
                <table class="table table-striped table-bordered spanish-simple">
                    <thead>
                        <tr>
                            <th style="text-align: center;"><small>FI</small></th>
                            <th style="text-align: center;"><small>PI</small></th>
                            <th><small>NOTAS</small></th>
                            <th><small>MÉTODO</small></th>
                            <th><small>CLIENTE</small></th>
                            <th style="text-align: center;"><small>REFERENCIA</small></th>
                            <th style="text-align: right;"><small>IMPORTE</small></th>
                        </tr>
                    </thead>

                    <tbody>

                        @php
                            $pending = 0;
                        @endphp

                        @foreach($invoices->groupBy('invoice_id') as $invoice => $sales)
                            <tr>
                                <td style="width: 10%;text-align: center;">
                                    <a href="{{ $sales->first()->xml }}" target="_blank" style="color: green">
                                    {{ $invoice }}
                                    </a><br>
                                    {{ number_format($sales->sum('amount') - $sales->first()->pi_amount, 2) }}
                                </td>
                                <td style="width: 10%;text-align: center;">
                                    <a href="{{ $sales->first()->pi_xml }}" target="_blank" style="color: blue">
                                    {{ $sales->first()->pinvoice_id ?? 'N/A' }}
                                    </a>
                                    <br>
                                    {{ number_format($sales->first()->pi_amount, 2) }}
                                </td>
                                <td>
                                    @if($sales->count() > 1)
                                        <em><small>GLOBAL</small></em>
                                    @else
                                        {{ $sales->first()->folio }}
                                    @endif
                                </td>
                                <td style="width: 17%">{{ $sales->first()->cash > 0 ? 'Efectivo' : ucwords($sales->first()->pay_method) }}</td>
                                <td style="width: 35%">{{ $sales->first()->client->name }}</td>
                                @php
                                    $subamount = 0;
                                    foreach ($sales as $sale) {
                                        $subamount += $sale->cash > 0 ? $sale->payments->sum('cash'): $sale->amount;
                                    }
                                @endphp
                                <td style="text-align: center">
                                    @if (!$sales->first()->cash_reference && $sales->first()->cash > 0)
                                        
                                        @php
                                            $pending += $subamount;
                                        @endphp

                                        <a href="" data-toggle="modal" data-target="#details{{ $invoice }}">
                                            <em>agregar...</em>
                                        </a>

                                        {!! Form::open(['method' => 'POST', 'route' => 'coffee.admin.reference']) !!}
                                
                                        <modal title="Agregar referencia del depósito" id="details{{ $invoice }}" color="#dd4b39">

                                            <div class="row">
                                                <div class="col-md-4 col-md-offset-4">
                                                    {!! Field::text('cash_reference', 
                                                        ['tpl' => 'withicon', 'ph' => 'XXXXXXXXX', 'required' => 'true'], 
                                                        ['icon' => 'exchange-alt']) 
                                                    !!}

                                                    <input type="hidden" name="thisDate" value="{{ $date }}">
                                                </div>
                                            </div>

                                            @foreach ($sales as $sale)
                                                <input type="hidden" name="sales[]" value="{{ $sale->id }}">
                                            @endforeach

                                            <template slot="footer">
                                                {!! Form::submit('Guardar', ['class' => 'btn btn-danger pull-right']) !!}
                                            </template>
                                        </modal>

                                        {!! Form::close() !!}
                                    @else
                                        {{ $sales->first()->cash_reference ?? $sales->first()->reference  }}
                                    @endif
                                </td>
                                <td style="text-align: right; width: 15%;">{{ number_format($subamount, 2) }}</td>
                            </tr>
                        @endforeach

                        @foreach($pinvoices->groupBy('pinvoice_id') as $invoice => $sales)
                            <tr>
                                <td style="width: 10%;text-align: center;">
                                    <a href="{{ $sales->first()->xml }}" target="_blank" style="color: green">
                                    N/A
                                    </a><br>
                                    {{ number_format($sales->sum('amount') - $sales->sum('pi_amount'), 2) }}
                                </td>
                                <td style="width: 10%;text-align: center;">
                                    <a href="{{ $sales->first()->pi_xml }}" target="_blank" style="color: blue">
                                    {{ $invoice }}
                                    </a>
                                    <br>
                                    {{ number_format($sales->sum('pi_amount'), 2) }}
                                </td>
                                <td>
                                    @if($sales->count() > 1)
                                        GLOBAL
                                    @else
                                        {{ $sales->first()->folio }}
                                    @endif
                                </td>
                                <td style="width: 17%">{{ $sales->first()->cash > 0 ? 'Efectivo' : ucwords($sales->first()->pay_method) }}</td>
                                <td style="width: 35%">{{ $sales->first()->client->name }}</td>
                                @php
                                    $subamount = 0;
                                    foreach ($sales as $sale) {
                                        $subamount += $sale->cash > 0 ? $sale->payments->sum('cash'): $sale->amount;
                                    }
                                @endphp
                                <td style="text-align: center">
                                    @if (!$sales->first()->cash_reference && $sales->first()->cash > 0)
                                        
                                        @php
                                            $pending += $subamount;
                                        @endphp

                                        <a href="" data-toggle="modal" data-target="#details{{ $invoice }}">
                                            <em>agregar...</em>
                                        </a>

                                        {!! Form::open(['method' => 'POST', 'route' => 'coffee.admin.reference']) !!}
                                
                                        <modal title="Agregar referencia del depósito" id="details{{ $invoice }}" color="#dd4b39">

                                            <div class="row">
                                                <div class="col-md-4 col-md-offset-4">
                                                    {!! Field::text('cash_reference', 
                                                        ['tpl' => 'withicon', 'ph' => 'XXXXXXXXX', 'required' => 'true'], 
                                                        ['icon' => 'exchange-alt']) 
                                                    !!}

                                                    <input type="hidden" name="thisDate" value="{{ $date }}">
                                                </div>
                                            </div>

                                            @foreach ($sales as $sale)
                                                <input type="hidden" name="sales[]" value="{{ $sale->id }}">
                                            @endforeach

                                            <template slot="footer">
                                                {!! Form::submit('Guardar', ['class' => 'btn btn-danger pull-right']) !!}
                                            </template>
                                        </modal>

                                        {!! Form::close() !!}
                                    @else
                                        {{ $sales->first()->cash_reference ?? $sales->first()->reference  }}
                                    @endif
                                </td>
                                <td style="text-align: right; width: 15%;">{{ number_format($subamount, 2) }}</td>
                            </tr>
                        @endforeach

                        @foreach($canceled as $invoice => $sales)
                            <tr>
                                <td style="width: 7%">{{ $invoice }}</td>
                                <td style="width: 17%">{{ $sales->first()->cash > 0 ? 'Efectivo' : $sales->first()->method_name }}</td>
                                <td style="width: 35%">{{ $sales->first()->client->name }}</td>
                                <td style="width: 5%; text-align: center;">
                                    <a href="{{ $sales->first()->xml }}" target="_blank" style="color: green">
                                        <i class="fa fa-file-excel"></i>
                                    </a>
                                </td>
                                @php
                                    $subamount = 0;
                                    foreach ($sales as $sale) {
                                        $subamount += $sale->cash > 0 ? $sale->payments->sum('cash'): $sale->amount;
                                    }
                                @endphp
                                <td style="text-align: center">
                                    <em><code>cancelada</code></em>
                                </td>
                                <td style="text-align: right; width: 15%;">$ {{ number_format($subamount, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    
                </table>

            </solid-box>
        </div>

        <div class="col-md-3">

            <div class="small-box bg-red">
                <div class="inner">
                    <p>TOTAL POR DEPOSITAR</p>
                    <h3><em>{{ number_format($deposits, 2) }}</em></h3>
                </div>
            </div>
            <a href="{{ route('coffee.admin.printDeposits', $date) }}" class="btn btn-default btn-block" target="_blank">
                <i class="fa fa-download"></i>&nbsp; DESCARGAR MES &nbsp;<i class="fa fa-file-pdf"></i>
            </a>
            <br>

            {!! Form::open(['method' => 'post', 'route' => 'coffee.admin.invoices']) !!}
                
                <div class="row">
                    <div class="col-md-3">
                        <div class="input-group input-group-sm">
                            <input type="date" name="date" class="form-control" value="{{ $date }}">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-danger btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </div>
                </div>

            {!! Form::close() !!}
            <br>

            <div class="small-box bg-yellow">
                <div class="inner">
                    <p>POR DEPOSITAR DEL DÍA</p>
                    <h3><em>$ {{ number_format($pending, 2) }}</em></h3>
                </div>
            </div>
            <a href="{{ route('coffee.admin.downloadExcel', $date) }}" class="btn btn-success btn-block">
                <i class="fa fa-download"></i>&nbsp; DESCARGAR EXCEL &nbsp;<i class="fa fa-file-excel"></i>
            </a>
        </div>
    </div>

@endsection
