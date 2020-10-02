@extends('mbe.root')

@push('pageTitle', 'Empresariales')

@push('headerTitle', $client->name)

@section('content')
    <div class="row">
        
        <div class="col-md-6">

            <solid-box title="Órdenes de trabajo por facturar" color="warning">
                
                {!! Form::open(['method' => 'post', 'route' => 'mbe.order.update', 'files' => 'true']) !!}
                
                <data-table classes="spanish-simple">

                    <template slot="header">
                        <tr>
                            <th style="width: 5%"><input type="checkbox" v-on:click="checkAll({{ json_encode($ingresses) }})" v-model="mbe.check"></th>
                            {{-- <th style="width: 5%"><i class="fa fa-check"></i></th> --}}
                            <th style="width: 10%">OT</th>
                            <th>Captura</th>
                            <th style="text-align: right;">I.V.A.</th>
                            <th style="text-align: right;">Importe</th>
                        </tr>
                    </template>


                    <template slot="body">

                        @foreach($ingresses as $ingress)
                            <tr>
                                <th>
                                    @if($ingress->invoice_id == null)
                                        <input type="checkbox" 
                                            :value="{id: {{ $ingress->id }}, iva: {{ $ingress->iva}}, amount: {{ round($ingress->amount, 2) }}, folio: {{ $ingress->folio }} }" v-model="mbe.checked" v-on:change="updateCheckall({{ json_encode($ingresses) }})">
                                    @else
                                        <i class="fa fa-check"></i>
                                    @endif
                                </th>
                                <td>
                                    {{ $ingress->folio }}
                                </td>
                                <td>
                                    {{ fdate($ingress->bought_at, 'd/m/Y', 'Y-m-d') }}
                                </td>
                                <td style="text-align: right;">
                                    $ {{ number_format($ingress->iva, 2) }}
                                </td>
                                <td style="text-align: right;">
                                    $ {{ number_format($ingress->amount, 2) }}
                                </td>
                            </tr>
                        @endforeach

                    </template>
                    
                    @if($client->ingresses->count() > 0)
                    <template slot="footer">
                        <tr>
                            <td colspan="2">
                                <a href="" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-cash" title="AGREGAR FI">
                                    <i class="fa fa-plus"></i> FACTURAR
                                </a>
                            </td>
                            <th style="text-align: right;">Total</th>
                            <td style="text-align: right;">
                                $ @{{ mbe.checked.reduce((iva, item) => iva + item.iva, 0) | currency }}
                            </td>
                            <td style="text-align: right;">
                                $ @{{ mbe.checked.reduce((amount, item) => amount + item.amount, 0) | currency }}
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

                            {!! Field::date('invoiced_at', 
                                ['label' => 'Fecha factura', 'tpl' => 'withicon', 'required' => 'true'], 
                                ['icon' => 'calendar']) 
                            !!}

                            <input type="hidden" name="sales" :value="mbe.phpChecked">
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
                            <th>Factura</th>
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
                                <td>
                                    {{ fdate($invoice->first()->invoiced_at, 'd/m/Y', 'Y-m-d') }}
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
