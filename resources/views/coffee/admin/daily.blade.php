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
                                <button type="submit" class="btn btn-warning btn-flat"><i class="fa fa-search"></i></button>
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
                
                <table class="table table-striped table-bordered">

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
                        @if($status == 'tarjeta')
                         @php
                         $ingresses1 = $ingresses->where('method', 'tarjeta débito');
                         $ingresses2 = $ingresses->where('method', 'tarjeta crédito');
                         @endphp
                         <tr>
                             <th colspan="5" style="text-align: center;"><small>DÉBITO</small></th>
                         </tr>
                        @else
                            @php
                            $ingresses1 = $ingresses;
                            $ingresses2 = [];
                            @endphp
                        @endif
                        @foreach($ingresses1 as $ingress)
                            <tr>
                                <td style="width: 10%">
                                    @if($ingress->invoice_id == null && $ingress->pay_method == 'efectivo' && $status == 'efectivo')
                                        <input type="checkbox" name="sales[]" value="{{ $ingress->id }}" checked>
                                    @elseif($ingress->invoice_id != null || $ingress->pinvoice_id != null)
                                        <span style="color: green;"><i class='fa fa-check'></i></span>
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
                                        @if ($ingress->invoice_id || $ingress->pinvoice_id)
                                            {{-- <li><a href="{{ $ingress->xml }}" target="_blank"><i class="fa fa-file-code"></i> XML</a></li> --}}
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
                        @if(count($ingresses1) > 0 && $status == 'tarjeta')
                        <tr>
                            <th colspan="3"></th>
                            <th style="text-align: right;"><small><em>TOTAL DÉBITO</em></small></th>
                            <th style="text-align: right;">{{ number_format($ingresses1->sum('amount'), 2) }}</th>
                        </tr>
                        @endif()

                        @forelse($ingresses2 as $ingress)
                            @if($loop->index == 0)
                            <tr>
                                 <th colspan="5" style="text-align: center;"><small>CRÉDITO</small></th>
                             </tr>
                            @endif
                            <tr>
                                <td style="width: 10%">
                                    @if($ingress->invoice_id == null && $ingress->pay_method == 'efectivo' && $status == 'efectivo')
                                        <input type="checkbox" name="sales[]" value="{{ $ingress->id }}" checked>
                                    @elseif($ingress->invoice_id != null || $ingress->pinvoice_id != null)
                                        <span style="color: green;"><i class='fa fa-check'></i></span>
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
                                        @if ($ingress->invoice_id || $ingress->pinvoice_id)
                                            {{-- <li><a href="{{ $ingress->xml }}" target="_blank"><i class="fa fa-file-code"></i> XML</a></li> --}}
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
                        @empty
                        @endforelse

                        @if(count($ingresses2) > 0)
                        <tr>
                            <th colspan="3"></th>
                            <th style="text-align: right;"><small><em>TOTAL CRÉDITO</em></small></th>
                            <th style="text-align: right;">{{ number_format($ingresses2->sum('amount'), 2) }}</th>
                        </tr>
                        @endif()
                    </tbody>

                    <tfoot>
                        <tr>
                            <th colspan="{{ $status == 'factura' ? '4': '3' }}"></th>
                            <th style="text-align: right;"><small>TOTAL</small></th>
                            <th style="text-align: right;">{{ number_format($ingresses->sum(function ($ingress) { return $ingress->payments->sum(function ($py) { return $py->cash + $py->debit_card + $py->credit_card + $py->transfer + $py->check; }); }), 2) }}</th>
                        </tr>
                    </tfoot> 
                </table>

                @if($status == 'efectivo' && $ingresses->count() != 0)

                    <a href="" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal-cash" title="AGREGAR FI">
                        <i class="fa fa-file-invoice-dollar fa-2x"></i>
                    </a>

                    <a href="{{ route('coffee.analysis.show', $date) }}" class="btn btn-default btn-sm" title="TODOS LOS PRODUCTOS" target="_blank">
                        <i class="fa fa-print fa-2x"></i>
                    </a>

                    <modal title="Agregar datos de la facturación" id="modal-cash" color="{{ $color }}">

                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                {!! Field::number('invoice_id', ['label' => 'Agregar FI','tpl' => 'withicon', 'ph' => '010101'], ['icon' => 'file-invoice']) !!}
                                {{-- {!! Field::number('pinvoice_id', ['label' => 'Agregar PI','tpl' => 'withicon', 'ph' => '010101'], ['icon' => 'file-excel']) !!}
                                {!! Field::number('pi_amount', 0, ['label' => 'Monto PI', 'tpl' => 'withicon'], ['icon' => 'usd']) !!} --}}
                                <input type="hidden" name="thisDate" value="{{ $date }}">
                            </div>
                            {{-- <div class="col-md-2">
                                &nbsp;<br>
                                <file-upload fname="xml" ext="xml" color="{{ $color }}" bname="fi.xml"></file-upload>
                                &nbsp;<br>
                                <file-upload fname="pi_xml" ext="xml" color="{{ $color }}" bname="pi.xml"></file-upload>                            
                            </div> --}}
                        </div>
                        {{-- <input type="hidden" name="sales[]" :value="model.id"> --}}

                        <template slot="footer">
                            {!! Form::submit('Guardar', ['class' => "btn btn-$color pull-right"]) !!}
                        </template>
                    </modal>
                    

                @endif

            </solid-box>
            
            {!! Form::close() !!}

            <modal :title="model.folio ?? ''" color="{{ $color }}" id="ingress-modal">
                <movements :model="model" type="ingress"></movements>
            </modal>

            {!! Form::open(['method' => 'POST', 'route' => 'coffee.invoice.create', 'files' => 'true']) !!}

                <modal title="Agregar datos de la facturación" id="invoice-modal" color="{{ $color }}">

                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            {!! Field::number('invoice_id', ['label' => 'Agregar FI','tpl' => 'withicon', 'ph' => '010101'], ['icon' => 'file-invoice']) !!}
                            {{-- {!! Field::number('pinvoice_id', ['label' => 'Agregar PI','tpl' => 'withicon', 'ph' => '010101'], ['icon' => 'file-excel']) !!}
                            {!! Field::number('pi_amount', 0, ['label' => 'Monto PI', 'tpl' => 'withicon'], ['icon' => 'usd']) !!} --}}
                            <input type="hidden" name="thisDate" value="{{ $date }}">
                        </div>
                        {{-- <div class="col-md-2">
                            &nbsp;<br>
                            <file-upload fname="xml" ext="xml" color="{{ $color }}" bname="fi.xml"></file-upload>
                            &nbsp;<br>
                            <file-upload fname="pi_xml" ext="xml" color="{{ $color }}" bname="pi.xml"></file-upload>                            
                        </div> --}}
                    </div>
                    <input type="hidden" name="sales[]" :value="model.id">
                    <br>

                    <template slot="footer">
                        {!! Form::submit('Guardar', ['class' => "btn btn-$color pull-right"]) !!}
                    </template>
                </modal>

            {!! Form::close() !!}
        </div>


        <div class="col-md-3">
            <money-box color="success" icon="fas fa-clock">
                Total <br>
                <b>{{ number_format($payments->sum(function ($ingress) { return $ingress->payments->sum(function ($py) { return $py->cash + $py->debit_card + $py->credit_card + $py->transfer + $py->check; }); }) + $notes->sum('amount'), 2) }}</b>
            </money-box>

            <money-box color="warning" icon="far fa-money-bill-alt">
                Efectivo <br>
                <b>{{ number_format($payments->sum(function ($ingress) { return $ingress->payments->sum('cash');}) + $notes->where('method', 'efectivo')->sum('amount'), 2) }}</b>
            </money-box>

            <money-box color="warning" icon="fa fa-credit-card">
                T. Débito <br>
                <b>{{ number_format($payments->sum(function ($ingress) { return $ingress->payments->sum('debit_card');}) + $notes->where('method', 'tarjeta débito')->sum('amount'), 2) }}</b>
            </money-box>

            <money-box color="warning" icon="fab fa-cc-visa">
                T. Crédito <br>
                <b>{{ number_format($payments->sum(function ($ingress) { return $ingress->payments->sum('credit_card');}) + $notes->where('method', 'tarjeta crédito')->sum('amount'), 2) }}</b>
            </money-box>

            <money-box color="warning" icon="fas fa-exchange-alt">
                Transferencia <br>
                <b>{{ number_format($payments->sum(function ($ingress) { return $ingress->payments->sum('transfer');}) + $notes->where('method', 'transferencia')->sum('amount'), 2) }}</b>
            </money-box>

            <money-box color="warning" icon="fas fa-money-check-alt">
                Cheque <br>
                <b>{{ number_format($payments->sum(function ($ingress) { return $ingress->payments->sum('check');}) + $notes->where('method', 'cheque')->sum('amount'), 2) }}</b>
            </money-box>
        </div>
    </div>

@endsection
