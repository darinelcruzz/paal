@extends('coffee.root')

@push('pageTitle')
    Admin
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
                
                <data-table example="1">

                    {{ drawHeader('folio', '<i class="fa fa-cogs"></i>', 'fecha venta', 'cliente', 'estado', 'IVA', 'total') }}

                    <template slot="body">
                        @php
                            $total = 0
                        @endphp

                        @foreach($invoiced as $ingress)
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
                                                    <i class="fa fa-plus"></i> Facturar
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

                                    {!! Form::open(['method' => 'POST', 'route' => ['coffee.ingress.invoice', $ingress ], 'files' => 'true']) !!}
                                    
                                    <modal title="Agregar datos de la facturación" id="modal-f{{ $ingress->id }}" color="#dd4b39">

                                        <div class="row">
                                            <div class="col-md-4 col-md-offset-4">
                                                {!! Field::number('invoice_id', 
                                                    ['tpl' => 'withicon', 'ph' => 'XXXXXXXXX', 'required' => 'true'], 
                                                    ['icon' => 'file-invoice']) 
                                                !!}
                                            </div>
                                        </div>
                                        <br>
                                        @if($ingress->method == 'cash')
                                            <div class="row">
                                                <div class="col-md-4 col-md-offset-4">
                                                    {!! Field::number('reference', 
                                                        ['tpl' => 'withicon', 'ph' => 'XXXXXXXXX', 'required' => 'true'], 
                                                        ['icon' => 'exchange-alt']) 
                                                    !!}
                                                </div>
                                            </div>
                                            <br>
                                        @endif
                                        <div class="row">
                                            <div class="col-md-2 col-md-offset-5">
                                                <file-upload fname="xml" ext="xml" color="danger"></file-upload>
                                            </div>
                                        </div>
                                        


                                        <template slot="footer">
                                            {!! Form::submit('Guardar', ['class' => 'btn btn-danger pull-right']) !!}
                                        </template>
                                    </modal>

                                    {!! Form::close() !!}
                                </td>
                                <td>{{ fdate($ingress->bought_at, 'd M Y', 'Y-m-d') }}</td>
                                <td>{{ $ingress->client->name }}</td>
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

            <solid-box title="EFECTIVO SIN FACTURA" color="default" button collapsed>

                {!! Form::open(['method' => 'POST', 'route' => 'coffee.ingress.invoices', 'files' => 'true']) !!}
                
                <data-table example="2">

                    {{ drawHeader('folio', '<i class="fa fa-eye"></i>', 'fecha venta', 'cliente', 'estado', 'IVA', 'total') }}

                    <template slot="body">
                        @php
                            $total = 0;
                            $sales = [];
                        @endphp

                        @foreach($paid as $ingress)
                            @if ($ingress->method == 'cash')
                            <tr>
                                <td>
                                    {{ $ingress->folio }}
                                    <input type="hidden" name="sales[]" value="{{ $ingress->id }}">
                                </td>
                                <td>
                                    <a href="" data-toggle="modal" data-target="#modal-e{{ $ingress->id }}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <modal title="Lista de productos" id="modal-e{{ $ingress->id }}" color="#97a1b3">
                                        <sale-products-list sale="{{ $ingress->id }}" 
                                            amount="{{ $ingress->amount }}"
                                            iva="{{ $ingress->iva }}">
                                        </sale-products-list>
                                    </modal>
                                </td>
                                <td>{{ fdate($ingress->bought_at, 'd M Y', 'Y-m-d') }}</td>
                                <td>{{ $ingress->client->name }}</td>
                                <td>
                                    <span class="label label-{{ $ingress->statusColor }}">
                                        {{ ucfirst($ingress->status) }}
                                    </span>
                                </td>
                                <td>$ {{ number_format($ingress->iva, 2) }}</td>
                                <td>$ {{ number_format($ingress->amount, 2) }}</td>
                            </tr>
                            @php
                                $total += $ingress->amount;
                                array_push($sales, $ingress->id);
                            @endphp
                            @endif
                        @endforeach
                    </template>

                    <template slot="footer">
                        <tr>
                            <td>
                                @if(isset($ingress))
                                    @if ($ingress->invoice_id)
                                        <a href="{{ $ingress->xml }}" class="btn btn-success btn-xs" target="_blank">
                                            <i class="fa fa-file-code"></i> XML
                                        </a>
                                    @else
                                        <a href="" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-cash">
                                            <i class="fa fa-file"></i>&nbsp; FACTURAR
                                        </a>
                                    @endif
                                @endif

                                <modal title="Agregar datos de la facturación" id="modal-cash" color="#dd4b39">

                                    <div class="row">
                                        <div class="col-md-4 col-md-offset-4">
                                            {!! Field::number('invoice_id', 
                                                ['tpl' => 'withicon', 'ph' => 'XXXXXXXXX', 'required' => 'true'], 
                                                ['icon' => 'file-invoice']) 
                                            !!}
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-4 col-md-offset-4">
                                            {!! Field::number('reference', 
                                                ['tpl' => 'withicon', 'ph' => 'XXXXXXXXX', 'required' => 'true'], 
                                                ['icon' => 'exchange-alt']) 
                                            !!}
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-2 col-md-offset-5">
                                            <file-upload fname="xml" ext="xml" color="danger"></file-upload>
                                        </div>
                                    </div>

                                    <template slot="footer">
                                        {!! Form::submit('Guardar', ['class' => 'btn btn-danger pull-right']) !!}
                                    </template>
                                </modal>
                                
                            </td>
                            <td colspan="4"></td>
                            <th>Total</th>
                            <td>$ {{ number_format($total, 2) }}</td>
                        </tr>
                    </template>

                    {!! Form::close() !!}
                    
                </data-table>

            </solid-box>

            <solid-box title="TARJETA SIN FACTURA" color="danger" button collapsed>
                
                <data-table example="3">

                    {{ drawHeader('folio', '<i class="fa fa-cogs"></i>', 'fecha venta', 'cliente', 'estado', 'IVA', 'total') }}

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
                                                    <i class="fa fa-plus"></i> Facturar
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

                                    {!! Form::open(['method' => 'POST', 'route' => ['coffee.ingress.invoice', $ingress ], 'files' => 'true']) !!}
                                    
                                    <modal title="Agregar datos de la facturación" id="modal-f{{ $ingress->id }}" color="#dd4b39">

                                        <div class="row">
                                            <div class="col-md-4 col-md-offset-4">
                                                {!! Field::number('invoice_id', 
                                                    ['tpl' => 'withicon', 'ph' => 'XXXXXXXXX', 'required' => 'true'], 
                                                    ['icon' => 'file-invoice']) 
                                                !!}
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-2 col-md-offset-5">
                                                <file-upload fname="xml" ext="xml" color="danger"></file-upload>
                                            </div>
                                        </div>
                                        


                                        <template slot="footer">
                                            {!! Form::submit('Guardar', ['class' => 'btn btn-danger pull-right']) !!}
                                        </template>
                                    </modal>

                                    {!! Form::close() !!}
                                </td>
                                <td>{{ fdate($ingress->bought_at, 'd M Y', 'Y-m-d') }}</td>
                                <td>{{ $ingress->client->name }}</td>
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
                            <td colspan="5"></td>
                            <th>Total</th>
                            <td>$ {{ number_format($total, 2) }}</td>
                        </tr>
                    </template>
                    
                </data-table>

            </solid-box>

            <solid-box title="TRANSFERENCIA SIN FACTURA" color="default" button collapsed>
                
                <data-table example="4">

                    {{ drawHeader('folio', '<i class="fa fa-cogs"></i>', 'fecha venta', 'cliente', 'estado', 'IVA', 'total') }}

                    <template slot="body">
                        @php
                            $total = 0
                        @endphp

                        @foreach($paid as $ingress)
                            @if ($ingress->method == 'transfer')
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
                                                    <i class="fa fa-plus"></i> Facturar
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

                                    {!! Form::open(['method' => 'POST', 'route' => ['coffee.ingress.invoice', $ingress ], 'files' => 'true']) !!}
                                    
                                    <modal title="Agregar datos de la facturación" id="modal-f{{ $ingress->id }}" color="#dd4b39">

                                        <div class="row">
                                            <div class="col-md-4 col-md-offset-4">
                                                {!! Field::number('invoice_id', 
                                                    ['tpl' => 'withicon', 'ph' => 'XXXXXXXXX', 'required' => 'true'], 
                                                    ['icon' => 'file-invoice']) 
                                                !!}
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-2 col-md-offset-5">
                                                <file-upload fname="xml" ext="xml" color="danger"></file-upload>
                                            </div>
                                        </div>
                                        


                                        <template slot="footer">
                                            {!! Form::submit('Guardar', ['class' => 'btn btn-danger pull-right']) !!}
                                        </template>
                                    </modal>

                                    {!! Form::close() !!}
                                </td>
                                <td>{{ fdate($ingress->bought_at, 'd M Y', 'Y-m-d') }}</td>
                                <td>{{ $ingress->client->name }}</td>
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
                            <td colspan="5"></td>
                            <th>Total</th>
                            <td>$ {{ number_format($total, 2) }}</td>
                        </tr>
                    </template>
                    
                </data-table>

            </solid-box>

            <solid-box title="ABONOS Y ANTICIPOS" color="danger" button collapsed>
                
                <data-table example="5">

                    {{ drawHeader('folio','tipo', 'cliente', 'estado', 'cantidad', 'total') }}

                    <template slot="body">
                        @php
                            $total = 0
                        @endphp

                        @foreach($deposits as $deposit)
                            <tr>
                                <td>{{ $deposit->ingress->folio }}</td>
                                <td>{{ ucfirst($deposit->type) }}</td>
                                <td>{{ $deposit->ingress->client->name }}</td>
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
                            <td colspan="4"></td>
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