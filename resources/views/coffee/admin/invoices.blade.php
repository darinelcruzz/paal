@extends('coffee.root')

@push('pageTitle')
    Facturas
@endpush

@section('content')

    <div class="row">
        
        <div class="col-md-9">

            <solid-box title="{{ strtoupper(fdate($date, 'l d \d\e F', 'Y-m-d')) }}" color="danger">
                
                <data-table example="1">

                    {{-- {{ drawHeader('FI', 'método', 'cliente', 'XML', 'referencia', 'Importe') }} --}}

                    <template slot="header">
                        <tr>
                            <th>FI</th>
                            <th>Método</th>
                            <th>Cliente</th>
                            <th>XML</th>
                            <th style="text-align: center;">Referencia</th>
                            <th style="text-align: right;">Importe</th>
                        </tr>
                    </template>

                    <template slot="body">

                        @php
                            $pending = 0;
                        @endphp

                        @foreach($invoices as $invoice => $sales)
                            <tr>
                                <td style="width: 7%">{{ $invoice }}</td>
                                <td style="width: 17%">{{ $sales->first()->method_name }}</td>
                                <td style="width: 35%">{{ $sales->first()->client->name }}</td>
                                <td style="width: 5%; text-align: center;">
                                    <a href="{{ $sales->first()->xml }}" target="_blank" style="color: green">
                                        <i class="fa fa-file-excel"></i>
                                    </a>
                                </td>
                                @php
                                    $subamount = 0;
                                    foreach ($sales as $sale) {
                                        $subamount += $sale->method == 'cash' ? $sale->payments->sum('cash'): $sale->amount;
                                    }
                                @endphp
                                <td style="text-align: center">
                                    @if (!$sales->first()->cash_reference && $sales->first()->method == 'cash')
                                        
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
                                <td style="text-align: right; width: 15%;">$ {{ number_format($subamount, 2) }}</td>
                            </tr>
                        @endforeach
                    </template>
                    
                </data-table>

            </solid-box>
        </div>

        <div class="col-md-3">

            <div class="small-box bg-red">
                <div class="inner">
                    <p>TOTAL POR DEPOSITAR</p>
                    <h3>
                        <em>$ {{ number_format($total, 2) }}</em>
                    </h3>
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
                    <h3>
                        <em>$ {{ number_format($pending, 2) }}</em>
                    </h3>
                </div>
                {{-- <div class="icon">
                    <i class="fa fa-piggy-bank"></i>
                </div> --}}
            </div>
            <a href="{{ route('coffee.admin.downloadExcel', $date) }}" class="btn btn-success btn-block">
                <i class="fa fa-download"></i>&nbsp; DESCARGAR EXCEL &nbsp;<i class="fa fa-file-excel"></i>
            </a>
        </div>
    </div>

@endsection