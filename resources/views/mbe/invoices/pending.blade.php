@extends('mbe.root')

@push('pageTitle')
    Facturas pendientes
@endpush

@section('content')
    <div class="row">        
        <div class="col-md-6">
            <solid-box title="Pendientes de complemento de pago" color="warning">
                
                <data-table example="1">

                    {{ drawHeader('FI', 'cliente', 'referencia', 'complemento', 'importe') }}

                    <template slot="body">

                        @foreach($invoices as $invoice => $sales)
                            <tr>
                                <td style="width: 7%">{{ $invoice }}</td>
                                <td style="width: 35%">{{ $sales->first()->client->name }}</td>
                                @php
                                    $subamount = 0;
                                    foreach ($sales as $sale) {
                                        $subamount += $sale->cash > 0 ? $sale->payments->sum('cash'): $sale->amount;
                                    }
                                @endphp
                                <td>
                                    {{ $sales->first()->reference  }}
                                </td>
                                <td style="text-align: center">

                                    <a href="" data-toggle="modal" data-target="#details{{ $invoice }}">
                                        <em>agregar...</em>
                                    </a>

                                    {!! Form::open(['method' => 'POST', 'route' => 'mbe.invoice.complement', 'files' => 'true']) !!}
                            
                                    <modal title="Agregar complemento de pago" id="details{{ $invoice }}" color="success">

                                        <div class="row">
                                            <div class="col-md-4 col-md-offset-4">
                                                <file-upload bname=" SUBIR XML" fname="xml" ext="xml" color="danger"></file-upload>
                                                <input type="hidden" name="invoice_id" value="{{ $invoice }}">
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
                                </td>
                                <td style="text-align: right; width: 15%;">$ {{ number_format($subamount, 2) }}</td>
                            </tr>
                        @endforeach
                    </template>
                    
                </data-table>

            </solid-box>
        </div>

        <div class="col-md-6">
            <solid-box title="Complemento de pago agregado" color="success">
                
                <data-table example="1">

                    {{ drawHeader('FI', 'cliente', 'referencia', 'XML', 'importe') }}

                    <template slot="body">

                        @foreach($completed as $invoice => $sales)
                            <tr>
                                <td style="width: 7%">{{ $invoice }}</td>
                                <td style="width: 35%">{{ $sales->first()->client->name }}</td>
                                @php
                                    $subamount = 0;
                                    foreach ($sales as $sale) {
                                        $subamount += $sale->cash > 0 ? $sale->payments->sum('cash'): $sale->amount;
                                    }
                                @endphp
                                <td>
                                    {{ $sales->first()->reference  }}
                                </td>
                                <td style="text-align: center">
                                    <a href="{{ $sales->first()->xml_complement }}" target="_blank" style="color: green">
                                        <i class="fa fa-file-code"></i>
                                    </a>
                                </td>
                                <td style="text-align: right; width: 15%;">$ {{ number_format($subamount, 2) }}</td>
                            </tr>
                        @endforeach
                    </template>
                    
                </data-table>

            </solid-box>
        </div>
    </div>

@endsection