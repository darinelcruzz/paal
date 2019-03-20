@extends('coffee.root')

@push('pageTitle')
    Facturas
@endpush

@section('content')
    <div class="row">
            
        <div class="col-md-12">

            {!! Form::open(['method' => 'post', 'route' => 'coffee.admin.invoices']) !!}
                
                <div class="row">
                    <div class="col-md-3">
                        <div class="input-group input-group-sm">
                            <input type="month" name="date" class="form-control" value="{{ $date }}">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-danger btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </div>
                </div>

            {!! Form::close() !!}

            <br>
        </div>
    </div>

    <div class="row">
        
        <div class="col-md-9">

            <solid-box title="FACTURAS" color="danger">
                
                <data-table example="1">

                    {{ drawHeader('FI', 'método', 'cliente', 'XML', 'referencia', 'IVA', 'Importe') }}

                    <template slot="body">

                        @php
                            $pending = 0
                        @endphp

                        @foreach($invoices as $invoice => $sales)
                            <tr>
                                <td>{{ $invoice }}</td>
                                <td>{{ $sales->first()->method_name }}</td>
                                <td>{{ $sales->first()->client->name }}</td>
                                <td>
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
                                <td>$ {{ number_format($sales->sum('iva'), 2) }}</td>
                                <td>$ {{ number_format($sales->sum('amount'), 2) }}</td>
                            </tr>
                        @endforeach
                    </template>
                    
                </data-table>

            </solid-box>
        </div>

        <div class="col-md-3">
            <money-box color="warning" icon="fas fa-piggy-bank">
                POR DEPOSITAR <br>
                <b>$ {{ number_format($pending, 2) }}</b>
            </money-box>
        </div>
    </div>

@endsection