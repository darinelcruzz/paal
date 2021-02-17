@extends('coffee.root')

@push('pageTitle', 'Corte diario')

@section('content')
    <div class="row">
        
        <div class="col-md-9">

            {!! Form::open(['method' => 'post', 'route' => ['coffee.admin.daily', $status]]) !!}
                
                <div class="row">
                    <div class="col-md-3">
                        <div class="input-group input-group-sm">
                            <input type="date" name="date" class="form-control" value="{{ $date }}">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-danger btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <a href="{{ route('coffee.admin.daily', ['factura', $date]) }}" class="btn btn-primary btn-md">CON FACTURA</a>
                        <a href="{{ route('coffee.admin.daily', ['efectivo', $date]) }}" class="btn btn-success btn-md">EFECTIVO S/F</a>
                        <a href="{{ route('coffee.admin.daily', ['tarjeta', $date]) }}" class="btn btn-warning btn-md">TARJETA S/F</a>
                        <a href="{{ route('coffee.admin.daily', ['transferencia', $date]) }}" class="btn btn-info btn-md">
                            TRANSFERENCIA S/F
                        </a>
                    </div>
                </div>

            {!! Form::close() !!}

            <br>

            {!! Form::open(['method' => 'POST', 'route' => 'coffee.invoice.create', 'files' => 'true']) !!}

            <solid-box title="{{ strtoupper($status) }}" color="{{ $color }}">
                
                <table class="table table-striped table-bordered spanish-simple">

                    <thead>
                        <tr>
                            <th><small>FOLIO</small></th>
                            <th><small><i class="fa fa-cogs"></i></small></th>
                            <th><small>CLIENTE</small></th>
                            @if($status == 'factura') <th style="text-align: center"><small>MÉTODO</small></th> @endif
                            <th style="text-align: right"><small>IVA</small></th>
                            <th style="text-align: right"><small>IMPORTE</small></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($ingresses as $ingress)
                            <tr>
                                <td style="width: 10%">
                                    @if($ingress->invoice_id == null && $ingress->pay_method == 'efectivo' && $status == 'efectivo')
                                        <input type="checkbox" name="sales[]" value="{{ $ingress->id }}" checked>
                                    @elseif($ingress->invoice_id != null)
                                        <span style="color: green;">{!! $ingress->invoice_id == null ? '': "<i class='fa fa-check'></i>" !!}</span>
                                    @endif
                                    {{ $ingress->folio }}
                                </td>
                                <td style="width: 5%">
                                    <dropdown icon="cogs" color="{{ $color }}">
                                        <li>
                                            <a data-toggle="modal" data-target="#ingress-modal" v-on:click="upmodel({{ $ingress->toJson() }})">
                                                <i class="fa fa-eye" aria-hidden="true"></i> Ver productos
                                            </a>
                                        </li>
                                        @if ($ingress->invoice_id)
                                            <li><a href="{{ $ingress->xml }}" target="_blank"><i class="fa fa-file-code"></i> XML</a></li>
                                        @elseif($status != 'efectivo')
                                            <li><a data-toggle="modal" data-target="#invoice-modal" v-on:click="upmodel({{ $ingress->toJson() }})"><i class="fa fa-plus"></i> Agregar FI</a></li>
                                        @endif
                                    </dropdown>
                                </td>
                                <td>
                                    {{ $ingress->client->name }}
                                </td>
                                @if($status == 'factura') <td style="text-align: center">{{ ucfirst($ingress->pay_method) }}</td> @endif
                                <td style="text-align: right">{{ number_format($ingress->iva, 2) }}</td>
                                <td style="text-align: right">{{ number_format($ingress->amount, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>

                    <tfoot>
                        <tr>
                            <th colspan="{{ $status == 'factura' ? '4': '3' }}"></th>
                            <th style="text-align: right;"><small>TOTAL</small></th>
                            <th style="text-align: right;">{{ number_format($ingresses->sum('amount'), 2) }}</th>
                        </tr>
                    </tfoot> 
                </table>

                @if($status == 'efectivo' && $ingresses->count() != 0)

                    <a href="" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal-cash" title="AGREGAR FI">
                        <i class="fa fa-file-invoice-dollar fa-2x"></i>
                    </a>

                    {{-- {!! Form::open(['method' => 'POST', 'route' => 'coffee.invoice.create', 'files' => 'true']) !!} --}}
                    <modal title="Agregar datos de la facturación" id="modal-cash" color="{{ $color }}">

                        <div class="row">
                            <div class="col-md-4 col-md-offset-4">
                                {!! Field::number('invoice_id', 
                                    ['label' => 'Agregar FI', 'tpl' => 'withicon', 'ph' => 'XXXXXXXXX', 'required' => 'true'], 
                                    ['icon' => 'file-invoice']) 
                                !!}
                                <input type="hidden" name="thisDate" value="{{ $date }}">
                                {{-- <input type="hidden" name="sales" :value="checked"> --}}
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-2 col-md-offset-5">
                                <file-upload bname=" SUBIR XML" fname="xml" ext="xml" color="danger"></file-upload>
                            </div>
                        </div>

                        <template slot="footer">
                            {!! Form::submit('Guardar', ['class' => "btn btn-$color pull-right"]) !!}
                        </template>
                    </modal>
                    

                @endif

            </solid-box>
            
            {!! Form::close() !!}

            <modal title="Productos" color="{{ $color }}" id="ingress-modal">
                <movements :model="model"></movements>
            </modal>

            {!! Form::open(['method' => 'POST', 'route' => 'coffee.invoice.create', 'files' => 'true']) !!}

                <modal title="Agregar datos de la facturación" id="invoice-modal" color="{{ $color }}">

                    <div class="row">
                        <div class="col-md-4 col-md-offset-4">
                            {!! Field::number('invoice_id', 
                                ['label' => 'Agregar FI','tpl' => 'withicon', 'ph' => 'XXXXXXXXX', 'required' => 'true'], 
                                ['icon' => 'file-invoice']) 
                            !!}
                            <input type="hidden" name="thisDate" value="{{ $date }}">
                        </div>
                    </div>
                    <input type="hidden" name="sales[]" :value="model.id">
                    <br>
                    <div class="row">
                        <div class="col-md-2 col-md-offset-5">
                            <file-upload fname="xml" ext="xml" color="danger" bname=" SUBIR XML"></file-upload>
                        </div>
                    </div>
                    


                    <template slot="footer">
                        {!! Form::submit('Guardar', ['class' => "btn btn-$color pull-right"]) !!}
                    </template>
                </modal>

                {!! Form::close() !!}
        </div>


        <div class="col-md-3">
            <money-box color="success" icon="fas fa-clock">
                Total <br>
                <b>$ {{ number_format($payments->sum('amount'), 2) }}</b>
            </money-box>

            <money-box color="warning" icon="far fa-money-bill-alt">
                Efectivo <br>
                <b>$ {{ number_format($payments->sum(function ($ingress) { return $ingress->payments->sum('cash');}), 2) }}</b>
            </money-box>

            <money-box color="warning" icon="fa fa-credit-card">
                T. Débito <br>
                <b>$ {{ number_format($payments->sum(function ($ingress) { return $ingress->payments->sum('debit_card');}), 2) }}</b>
            </money-box>

            <money-box color="warning" icon="fab fa-cc-visa">
                T. Crédito <br>
                <b>$ {{ number_format($payments->sum(function ($ingress) { return $ingress->payments->sum('credit_card');}), 2) }}</b>
            </money-box>

            <money-box color="warning" icon="fas fa-exchange-alt">
                Transferencia <br>
                <b>$ {{ number_format($payments->sum(function ($ingress) { return $ingress->payments->sum('transfer');}), 2) }}</b>
            </money-box>

            <money-box color="warning" icon="fas fa-money-check-alt">
                Cheque <br>
                <b>$ {{ number_format($payments->sum(function ($ingress) { return $ingress->payments->sum('check');}), 2) }}</b>
            </money-box>
        </div>
    </div>

@endsection
