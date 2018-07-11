@extends('paal.root')

@push('pageTitle')
    Egresos | Cancelar
@endpush

@section('content')
    <div class="row">
        <div class="col-md-6">
            <solid-box title="Cancelación" color="primary" button>
                
                <b>{{ $egress->provider->name }}</b>
                <code class="pull-right">{{ $egress->folio }}</code>
                <br>
                {{ strtoupper($egress->company) }} <br>
                $ {{ number_format($egress->amount, 2) }}
                <br><br>

                {!! Form::open(['method' => 'POST', 'route' => ['paal.egress.cancel', $egress->id]]) !!}
                    {!! Field::textarea('observations', 
                        ['tpl' => 'withicon', 'label' => 'Escriba las razones de la cancelación', 'rows' => '3'], 
                        ['icon' => 'comment-o']) 
                    !!}
                    <input type="hidden" name="id" value="{{ $egress->id }}">
                    <input type="hidden" name="user" value="{{ auth()->user()->name }}">
                    <hr>
                    {!! Form::submit('Cancelar', ['class' => 'btn btn-primary pull-right']) !!}
                {!! Form::close() !!}
            </solid-box>
        </div>
    </div>

@endsection
    