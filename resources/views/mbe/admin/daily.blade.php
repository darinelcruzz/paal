@extends('mbe.root')

@push('pageTitle')
    Corte diario
@endpush

@section('content')
    <div class="row">
        
        <div class="col-md-9">

            {!! Form::open(['method' => 'post', 'route' => ['mbe.ingress.daily', $status]]) !!}
                
                <div class="row">
                    <div class="col-md-3">
                        <div class="input-group input-group-sm">
                            <input type="date" name="date" class="form-control" value="{{ $date }}">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </div>
                    {{-- <div class="col-md-9">
                        <a href="{{ route('mbe.ingress.daily', ['factura', $date]) }}" class="btn btn-primary">CON FACTURA</a>
                        <a href="{{ route('mbe.ingress.daily', ['efectivo', $date]) }}" class="btn btn-success">EFECTIVO S/F</a>
                        <a href="{{ route('mbe.ingress.daily', ['tarjeta', $date]) }}" class="btn btn-warning">TARJETA S/F</a>
                        <a href="{{ route('mbe.ingress.daily', ['transferencia', $date]) }}" class="btn btn-info">TRANSFERENCIA S/F</a>
                    </div> --}}
                </div>

            {!! Form::close() !!}

            <br>

            <solid-box title="Ingresos" color="{{ $color }}">
                
                <data-table>

                    {{ drawHeader('FI/OT', '<i class="fa fa-cogs"></i>', 'cliente', 'método', 'IVA', 'total') }}

                    <template slot="body">
                        @foreach($ingresses as $ingress)
                            <tr>
                                <td style="width: 7%">{{ $ingress->folio == '0' ? $ingress->invoice_id: $ingress->folio }}</td>
                                <td style="width: 5%">
                                    @include('mbe.admin._options')
                                </td>
                                <td>
                                    {{ $ingress->client->name }}
                                    <span style="color: green;">{!! $ingress->invoice_id ? "<i class='fa fa-check'></i>": '' !!}</span>
                                </td>
                                <td>{{ strtoupper($ingress->method) }}</td>
                                <td>$ {{ number_format($ingress->iva, 2) }}</td>
                                <td style="text-align: right">$ {{ number_format($ingress->amount, 2) }}</td>
                            </tr>
                        @endforeach
                    </template>

                    <template slot="footer">
                        <tr>
                            <th colspan="4"></th>
                            <th>Total</th>
                            <th style="text-align: right">$ {{ number_format($ingresses->sum('amount'), 2) }}</th>
                        </tr>
                    </template>    
                </data-table>

                {{-- @if($status == 'efectivo' && $ingresses->count() != 0)

                    @if ($ingress->invoice_id == null)
                        <a href="" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal-cash" title="AGREGAR FI">
                            <i class="fa fa-file-invoice-dollar fa-2x"></i>
                        </a>
                    @else
                        <a href="{{ $ingress->xml }}" class="btn btn-success btn-sm" target="_blank">
                            <i class="fa fa-file-code"></i> XML
                        </a>
                    @endif

                    {!! Form::open(['method' => 'POST', 'route' => 'mbe.invoice.create', 'files' => 'true']) !!}
                    <modal title="Agregar datos de la facturación" id="modal-cash" color="{{ $color }}">

                        <div class="row">
                            <div class="col-md-4 col-md-offset-4">
                                {!! Field::number('invoice_id', 
                                    ['label' => 'Agregar FI', 'tpl' => 'withicon', 'ph' => 'XXXXXXXXX', 'required' => 'true'], 
                                    ['icon' => 'file-invoice']) 
                                !!}
                                <input type="hidden" name="thisDate" value="{{ $date }}">
                                
                                @foreach($ingresses->pluck('id') as $ingress_id)
                                    <input type="hidden" name="sales[]" value="{{ $ingress_id }}">
                                @endforeach
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
                    {!! Form::close() !!}

                @endif --}}

            </solid-box>
        </div>


        <div class="col-md-3">
            <money-box color="success" icon="fas fa-clock">
                Total <br>
                <b>$ {{ number_format($ingresses_to_filter->sum('amount'), 2) }}</b>
            </money-box>

            <money-box color="warning" icon="far fa-money-bill-alt">
                Efectivo <br>
                <b>$ {{ number_format($ingresses_to_filter->where('method', 'efectivo')->sum('amount'), 2) }}</b>
            </money-box>

            <money-box color="warning" icon="fa fa-credit-card">
                T. Débito <br>
                <b>$ {{ number_format($ingresses_to_filter->where('method', 'tarjeta débito')->sum('amount'), 2) }}</b>
            </money-box>

            <money-box color="warning" icon="fab fa-cc-visa">
                T. Crédito <br>
                <b>$ {{ number_format($ingresses_to_filter->where('method', 'tarjeta crédito')->sum('amount'), 2) }}</b>
            </money-box>

            <money-box color="warning" icon="fas fa-exchange-alt">
                Transferencia <br>
                <b>$ {{ number_format($ingresses_to_filter->where('method', 'transferencia')->sum('amount'), 2) }}</b>
            </money-box>

            <money-box color="warning" icon="fas fa-money-check-alt">
                Cheque <br>
                <b>$ {{ number_format($ingresses_to_filter->where('method', 'cheque')->sum('amount'), 2) }}</b>
            </money-box>
        </div>
    </div>

@endsection