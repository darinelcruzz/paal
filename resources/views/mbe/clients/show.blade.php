@extends('mbe.root')

@push('pageTitle')
    Empresariales
@endpush

@push('headerTitle')
    {{ $client->name }}
@endpush

@section('content')
    <div class="row">
        
        <div class="col-md-6">

            <solid-box title="Órdenes de trabajo por facturar" color="warning">
                
                {!! Form::open(['method' => 'post', 'route' => 'mbe.order.update', 'files' => 'true']) !!}
                
                <data-table classes="spanish-simple">

                    {{-- {{ drawHeader('OT', 'fecha', 'i.V.A.', 'monto') }} --}}

                    <template slot="header">
                        <tr>
                            <th style="width: 5%"><i class="fa fa-check"></i></th>
                            <th style="width: 10%">OT</th>
                            <th>Fecha</th>
                            <th>Factura</th>
                            <th>I.V.A.</th>
                            <th>Importe</th>
                        </tr>
                    </template>


                    <template slot="body">

                        @foreach($ingresses as $ingress)
                            <tr>
                                <th>
                                    @if($ingress->invoice_id == null)
                                        <input type="checkbox" name="sales[]" value="{{ $ingress->id }}" checked>
                                    @else
                                        <i class="fa fa-check"></i>
                                    @endif
                                </th>
                                <td>
                                    {{ $ingress->folio }}
                                </td>
                                <td>
                                    {{ $ingress->created_at->format('d/m/Y') }}
                                </td>
                                <td>
                                    {{ $ingress->invoice_id or 'No facurado' }}
                                </td>
                                <td>
                                    $ {{ number_format($ingress->iva, 2) }}
                                </td>
                                <td>
                                    $ {{ number_format($ingress->amount, 2) }}
                                </td>
                            </tr>
                        @endforeach

                    </template>
                    
                    @if($client->ingresses->count() > 0)
                    <template slot="footer">
                        <tr>
                            <th></th>
                            <td>
                                <a href="" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-cash" title="AGREGAR FI">
                                    <i class="fa fa-plus"></i> FACTURAR
                                </a>
                            </td>
                            <td></td>
                            <th>Total</th>
                            <td>
                                $ {{ number_format($client->ingresses->sum('iva'), 2) }}
                            </td>
                            <td>
                                $ {{ number_format($client->ingresses->sum('amount'), 2) }}
                            </td>
                        </tr>
                    </template>
                    @endif
                </data-table>

                <modal title="Agregar datos de la factura" id="modal-cash" color="success">

                    <div class="row">
                        <div class="col-md-4 col-md-offset-4">
                            {!! Field::number('invoice_id', 
                                ['label' => 'Agregar FI', 'tpl' => 'withicon', 'ph' => 'XXXXXXXXX', 'required' => 'true'], 
                                ['icon' => 'file-invoice']) 
                            !!}
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-2 col-md-offset-5">
                            <file-upload bname=" SUBIR XML" fname="xml" ext="xml" color="danger"></file-upload>
                        </div>
                    </div>

                    <template slot="footer">
                        {!! Form::submit('Guardar', ['class' => "btn btn-success pull-right"]) !!}
                    </template>
                </modal>

                {!! Form::close() !!}
            </solid-box>
        </div>

        <div class="col-md-6">

            <solid-box title="Facturas" color="success">
                
                <data-table classes="spanish-simple">

                    <template slot="header">
                        <tr>
                            <th style="width: 10%">FI</th>
                            <th>OTs</th>
                            <th>I.V.A.</th>
                            <th>Importe</th>
                        </tr>
                    </template>


                    <template slot="body">

                        @php
                            $iva = $amount = 0
                        @endphp

                        @foreach($invoices as $invoice)
                            <tr>
                                <td>{{ $invoice->first()->invoice_id }}</td>
                                <td>
                                    @foreach($invoice as $ot)
                                    {{ $ot->folio }} {{ $loop->last ? '': ', '}}
                                    @endforeach
                                </td>
                                <td>$ {{ number_format($invoice->sum('iva'), 2) }}</td>
                                <td>$ {{ number_format($invoice->sum('amount'), 2) }}</td>
                            </tr>

                            @php
                                $iva += $invoice->sum('iva');
                                $amount += $invoice->sum('amount');
                            @endphp
                        @endforeach

                    </template>

                    <template slot="footer">
                        <tr>
                            <td></td>
                            <th>Total</th>
                            <td>
                                $ {{ number_format($iva, 2) }}
                            </td>
                            <td>
                                $ {{ number_format($amount, 2) }}
                            </td>
                        </tr>
                    </template>

                </data-table>
            </solid-box>
        </div>
    </div>

@endsection