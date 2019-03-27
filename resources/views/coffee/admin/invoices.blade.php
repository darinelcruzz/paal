@extends('coffee.root')

@push('pageTitle')
    Facturas
@endpush

@section('content')

    <div class="row">
        
        <div class="col-md-9">

            <solid-box title="{{ strtoupper(fdate($date, 'l d \d\e F', 'Y-m-d')) }}" color="danger">
                
                <data-table example="1">

                    {{ drawHeader('FI', 'método', 'cliente', 'XML', 'referencia', 'IVA', 'Importe') }}

                    <template slot="body">

                        @php
                            $pending = 0;
                            $amount = 0;
                        @endphp

                        @foreach($invoices as $invoice => $sales)
                            <tr>
                                <td>{{ $invoice }}</td>
                                <td>{{ $sales->first()->method_name }}</td>
                                <td style="width: 35%">{{ $sales->first()->client->name }}</td>
                                <td style="width: 5%; text-align: center;">
                                    <a href="{{ $sales->first()->xml }}" target="_blank" style="color: green">
                                        <i class="fa fa-file-excel"></i>
                                    </a>
                                </td>
                                <td style="text-align: center">
                                    @if (!$sales->first()->reference)
                                        <a href="" data-toggle="modal" data-target="#details{{ $invoice }}">
                                            <em>agregar...</em>
                                        </a>

                                        @php
                                            $pending += $sales->sum('amount')
                                        @endphp

                                        {!! Form::open(['method' => 'POST', 'route' => 'coffee.admin.reference']) !!}
                                
                                        <modal title="Agregar referencia del depósito" id="details{{ $invoice }}" color="#dd4b39">

                                            <div class="row">
                                                <div class="col-md-4 col-md-offset-4">
                                                    {!! Field::text('reference', 
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
                                        {{ $sales->first()->reference }}
                                    @endif
                                </td>
                                <td style="text-align: right; width: 10%">$ {{ number_format($sales->sum('iva'), 2) }}</td>
                                <td style="text-align: right;">$ {{ number_format($sales->sum('amount'), 2) }}</td>
                            </tr>
                            @php
                                $amount += $sales->sum('amount')
                            @endphp
                        @endforeach
                    </template>

                    <template slot="footer">
                        <tr>
                            <td colspan="5"></td>
                            <th style="text-align: right; width: 10%">Total</th>
                            <td style="text-align: right;">$ {{ number_format($amount, 2) }}</td>
                        </tr>
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
                {{-- <div class="icon">
                    <i class="fa fa-piggy-bank"></i>
                </div> --}}
            </div>
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


        </div>
    </div>

@endsection