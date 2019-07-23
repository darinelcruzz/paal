@extends('coffee.root')

@push('pageTitle')
    Corte diario
@endpush

@section('content')
    <div class="row">
        
        <div class="col-md-9">

            {!! Form::open(['method' => 'post', 'route' => 'coffee.admin.index']) !!}
                
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

            <solid-box title="CON FACTURA" color="danger" button collapsed>
                
                <data-table>

                    {{ drawHeader('folio', '<i class="fa fa-cogs"></i>', 'cliente', 'estado', 'IVA', 'total') }}

                    <template slot="body">
                        @php
                            $total = $invoiced->sum('amount')
                        @endphp

                        @each('coffee.admin.sales', $invoiced, 'sale')

                    </template>

                    <template slot="footer">
                        <tr>
                            <td colspan="4"></td>
                            <th>Total</th>
                            <td>$ {{ number_format($total, 2) }}</td>
                        </tr>
                    </template>
                    
                </data-table>

            </solid-box>

            <solid-box title="EFECTIVO SIN FACTURA" color="default" button collapsed>

                {!! Form::open(['method' => 'POST', 'route' => 'coffee.invoice.create', 'files' => 'true']) !!}
                
                <data-table example="2">

                    {{ drawHeader('folio', '<i class="fa fa-eye"></i>', 'cliente', 'estado', 'IVA', 'total') }}

                    <template slot="body">
                        @php
                            $total = 0;
                            $last_of_these = null;
                        @endphp

                        @foreach($paid as $paid_in_cash)
                            @if ($paid_in_cash->method == 'cash')
                                <tr>
                                    <td>
                                        {{ $paid_in_cash->folio }}
                                        <input type="hidden" name="sales[]" value="{{ $paid_in_cash->id }}">
                                    </td>
                                    <td>
                                        <a href="" data-toggle="modal" data-target="#modal-e{{ $paid_in_cash->id }}">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <modal title="Lista de productos" id="modal-e{{ $paid_in_cash->id }}" color="#97a1b3">
                                            <sale-products-list sale="{{ $paid_in_cash->id }}" 
                                                amount="{{ $paid_in_cash->amount }}"
                                                iva="{{ $paid_in_cash->iva }}">
                                            </sale-products-list>
                                        </modal>
                                    </td>
                                    
                                    <td>
                                        {{ $paid_in_cash->client->name }}
                                        <span class="pull-right" style="color: green">{!! $paid_in_cash->invoice_id ? '<i class="fa fa-check"></i>': '' !!}</span>
                                    </td>
                                    <td>
                                        <span class="label label-{{ $paid_in_cash->statusColor }}">
                                            {{ ucfirst($paid_in_cash->status) }}
                                        </span>
                                    </td>
                                    <td>$ {{ number_format($paid_in_cash->iva, 2) }}</td>
                                    <td>$ {{ number_format($paid_in_cash->amount, 2) }}</td>
                                </tr>
                                @php
                                    $total += $paid_in_cash->amount;
                                    $last_of_these = $paid_in_cash;
                                @endphp
                            @endif
                        @endforeach
                    </template>

                    <template slot="footer">
                        <tr>
                            <td>
                                @if($paid->count() > 0 && $last_of_these)
                                    @if ($last_of_these->invoice_id == null)
                                        <a href="" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-cash">
                                            <i class="fa fa-file"></i>&nbsp; AGREGAR FI 
                                        </a>
                                    @else
                                        <a href="{{ $last_of_these->xml }}" class="btn btn-success btn-xs" target="_blank">
                                            <i class="fa fa-file-code"></i> XML
                                        </a>
                                    @endif
                                @endif

                                <modal title="Agregar datos de la facturación" id="modal-cash" color="#dd4b39">

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
                                        {!! Form::submit('Guardar', ['class' => 'btn btn-danger pull-right']) !!}
                                    </template>
                                </modal>
                                
                            </td>
                            <td colspan="3"></td>
                            <th>Total</th>
                            <td>$ {{ number_format($total, 2) }}</td>
                        </tr>
                    </template>

                    {!! Form::close() !!}
                    
                </data-table>

            </solid-box>

            <solid-box title="TARJETA SIN FACTURA" color="danger" button collapsed>
                
                <data-table example="3">

                    {{ drawHeader('folio', '<i class="fa fa-cogs"></i>', 'cliente', 'estado', 'IVA', 'total') }}

                    <template slot="body">
                        @php
                            $total = 0
                        @endphp

                        @foreach($paid as $ingress)
                            @if ($ingress->method == 'credit_card' || $ingress->method == 'debit_card')
                            <tr>
                                <td>{{ $ingress->folio }}</td>
                                <td>
                                    <dropdown icon="cogs" color="danger">
                                        <li>
                                            <a href="" data-toggle="modal" data-target="#modal-e{{ $ingress->id }}">
                                                <i class="fa fa-eye"></i> Detalles
                                            </a>
                                        </li>
                                        @if ($ingress->invoice_id)
                                            <li>
                                                <a href="{{ $ingress->xml }}" target="_blank">
                                                    <i class="fa fa-file-code"></i> XML
                                                </a>
                                            </li>
                                        @else
                                            <li>
                                                <a href="" data-toggle="modal" data-target="#modal-f{{ $ingress->id }}">
                                                    <i class="fa fa-plus"></i> Agregar FI
                                                </a>
                                            </li>
                                        @endif
                                    </dropdown>

                                    <modal title="Lista de productos" id="modal-e{{ $ingress->id }}">
                                        <sale-products-list sale="{{ $ingress->id }}" 
                                            amount="{{ $ingress->amount }}"
                                            iva="{{ $ingress->iva }}">
                                        </sale-products-list>
                                    </modal>

                                    {!! Form::open(['method' => 'POST', 'route' => 'coffee.invoice.create', 'files' => 'true']) !!}
                                    
                                    <modal title="Agregar datos de la facturación" id="modal-f{{ $ingress->id }}" color="#dd4b39">

                                        <div class="row">
                                            <div class="col-md-4 col-md-offset-4">
                                                {!! Field::number('invoice_id', 
                                                    ['tpl' => 'withicon', 'ph' => 'XXXXXXXXX', 'required' => 'true'], 
                                                    ['icon' => 'file-invoice']) 
                                                !!}
                                            </div>
                                        </div>

                                        <input type="hidden" name="sales[]" value="{{ $ingress->id }}">

                                        <div class="row">
                                            <div class="col-md-2 col-md-offset-5">
                                                <file-upload bname=" SUBIR XML" fname="xml" ext="xml" color="danger"></file-upload>
                                            </div>
                                        </div>
                                        


                                        <template slot="footer">
                                            {!! Form::submit('Guardar', ['class' => 'btn btn-danger pull-right']) !!}
                                        </template>
                                    </modal>

                                    {!! Form::close() !!}
                                </td>
                                
                                <td>
                                    {{ $ingress->client->name }}
                                    <span class="pull-right" style="color: green">{!! $ingress->invoice_id ? '<i class="fa fa-check"></i>': '' !!}</span>
                                </td>
                                <td>
                                    <span class="label label-{{ $ingress->statusColor }}">
                                        {{ ucfirst($ingress->status) }}
                                    </span>
                                </td>
                                <td>$ {{ number_format($ingress->iva, 2) }}</td>
                                <td>$ {{ number_format($ingress->amount, 2) }}</td>
                            </tr>
                            @php
                                $total += $ingress->amount
                            @endphp
                            @endif
                        @endforeach
                    </template>

                    <template slot="footer">
                        <tr>
                            <td colspan="4"></td>
                            <th>Total</th>
                            <td>$ {{ number_format($total, 2) }}</td>
                        </tr>
                    </template>
                    
                </data-table>

            </solid-box>

            <solid-box title="TRANSFERENCIA SIN FACTURA" color="default" button collapsed>
                
                <data-table example="4">

                    {{ drawHeader('folio', '<i class="fa fa-cogs"></i>', 'cliente', 'estado', 'IVA', 'total') }}

                    <template slot="body">
                        @php
                            $total = 0
                        @endphp

                        @foreach($paid as $ingress)
                            @if ($ingress->method == 'transfer')
                            <tr>
                                <td>{{ $ingress->folio }}</td>
                                <td>
                                    <dropdown icon="cogs" color="default">
                                        <li>
                                            <a href="" data-toggle="modal" data-target="#modal-e{{ $ingress->id }}">
                                                <i class="fa fa-eye"></i> Detalles
                                            </a>
                                        </li>
                                        @if ($ingress->invoice_id)
                                            <li>
                                                <a href="{{ $ingress->xml }}" target="_blank">
                                                    <i class="fa fa-file-code"></i> XML
                                                </a>
                                            </li>
                                        @else
                                            <li>
                                                <a href="" data-toggle="modal" data-target="#modal-f{{ $ingress->id }}">
                                                    <i class="fa fa-plus"></i> Agregar FI
                                                </a>
                                            </li>
                                        @endif
                                    </dropdown>

                                    <modal title="Lista de productos" id="modal-e{{ $ingress->id }}">
                                        <sale-products-list sale="{{ $ingress->id }}" 
                                            amount="{{ $ingress->amount }}"
                                            iva="{{ $ingress->iva }}">
                                        </sale-products-list>
                                    </modal>

                                    {!! Form::open(['method' => 'POST', 'route' => 'coffee.invoice.create', 'files' => 'true']) !!}
                                    
                                    <modal title="Agregar datos de la facturación" id="modal-f{{ $ingress->id }}" color="#dd4b39">

                                        <div class="row">
                                            <div class="col-md-4 col-md-offset-4">
                                                {!! Field::number('invoice_id', 
                                                    ['tpl' => 'withicon', 'ph' => 'XXXXXXXXX', 'required' => 'true'], 
                                                    ['icon' => 'file-invoice']) 
                                                !!}
                                            </div>
                                        </div>

                                        <input type="hidden" name="sales[]" value="{{ $ingress->id }}">

                                        <div class="row">
                                            <div class="col-md-2 col-md-offset-5">
                                                <file-upload bname=" SUBIR XML" fname="xml" ext="xml" color="danger"></file-upload>
                                            </div>
                                        </div>
                                        


                                        <template slot="footer">
                                            {!! Form::submit('Guardar', ['class' => 'btn btn-danger pull-right']) !!}
                                        </template>
                                    </modal>

                                    {!! Form::close() !!}
                                </td>
                                
                                <td>
                                    {{ $ingress->client->name }}
                                    <span class="pull-right" style="color: green">{!! $ingress->invoice_id ? '<i class="fa fa-check"></i>': '' !!}</span>
                                </td>
                                <td>
                                    <span class="label label-{{ $ingress->statusColor }}">
                                        {{ ucfirst($ingress->status) }}
                                    </span>
                                </td>
                                <td>$ {{ number_format($ingress->iva, 2) }}</td>
                                <td>$ {{ number_format($ingress->amount, 2) }}</td>
                            </tr>
                            @php
                                $total += $ingress->amount
                            @endphp
                            @endif
                        @endforeach
                    </template>

                    <template slot="footer">
                        <tr>
                            <td colspan="4"></td>
                            <th>Total</th>
                            <td>$ {{ number_format($total, 2) }}</td>
                        </tr>
                    </template>
                    
                </data-table>

            </solid-box>

            <solid-box title="ABONOS Y ANTICIPOS" color="danger" button collapsed>
                
                <data-table example="5">

                    {{ drawHeader('folio', '<i class="fa fa-cogs"></i>', 'tipo', 'cliente', 'estado', 'cantidad', 'total') }}

                    <template slot="body">
                        @php
                            $total = 0
                        @endphp

                        @foreach($deposits as $deposit)
                            <tr>
                                <td>{{ $deposit->ingress->folio }}</td>
                                <td>
                                    @if ($deposit->type == 'liquidación')
                                        <dropdown icon="cogs" color="danger">
                                            <li>
                                                <a href="" data-toggle="modal" data-target="#modal-e{{ $deposit->ingress->id }}">
                                                    <i class="fa fa-eye"></i> Detalles
                                                </a>
                                            </li>
                                            @if ($deposit->ingress->invoice_id)
                                                <li>
                                                    <a href="{{ $deposit->ingress->xml }}" target="_blank">
                                                        <i class="fa fa-file-code"></i> XML
                                                    </a>
                                                </li>
                                            @else
                                                <li>
                                                    <a href="" data-toggle="modal" data-target="#modal-f{{ $deposit->ingress->id }}">
                                                        <i class="fa fa-plus"></i> Agregar FI
                                                    </a>
                                                </li>
                                            @endif
                                        </dropdown>

                                        <modal title="Lista de productos" id="modal-e{{ $deposit->ingress->id }}" color="#dd4b39">
                                            <sale-products-list sale="{{ $deposit->ingress->id }}" 
                                                amount="{{ $deposit->ingress->amount }}"
                                                iva="{{ $deposit->ingress->iva }}">
                                            </sale-products-list>
                                        </modal>

                                        {!! Form::open(['method' => 'POST', 'route' => 'coffee.invoice.create', 'files' => 'true']) !!}
                                    
                                        <modal title="Agregar datos de la facturación" id="modal-f{{ $deposit->ingress->id }}" color="#dd4b39">

                                            <div class="row">
                                                <div class="col-md-4 col-md-offset-4">
                                                    {!! Field::number('invoice_id', 
                                                        ['tpl' => 'withicon', 'ph' => 'XXXXXXXXX', 'required' => 'true'], 
                                                        ['icon' => 'file-invoice']) 
                                                    !!}
                                                </div>
                                            </div>

                                            <input type="hidden" name="sales[]" value="{{ $deposit->ingress->id }}">

                                            <div class="row">
                                                <div class="col-md-2 col-md-offset-5">
                                                    <file-upload bname=" SUBIR XML" fname="xml" ext="xml" color="danger"></file-upload>
                                                </div>
                                            </div>
                                        


                                            <template slot="footer">
                                                {!! Form::submit('Guardar', ['class' => 'btn btn-danger pull-right']) !!}
                                            </template>
                                        </modal>

                                        {!! Form::close() !!}
                                    @endif
                                </td>
                                <td>
                                    {{ ucfirst($deposit->type) }}

                                </td>
                                <td>
                                    {{ $deposit->ingress->client->name }}
                                    <span class="pull-right" style="color: green">{!! $deposit->ingress->invoice_id ? '<i class="fa fa-check"></i>': '' !!}</span>
                                </td>
                                <td>
                                    <span class="label label-{{ $deposit->ingress->statusColor }}">
                                        {{ ucfirst($deposit->ingress->status) }}
                                    </span>
                                </td>
                                <td>{!! $deposit->methods !!}</td>
                                <td>$ {{ number_format($deposit->total, 2) }}</td>
                            </tr>

                            @php
                                $total += $deposit->amount
                            @endphp
                        @endforeach
                    </template>

                    <template slot="footer">
                        <tr>
                            <td colspan="5"></td>
                            <th>Total</th>
                            <td>$ {{ number_format($total, 2) }}</td>
                        </tr>
                    </template>
                    
                </data-table>

            </solid-box>
        </div>


        <div class="col-md-3">
            <money-box color="success" icon="fas fa-clock">
                Total <br>
                <b>$ {{ number_format($payments->sum('cash') + $payments->sum('credit_card') + $payments->sum('debit_card') + $payments->sum('transfer') + $payments->sum('check'), 2) }}</b>
            </money-box>

            <money-box color="warning" icon="far fa-money-bill-alt">
                Efectivo <br>
                <b>$ {{ number_format($payments->sum('cash'), 2) }}</b>
            </money-box>

            <money-box color="warning" icon="fa fa-credit-card">
                T. Débito <br>
                <b>$ {{ number_format($payments->sum('debit_card'), 2) }}</b>
            </money-box>

            <money-box color="warning" icon="fab fa-cc-visa">
                T. Crédito <br>
                <b>$ {{ number_format($payments->sum('credit_Card'), 2) }}</b>
            </money-box>

            <money-box color="warning" icon="fas fa-exchange-alt">
                Transferencia <br>
                <b>$ {{ number_format($payments->sum('transfer'), 2) }}</b>
            </money-box>

            <money-box color="warning" icon="fas fa-money-check-alt">
                Cheque <br>
                <b>$ {{ number_format($payments->sum('check'), 2) }}</b>
            </money-box>
        </div>
    </div>

@endsection