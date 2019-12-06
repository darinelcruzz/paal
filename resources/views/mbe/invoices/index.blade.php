@extends('mbe.root')

@push('pageTitle', 'Facturas')

@push('headerTitle', strtoupper(fdate($date, 'l d \d\e F', 'Y-m-d')))

@section('content')
    <div class="row">        
        <div class="col-md-9">
            <solid-box title="EFECTIVO" color="success" button>
                
                <data-table>

                    {{ drawHeader('FI', 'método', 'cliente', 'XML', 'referencia', 'importe') }}

                    <template slot="body">

                        @php
                            $pending = 0;
                        @endphp

                        @foreach($cash_invoices as $invoice => $sales)
                            <tr>
                                <td style="width: 7%">{{ $invoice }}</td>
                                <td style="width: 20%">{{ strtoupper($sales->first()->method) }}</td>
                                <td style="width: 35%">{{ $sales->first()->client->name }}</td>
                                <td style="width: 5%; text-align: center;">
                                    @if($sales->first()->xml)
                                        <a href="{{ $sales->first()->xml }}" target="_blank" style="color: green">
                                            <i class="fa fa-file-excel"></i>
                                        </a>
                                    @endif
                                </td>
                                @php
                                    $subamount = 0;
                                    foreach ($sales as $sale) {
                                        $subamount += $sale->payments->sum('cash');
                                    }
                                @endphp
                                <td style="text-align: center">
                                    @if($sales->first()->status == 'cancelado')
                                        <em><code>cancelada</code></em>
                                    @elseif(!$sales->first()->cash_reference && $sales->first()->method == 'efectivo' || $sales->first()->client_id > 627 && !$sales->first()->reference)
                                        
                                        @php
                                            $pending += $subamount;
                                        @endphp

                                        <a href="" data-toggle="modal" data-target="#details{{ $invoice }}">
                                            <em>agregar...</em>
                                        </a>

                                        {!! Form::open(['method' => 'POST', 'route' => 'mbe.ingress.reference']) !!}
                                
                                        <modal title="Agregar referencia del depósito" id="details{{ $invoice }}" color="success">

                                            <div class="row">
                                                <div class="col-md-4 col-md-offset-4">
                                                    {!! Field::text($sales->first()->client_id > 627 ? 'reference': 'cash_reference', 
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
                                                {!! Form::submit('Guardar', ['class' => 'btn btn-success pull-right']) !!}
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

            <solid-box title="TARJETAS, TRANSFERENCIAS, ETC" color="primary" button collapsed>
                
                <data-table>

                    {{ drawHeader('FI', 'método', 'cliente', 'XML', 'referencia', 'importe') }}

                    <template slot="body">

                        @foreach($invoices as $invoice => $sales)
                            <tr>
                                <td style="width: 7%">{{ $invoice }}</td>
                                <td style="width: 20%">{{ strtoupper($sales->first()->method) }}</td>
                                <td style="width: 35%">{{ $sales->first()->client->name }}</td>
                                <td style="width: 5%; text-align: center;">
                                    @if($sales->first()->xml)
                                        <a href="{{ $sales->first()->xml }}" target="_blank" style="color: green">
                                            <i class="fa fa-file-excel"></i>
                                        </a>
                                    @endif
                                </td>
                                @php
                                    $subamount = 0;
                                    foreach ($sales as $sale) {
                                        $subamount += $sale->amount;
                                    }
                                @endphp
                                <td style="text-align: center">
                                    @if($sales->first()->status == 'cancelado')
                                        <em><code>cancelada</code></em>
                                    @elseif(!$sales->first()->cash_reference && $sales->first()->method == 'efectivo' || $sales->first()->client_id > 627 && !$sales->first()->reference)

                                        <a href="" data-toggle="modal" data-target="#details{{ $invoice }}">
                                            <em>agregar...</em>
                                        </a>

                                        {!! Form::open(['method' => 'POST', 'route' => 'mbe.ingress.reference']) !!}
                                
                                        <modal title="Agregar referencia del depósito" id="details{{ $invoice }}" color="success">

                                            <div class="row">
                                                <div class="col-md-4 col-md-offset-4">
                                                    {!! Field::text($sales->first()->client_id > 627 ? 'reference': 'cash_reference', 
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
                                                {!! Form::submit('Guardar', ['class' => 'btn btn-success pull-right']) !!}
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
            <a href="{{ route('mbe.invoice.print', $date) }}" class="btn btn-default btn-block" target="_blank">
                <i class="fa fa-download"></i>&nbsp; DESCARGAR MES &nbsp;<i class="fa fa-file-pdf"></i>
            </a>
            <br>

            {!! Form::open(['method' => 'post', 'route' => 'mbe.invoice.index']) !!}
                
                <div class="row">
                    <div class="col-md-3">
                        <div class="input-group input-group-sm">
                            <input type="date" name="date" class="form-control" value="{{ $date }}">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-search"></i></button>
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
            </div>
        </div>
    </div>

@endsection