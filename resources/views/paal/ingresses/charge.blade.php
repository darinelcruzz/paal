@extends('paal.root')

@push('pageTitle')
    Ingresos | Pagar
@endpush

@section('content')
    <div class="row">
        <div class="col-md-6">
            <solid-box title="Pagar adeudo de $ {{ number_format($ingress->debt, 2) }}" color="primary">
                {!! Form::open(['method' => 'POST', 'route' => ['paal.ingress.pay', $ingress]]) !!}

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::select('method', ['Efectivo', 'T. Débito', 'T. Crédito', 'Cheque', 'Transferencia'], null,
                                ['tpl' => 'withicon', 'empty' => 'Seleccione un método', 'v-model.number' => 'payment_method','required' => 'true'],
                                ['icon' => 'credit-card'])
                            !!}
                        </div>
                    </div>

                    <div v-if="payment_method > 0">
                        <div class="row">
                            <div class="col-md-6">
                                {!! Field::text('reference', ['tpl' => 'withicon', 'ph' => 'XXX-XXXX-XXXX', 'required' => 'true'], ['icon' => 'registered']) !!}
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="form-control btn btn-success btn-xs">
                                        <i class="fa fa-check"></i>&nbsp; P A G A R
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-else>
                        <div class="row">
                            <div class="col-md-6">
                                {!! Field::number('received', ['tpl' => 'withicon', 'v-model.number' => 'amount_received', 'required' => 'true'], ['icon' => 'money']) !!}
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Cambio</label>
                                    <span class="form-control" style="color: green">@{{ (amount_received - retainer).toFixed(2) }}</span>
                                </div>
                            </div>                                    
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="form-control btn btn-success btn-xs">
                                        <i class="fa fa-check"></i>&nbsp; P A G A R
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                {!! Form::close() !!}
            </solid-box>
        </div>
    </div>

@endsection
