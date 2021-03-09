@extends('sanson.root')

@push('pageTitle', 'Anticipos | Agregar')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <solid-box title="Agregar anticipo" color="info">
                {!! Form::open(['method' => 'POST', 'route' => ['sanson.retainer.store', $quotation]]) !!}

                    {!! Field::text('cliente', $quotation->client_name ?? $quotation->client->name, ['tpl' => 'withicon', 'disabled'], ['icon' => 'user']) !!}
                    
                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::text('invoice_id', ['tpl' => 'withicon'], ['icon' => 'list-ol']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::date('paid_at', date('Y-m-d'), ['label' => 'Fecha', 'tpl' => 'withicon'], ['icon' => 'calendar']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::text('importe', $quotation->amount, ['tpl' => 'withicon', 'disabled'], ['icon' => 'money']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::text('por pagar', $quotation->debt, ['tpl' => 'withicon', 'disabled'], ['icon' => 'hand-holding-usd']) !!}
                        </div>
                    </div>

                    

                    <payment-methods :top="{{ $quotation->debt }}"></payment-methods>

                    <input type="hidden" name="company" value="sanson">
                    <input type="hidden" name="invoice" value="G01">
                    <input type="hidden" name="folio" value="{{ $last_folio }}">
                    <input type="hidden" name="client_id" value="{{ $quotation->client->id }}">
                    <input type="hidden" name="bought_at" value="{{ date('Y-m-d') }}">
                    <input type="hidden" name="type" value="anticipo">
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    <input type="hidden" name="quotation_id" value="{{ $quotation->id }}">
                    <hr>

                    {!! Form::submit('A G R E G A R', ['class' => 'pull-right btn btn-info btn-md']) !!}
                {!! Form::close() !!}
            </solid-box>
        </div>
    </div>

@endsection
