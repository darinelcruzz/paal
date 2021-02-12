@extends('coffee.root')

@push('pageTitle', 'Anticipos | Agregar')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <solid-box title="Agregar anticipo" color="danger">
                {!! Form::open(['method' => 'POST', 'route' => 'coffee.retainer.store']) !!}

                    <client-select></client-select>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::text('folio', ['tpl' => 'withicon'], ['icon' => 'list-ol']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::date('retained_at', date('Y-m-d'), ['label' => 'Fecha', 'tpl' => 'withicon'], ['icon' => 'calendar']) !!}
                        </div>
                    </div>

                    <payment-methods></payment-methods>

                    <input type="hidden" name="company" value="coffee">
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    <hr>

                    {!! Form::submit('A G R E G A R', ['class' => 'pull-right btn btn-danger btn-md']) !!}
                {!! Form::close() !!}
            </solid-box>
        </div>
    </div>

@endsection
