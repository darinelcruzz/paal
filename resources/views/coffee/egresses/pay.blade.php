@extends('coffee.root')

@push('pageTitle')
    Egresos | Pagar
@endpush

@section('content')
    <div class="row">
        <div class="col-md-6">
            <solid-box title="Detalles del pago" color="danger" button>
                {!! Form::open(['method' => 'POST', 'route' => 'coffee.egress.settle', 'enctype' => 'multipart/form-data']) !!}

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::date('payment_date', Date::now(), ['tpl' => 'withicon'], ['icon' => 'dollar']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::select('method', ['check' => 'Cheque', 'transfer' => 'Transferencia'], null,
                                ['tpl' => 'withicon', 'empty' => 'Seleccione método', 'v-model' => 'pmethod'], ['icon' => 'credit-card']) 
                            !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::text('mfolio', ['label' => 'Folio', 'tpl' => 'withicon', 'ph' => 'XXXXXX'], ['icon' => 'barcode']) !!}
                        </div>
                        
                        <div class="col-md-6">
                            <label>Documento pago</label><br>
                            <file-upload bname="SUBIR PDF" fname="pdf_payment" ext="pdf" color="danger"></file-upload>
                        </div>
                    </div>

                    <hr>
                    <input type="hidden" name="id" value="{{ $egress->id }}">
                    {!! Form::submit('Pagar', ['class' => 'btn btn-danger pull-right']) !!}
                    
                {!! Form::close() !!}
            </solid-box>
        </div>
    </div>

@endsection