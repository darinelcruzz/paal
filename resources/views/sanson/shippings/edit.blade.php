@extends('sanson.root')

@push('pageTitle')
    Envío | Entregado
@endpush

@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <solid-box title="Agregar información de entrega" color="info" button>

                {!! Form::open(['method' => 'POST', 'route' => ['sanson.shipping.update', $shipping]]) !!}

                	{!! Field::date('delivered_at', date('Y-m-d'), ['label' => 'Fecha entrega', 'tpl' => 'withicon'], ['icon' => 'calendar']) !!}
                	{!! Field::textarea('observations', ['tpl' => 'withicon', 'rows' => '2'], ['icon' => 'comment']) !!}

					<hr>

					<input type="hidden" name="status" value="entregado">
					
					{!! Form::submit('GUARDAR', ['class' => 'btn btn-info btn-sm btn-block']) !!}

				{!! Form::close() !!}

            </solid-box>
        </div>
    </div>

@endsection