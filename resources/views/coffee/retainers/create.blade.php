@extends('coffee.root')

@push('pageTitle', 'Anticipos | Agregar')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <solid-box title="Agregar anticipo" color="danger">
                {!! Form::open(['method' => 'POST', 'route' => ['coffee.retainer.store', $quotation]]) !!}

                    {!! Field::text('cliente', $quotation->client_name ?? $quotation->client->name, ['tpl' => 'withicon', 'disabled'], ['icon' => 'user']) !!}
                    
                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::text('folio', $last_folio, ['tpl' => 'withicon', 'disabled'], ['icon' => 'list-ol']) !!}
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

                    <input type="hidden" name="company" value="coffee">
                    <input type="hidden" name="company_id" value="2">
                    <input type="hidden" name="store_id" value="{{ $user->store_id }}">
                    <input type="hidden" name="invoice" value="no">
                    <input type="hidden" name="folio" value="{{ $last_folio }}">
                    <input type="hidden" name="client_id" value="{{ $quotation->client->id }}">
                    <input type="hidden" name="bought_at" value="{{ date('Y-m-d') }}">
                    <input type="hidden" name="type" value="anticipo">
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    <input type="hidden" name="quotation_id" value="{{ $quotation->id }}">
                    <hr>

                    {!! Form::submit('A G R E G A R', ['class' => 'pull-right btn btn-danger btn-md']) !!}
                {!! Form::close() !!}
            </solid-box>
        </div>
    </div>

@endsection
